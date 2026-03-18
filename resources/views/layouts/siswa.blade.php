<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <!-- Container Utama -->
    <div class="flex h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0">
            <div class="p-4">
                <h2 class="text-2xl font-bold">SiswaPortal</h2>
            </div>
            <nav class="mt-4">
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 bg-indigo-700">
                    <i class="fas fa-home mr-2"></i> Beranda
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                    <i class="fas fa-user mr-2"></i> Profil Saya
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                    <i class="fas fa-chart-line mr-2"></i> Nilai
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                    <i class="fas fa-calendar-alt mr-2"></i> Jadwal
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                    <i class="fas fa-bullhorn mr-2"></i> Pengumuman
                </a>
            </nav>
        </aside>

        <!-- Area Konten -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Selamat Datang -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Halo, {{ $siswa->nama }}! 👋</h2>
                    <p class="text-gray-600">Selamat datang kembali di portal siswa.</p>
                </div>

                <!-- Grid untuk Kartu Informasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Kartu Informasi Akun -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-id-card text-indigo-600 mr-2"></i> Informasi Akun
                        </h3>
                        <p class="text-sm text-gray-600"><strong>NIS:</strong> {{ $siswa->nis }}</p>
                        <p class="text-sm text-gray-600"><strong>Email:</strong> {{ $siswa->email ?? '-' }}</p>
                        <p class="text-sm text-gray-600"><strong>Kelas:</strong> XII RPL 1</p>
                        <p class="text-sm text-gray-600"><strong>Status:</strong> <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Aktif</span></p>
                    </div>

                    <!-- Kartu Pengumuman -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-bell text-yellow-500 mr-2"></i> Pengumuman
                        </h3>
                        <p class="text-sm text-gray-600">Belum ada pengumuman baru.</p>
                    </div>

                    <!-- Kartu Menu Cepat -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <i class="fas fa-rocket text-blue-500 mr-2"></i> Menu Cepat
                        </h3>
                        <div class="grid grid-cols-2 gap-2">
                            <a href="#" class="text-center p-2 rounded hover:bg-gray-100 transition">
                                <i class="fas fa-book text-blue-500"></i>
                                <p class="text-xs">Materi</p>
                            </a>
                            <a href="#" class="text-center p-2 rounded hover:bg-gray-100 transition">
                                <i class="fas fa-tasks text-green-500"></i>
                                <p class="text-xs">Tugas</p>
                            </a>
                            <a href="#" class="text-center p-2 rounded hover:bg-gray-100 transition">
                                <i class="fas fa-money-bill-wave text-yellow-500"></i>
                                <p class="text-xs">SPP</p>
                            </a>
                            <a href="#" class="text-center p-2 rounded hover:bg-gray-100 transition">
                                <i class="fas fa-cog text-gray-500"></i>
                                <p class="text-xs">Pengaturan</p>
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>