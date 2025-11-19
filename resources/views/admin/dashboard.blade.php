<!-- resources/views/admin/dashboard.blade.php -->

<!-- Mengambil kerangka dari layout admin -->
@extends('layouts.admin')

<!-- Mengganti Title di tab browser -->
@section('title', 'Dashboard Ringkasan')

<!-- Mengisi slot 'content' di layout admin -->
@section('content')
    
    <h2 class="text-3xl font-extrabold text-gray-800 mb-8">Ringkasan Data</h2>

    <!-- Cards Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <!-- Card 1: Total Artikel -->
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
            <p class="text-sm font-medium text-gray-500">Total Artikel</p>
            <p class="text-4xl font-bold text-gray-900 mt-1">1,240</p>
            <p class="text-xs text-green-500 mt-2">+12% dari bulan lalu</p>
        </div>

        <!-- Card 2: Pengunjung Hari Ini -->
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
            <p class="text-sm font-medium text-gray-500">Pengunjung Hari Ini</p>
            <p class="text-4xl font-bold text-gray-900 mt-1">4,890</p>
            <p class="text-xs text-red-500 mt-2">-5% dari kemarin</p>
        </div>
        
        <!-- Card 3: Pengguna Baru -->
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500">
            <p class="text-sm font-medium text-gray-500">Pengguna Baru</p>
            <p class="text-4xl font-bold text-gray-900 mt-1">15</p>
            <p class="text-xs text-gray-400 mt-2">Daftar hari ini</p>
        </div>
    </div>

    <!-- Bagian Grafik dan Konten Lain -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Col 1: Aktivitas Artikel Terbaru (2/3 lebar) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Artikel Terbaru</h3>
            <p class="text-gray-500">Di sinilah grafik atau tabel data terbaru akan dimuat.</p>
            <table class="min-w-full mt-4 divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 tracking-wider">Judul</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 tracking-wider">Penulis</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 tracking-wider">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Strategi Pemasaran Digital 2025</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">Budi</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">18 Nov 2025</td>
                        <td class="px-4 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Publish</span></td>
                    </tr>
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Review Teknologi XR Terbaru</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">Siti</td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">17 Nov 2025</td>
                        <td class="px-4 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Draft</span></td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>

@endsection