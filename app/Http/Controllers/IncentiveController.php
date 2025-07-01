<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incentive;
use App\Models\Activity;
use App\Models\UserIncentive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class IncentiveController extends Controller
{
    /**
     * Menampilkan daftar program insentif yang tersedia.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $incentives = Incentive::where('is_active', true)->get();

        $userPoints = 0;
        if (Auth::check()) {
            $userPoints = Auth::user()->activities()->where('status', 'approved')->sum('points_earned');
            $claimedPoints = Auth::user()->userIncentives()->where('status', 'redeemed')->sum(
                DB::raw('(SELECT points_required FROM incentives WHERE incentives.id = user_incentives.incentive_id)')
            );
            $userPoints -= $claimedPoints;
        }

        return view('incentives.index', compact('incentives', 'userPoints'));
    }

    /**
     * Menampilkan formulir untuk mengajukan aktivitas lingkungan.
     *
     * @return \Illuminate\View\View
     */
    public function createActivity()
    {
        return view('incentives.create_activity');
    }

    /**
     * Menyimpan aktivitas yang diajukan oleh pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeActivity(Request $request)
    {
        if (!Auth::check()) {
            Log::warning('Percobaan pengajuan aktivitas tanpa autentikasi, padahal seharusnya sudah dicek middleware.');
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengajukan aktivitas.');
        }

        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_lat' => 'nullable|numeric',
            'location_lon' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'activity_date' => 'required|date',
        ]);

        $user = Auth::user();

        $imagePath = null;
        if ($request->hasFile('image')) {
            try {
                $imagePath = $request->file('image')->store('activity_proofs', 'public');
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan gambar aktivitas: ' . $e->getMessage());
                return back()->withInput()->withErrors(['image' => 'Gagal mengunggah gambar. Silakan coba lagi.']);
            }
        }

        try {
            $activity = $user->activities()->create([
                'type' => $validatedData['type'],
                'description' => $validatedData['description'],
                'location_lat' => $validatedData['location_lat'],
                'location_lon' => $validatedData['location_lon'],
                'image_url' => $imagePath,
                'activity_date' => $validatedData['activity_date'],
                'status' => 'pending',
                'points_earned' => 0,
            ]);

            Log::info('Aktivitas baru diajukan oleh user: ' . $user->id, ['activity_id' => $activity->id]);
            return redirect()->route('dashboard')->with('success', 'Aktivitas Anda berhasil diajukan dan sedang menunggu verifikasi!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal saat mengajukan aktivitas: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan tak terduga saat menyimpan aktivitas: ' . $e->getMessage(), ['user_id' => $user->id ?? 'guest']);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan aktivitas. Silakan coba lagi.');
        }
    }

    /**
     * Memproses permintaan klaim insentif oleh pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incentive  $incentive
     * @return \Illuminate\Http\RedirectResponse
     */
    public function claimIncentive(Request $request, Incentive $incentive)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengklaim insentif.');
        }

        $userPoints = $user->activities()->where('status', 'approved')->sum('points_earned');
        $claimedPoints = $user->userIncentives()->where('status', 'redeemed')->sum(
            DB::raw('(SELECT points_required FROM incentives WHERE incentives.id = user_incentives.incentive_id)')
        );
        $currentAvailablePoints = $userPoints - $claimedPoints;

        if (!$incentive->is_active) {
            return back()->with('error', 'Insentif ini tidak lagi aktif.');
        }

        if ($incentive->stock !== null && $incentive->stock <= 0) {
            return back()->with('error', 'Maaf, stok insentif ini sudah habis.');
        }

        if ($currentAvailablePoints < $incentive->points_required) {
            return back()->with('error', 'Poin Anda tidak mencukupi untuk mengklaim insentif ini. Anda membutuhkan ' . $incentive->points_required . ' poin.');
        }

        DB::beginTransaction();

        try {
            UserIncentive::create([
                'user_id' => $user->id,
                'incentive_id' => $incentive->id,
                'status' => 'redeemed',
                'redeemed_at' => now(),
            ]);

            if ($incentive->stock !== null) {
                $incentive->decrement('stock');
            }

            DB::commit();

            Log::info('Insentif diklaim oleh user: ' . $user->id, ['incentive_id' => $incentive->id, 'remaining_points' => $currentAvailablePoints - $incentive->points_required]);
            return back()->with('success', 'Selamat! Anda berhasil mengklaim insentif ' . $incentive->name . '. Poin Anda telah dikurangi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mengklaim insentif: ' . $e->getMessage(), ['user_id' => $user->id, 'incentive_id' => $incentive->id]);
            return back()->with('error', 'Terjadi kesalahan saat mengklaim insentif. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan riwayat aktivitas dan klaim insentif pengguna.
     * Metode ini dilindungi middleware 'auth' dan 'verified'.
     *
     * @return \Illuminate\View\View
     */
    public function userHistory()
    {
        $user = Auth::user();

        // Poin tersedia saat ini
        $userPoints = $user->activities()->where('status', 'approved')->sum('points_earned');
        $claimedPoints = $user->userIncentives()->where('status', 'redeemed')->sum(
            DB::raw('(SELECT points_required FROM incentives WHERE incentives.id = user_incentives.incentive_id)')
        );
        $currentAvailablePoints = $userPoints - $claimedPoints;

        // Riwayat aktivitas yang diajukan (dengan relasi user)
        $activities = $user->activities()->with('user') // load relasi user jika diperlukan, meski di history user sendiri
                            ->orderBy('activity_date', 'desc')
                            ->get();

        // Riwayat klaim insentif (dengan relasi incentive dan user)
        $claimedIncentives = $user->userIncentives()->with('incentive', 'user')
                                    ->orderBy('redeemed_at', 'desc')
                                    ->get();

        return view('incentives.history', compact('activities', 'claimedIncentives', 'currentAvailablePoints'));
    }
}
