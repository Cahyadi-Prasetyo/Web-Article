@extends('layouts.admin')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="px-6 py-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Artikel</h1>

    <div class="bg-white rounded-xl shadow-md p-6">

        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Penulis</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">

                <!-- Dummy Row -->
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-600">1</td>

                    <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                        Contoh Judul Artikel
                    </td>

                    <td class="px-4 py-3 text-sm text-gray-600">Nama Penulis</td>

                    <td class="px-4 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                            Pending
                        </span>
                    </td>

                    <td class="px-4 py-3 text-center">
                        <a href="article/1"
                           class="px-3 py-1 rounded bg-blue-600 text-white text-xs hover:bg-blue-700 transition">
                            Lihat
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</div>
@endsection
