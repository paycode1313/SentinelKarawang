@extends('layouts.app_sentinel')

@section('title', 'Laporkan Aktivitas - Sentinel Karawang')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">
    <!-- Header -->
    <header class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Laporkan Aktivitas Lingkungan</h1>
        <p class="text-gray-500 mt-2">Dukung Karawang dengan aksi nyata Anda dan dapatkan penghargaan poin.</p>
    </header>

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ url()->previous(route('dashboard')) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8">
        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md">
                <p class="font-bold mb-2">Terjadi Kesalahan:</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('incentives.store-activity') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Tipe Aktivitas -->
            <div>
                <label for="type" class="block mb-2 font-medium text-gray-700">Tipe Aktivitas</label>
                <select id="type" name="type" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200">
                    <option value="">Pilih Tipe Aktivitas...</option>
                    <option value="tree_planting" @selected(old('type') == 'tree_planting')>Penanaman Pohon</option>
                    <option value="river_cleaning" @selected(old('type') == 'river_cleaning')>Pembersihan Sungai</option>
                    <option value="pollution_report" @selected(old('type') == 'pollution_report')>Pelaporan Pencemaran</option>
                    <option value="waste_sorting" @selected(old('type') == 'waste_sorting')>Pemilahan Sampah</option>
                    <option value="recycling" @selected(old('type') == 'recycling')>Kegiatan Daur Ulang</option>
                    <option value="education" @selected(old('type') == 'education')>Edukasi Lingkungan</option>
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block mb-2 font-medium text-gray-700">Deskripsi Singkat Aktivitas</label>
                <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200" placeholder="Contoh: Menanam 10 pohon mahoni di tepi jalan raya Klari.">{{ old('description') }}</textarea>
            </div>

            <!-- Tanggal & Lokasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="activity_date" class="block mb-2 font-medium text-gray-700">Tanggal Aktivitas</label>
                    <input type="date" id="activity_date" name="activity_date" required class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200" value="{{ old('activity_date') }}">
                </div>
                <div>
                    <label for="location" class="block mb-2 font-medium text-gray-700">Lokasi (Nama Jalan/Daerah)</label>
                    <input type="text" id="location" name="location" class="w-full border border-gray-300 rounded-lg p-3 focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-200" placeholder="Contoh: Jl. Tuparev, Karawang Barat" value="{{ old('location') }}">
                </div>
            </div>

            <!-- Unggah Foto -->
            <div>
                <label for="image" class="block mb-2 font-medium text-gray-700">Foto Bukti (Opsional)</label>
                <label for="image" class="block border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition duration-200">
                    <div id="file-input-content">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-600 font-semibold">Klik untuk mengunggah foto</p>
                        <p class="text-sm text-gray-500">Format: JPG, PNG. Max 2MB</p>
                    </div>
                </label>
                <input type="file" id="image" name="image" accept="image/*" class="hidden">
            </div>

            <!-- Tombol Kirim -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 hover:shadow-lg flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Laporan Aktivitas
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script untuk File Input dan Tanggal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('image');
        const fileInputContent = document.getElementById('file-input-content');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileInputContent.innerHTML = `
                        <i class="fas fa-file-image text-green-500 text-4xl mb-2"></i>
                        <p class="font-semibold text-green-600">File dipilih:</p>
                        <p class="text-sm text-gray-600 truncate">${fileName}</p>
                    `;
                }
            });
        }
        
        const dateInput = document.getElementById('activity_date');
        if (dateInput && !dateInput.value) {
            const today = new Date();
            today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
            dateInput.value = today.toISOString().split('T')[0];
        }
    });
</script>
@endsection