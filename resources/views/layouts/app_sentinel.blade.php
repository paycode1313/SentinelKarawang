<!DOCTYPE html>
<html lang="id">
<head>
    <!-- ... Bagian head yang sudah ada ... -->
    <style>
        /* ... Style yang sudah ada ... */
        
        /* Tambahan style untuk notifikasi */
        #notification-dropdown {
            transform: translateY(10px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            width: 24rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        #notification-dropdown.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        
        .notification-item {
            transition: background-color 0.2s ease;
        }
        
        .notification-item.unread {
            background-color: #f0f7ff;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bmkg-bg-primary shadow-md sticky w-full z-30 top-0">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- ... Bagian kiri navbar ... -->
                <div class="flex items-center">
                    <div class="hidden md:flex items-center">
                        <!-- Tombol Notifikasi -->
                        @auth
                        <div class="relative mr-4">
                            <button id="notification-button" class="text-gray-300 hover:text-white p-2 rounded-full relative focus:outline-none" aria-label="Notifikasi">
                                <i class="fas fa-bell fa-lg"></i>
                                <span class="notification-badge absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">3</span>
                            </button>
                            <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl z-50 border border-gray-200">
                                <div class="px-4 py-3 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-800">Notifikasi</h3>
                                </div>
                                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 notification-item unread">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-bmkg-blue flex items-center justify-center">
                                                    <i class="fas fa-info-circle text-white"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Pembayaran Insentif</p>
                                                <p class="text-xs text-gray-500">Insentif bulan Juni telah dibayarkan</p>
                                                <p class="text-xs text-gray-400 mt-1">2 jam yang lalu</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 notification-item">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-bmkg-accent flex items-center justify-center">
                                                    <i class="fas fa-check-circle text-white"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Laporan Diterima</p>
                                                <p class="text-xs text-gray-500">Laporan Anda tanggal 25 Juni telah diverifikasi</p>
                                                <p class="text-xs text-gray-400 mt-1">1 hari yang lalu</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="px-4 py-2 bg-gray-50 text-center">
                                   <!-- Ganti route('notifications.index') dengan route('notifications.index') -->
<a href="{{ route('notifications.index') }}" class="text-sm font-medium text-bmkg-blue hover:text-bmkg-secondary">
    Lihat Semua
</a>
                                </div>
                            </div>
                        </div>
                        @endauth
                        
                        <!-- Dropdown Profil (sudah ada) -->
                    </div>
                    <!-- Tombol Mobile Menu -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu-container" class="fixed inset-0 bg-gray-900 bg-opacity-95 z-50 p-6 hidden">
        <!-- ... Konten mobile menu yang sudah ada ... -->
        <a href="{{ route('notifications.index') }}" class="mobile-menu-item text-2xl text-gray-200">Notifikasi
            <span class="notification-badge-mobile ml-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">3</span>
        </a>
        <!-- ... Menu lainnya ... -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... Kode yang sudah ada ...
            
            // Notifikasi dropdown toggle
            const notificationButton = document.getElementById('notification-button');
            const notificationDropdown = document.getElementById('notification-dropdown');
            
            if (notificationButton && notificationDropdown) {
                notificationButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    if (notificationDropdown.classList.contains('show')) {
                        notificationDropdown.classList.remove('show');
                        setTimeout(() => {
                            notificationDropdown.classList.add('hidden');
                        }, 300);
                    } else {
                        notificationDropdown.classList.remove('hidden');
                        setTimeout(() => {
                            notificationDropdown.classList.add('show');
                        }, 10);
                    }
                    
                    // Sembunyikan badge setelah notifikasi dilihat
                    const badge = this.querySelector('.notification-badge');
                    badge.classList.add('hidden');
                    
                    // Sembunyikan badge di mobile juga
                    const mobileBadge = document.querySelector('.notification-badge-mobile');
                    if (mobileBadge) {
                        mobileBadge.classList.add('hidden');
                    }
                });
                
                // Tutup dropdown notifikasi ketika klik di luar
                document.addEventListener('click', function(e) {
                    if (!notificationDropdown.contains(e.target) && !notificationButton.contains(e.target)) {
                        if (notificationDropdown.classList.contains('show')) {
                            notificationDropdown.classList.remove('show');
                            setTimeout(() => {
                                notificationDropdown.classList.add('hidden');
                            }, 300);
                        }
                    }
                });
            }
            
            // Simulasikan notifikasi baru (bisa dihapus di production)
            setTimeout(() => {
                const badges = document.querySelectorAll('.notification-badge, .notification-badge-mobile');
                badges.forEach(badge => {
                    badge.classList.remove('hidden');
                });
            }, 3000);
        });
    </script>
</body>
</html>