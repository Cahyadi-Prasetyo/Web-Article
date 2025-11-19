@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')
<div class="px-6 py-8">

    <a href="../dashboard" class="text-blue-600 hover:underline text-sm mb-4 inline-block">
        ← Kembali ke daftar
    </a>

    <!-- Judul -->
    <h1 class="text-3xl font-bold text-gray-800 mb-4">
        Contoh Judul Artikel
    </h1>

    <!-- Info Penulis -->
    <p class="text-gray-600 mb-6">
        Ditulis oleh <span class="font-semibold">Nama Penulis</span> — 18 Nov 2025
    </p>

    <!-- Isi Artikel -->
    <div class="bg-white p-6 rounded-xl shadow-md mb-8 leading-relaxed text-gray-800">
        <p>
            Ini adalah isi artikel contoh. Admin dapat membaca isi artikel di halaman ini sebelum melakukan validasi.
            Konten artikel akan ditampilkan lengkap di bagian ini.
        </p>
    </div>

    <!-- Validasi -->
    <div class="bg-white p-6 rounded-xl shadow-md">

        <h3 class="text-xl font-semibold text-gray-800 mb-4">Validasi Artikel</h3>

        <div class="flex gap-3">

            <button class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition">
                Set Publish
            </button>

            <button class="px-4 py-2 rounded bg-yellow-500 text-white hover:bg-yellow-600 transition">
                Set Pending
            </button>

            <button class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition">
                Set Reject
            </button>

        </div>

    </div>

</div>
@endsection
