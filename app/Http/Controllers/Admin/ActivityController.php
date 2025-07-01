<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $pendingActivities = Activity::where('status', 'pending')
                                    ->with('user')
                                    ->latest()
                                    ->get();
        
        return view('admin.activities.index', compact('pendingActivities'));
    }

    /**
     * Menyetujui sebuah aktivitas.
     */
    public function approve(Activity $activity)
    {
        // Atur jumlah poin yang diberikan (bisa dibuat dinamis nanti)
        $points = 50; 

        $activity->update([
            'status' => 'approved',
            'points_earned' => $points
        ]);

        return redirect()->route('admin.activities.index')->with('success', 'Aktivitas berhasil disetujui.');
    }

    /**
     * Menolak sebuah aktivitas.
     */
    public function reject(Activity $activity)
    {
        $activity->update(['status' => 'rejected']);

        return redirect()->route('admin.activities.index')->with('success', 'Aktivitas telah ditolak.');
    }
}