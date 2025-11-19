<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard — User</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white font-sans text-gray-800">

    <!-- Top bar -->
    <header class="w-full bg-white/60 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-2xl font-extrabold text-gray-900">Artikel Komunis</div>
                <span class="text-sm text-gray-500">Dashboard</span>
            </div>

            <div>
                <a href="/login"
                    class="px-4 py-2 bg-red-500 text-white rounded-xl shadow-sm hover:bg-red-600 transition">Logout</a>
            </div>
        </div>
    </header>

    <!-- Main: centered content -->
    <main class="py-12 px-6">
        <div class="max-w-7xl mx-auto">

            <!-- header card -->
            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900">Halo, Admin</h1>
                        <p class="text-gray-500 mt-1">Kelola artikelmu dengan mudah — lihat, edit, atau tambah artikel
                            baru.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="/user/create"
                            class="px-5 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-600 transition">
                            + Buat Artikel Baru
                        </a>

                        <a href="/"
                            class="px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 hover:shadow transition">
                            Lihat Situs
                        </a>
                    </div>
                </div>
            </div>

            <!-- article grid (dummy rows) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- card example 1 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="h-44 bg-gray-50 flex items-center justify-center">
                        <img src="https://via.placeholder.com/560x320" alt="cover" class="object-cover w-full h-full" />
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-sm bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-medium">Teknologi</span>
                            <span class="text-xs text-gray-400">Published: 2025-02-10</span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mt-3 line-clamp-2">5 Tren AI yang Akan Mengubah Cara
                            Kerja Kita</h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3">Pelajari bagaimana kecerdasan buatan
                            membentuk masa depan pekerjaan dan kehidupan...</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex gap-2">
                                <a href="/user/edit/1"
                                    class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Edit</a>
                                <a href="/user/delete/1"
                                    class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600">Hapus</a>
                            </div>

                            <a href="/articles/1" class="text-blue-600 font-medium hover:underline">Lihat</a>
                        </div>
                    </div>
                </div>

                <!-- card example 2 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="h-44 bg-gray-50 flex items-center justify-center">
                        <img src="https://via.placeholder.com/560x320" alt="cover" class="object-cover w-full h-full" />
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-sm bg-green-50 text-green-600 px-3 py-1 rounded-full font-medium">Desain</span>
                            <span class="text-xs text-gray-400">Published: 2025-01-22</span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mt-3 line-clamp-2">Prinsip Desain Minimalis untuk UX
                            Terbaik</h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3">Menciptakan pengalaman pengguna yang bersih
                            dan fokus pada inti...</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex gap-2">
                                <a href="/user/edit/2"
                                    class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Edit</a>
                                <a href="/user/delete/2"
                                    class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600">Hapus</a>
                            </div>

                            <a href="/articles/2" class="text-blue-600 font-medium hover:underline">Lihat</a>
                        </div>
                    </div>
                </div>

                <!-- card example 3 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="h-44 bg-gray-50 flex items-center justify-center">
                        <img src="https://via.placeholder.com/560x320" alt="cover" class="object-cover w-full h-full" />
                    </div>

                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-sm bg-purple-50 text-purple-600 px-3 py-1 rounded-full font-medium">Backend</span>
                            <span class="text-xs text-gray-400">Published: 2024-12-05</span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mt-3 line-clamp-2">Building RESTful APIs with Laravel
                        </h3>
                        <p class="text-sm text-gray-600 mt-2 line-clamp-3">Complete guide to building REST APIs using
                            Laravel's modern tooling...</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex gap-2">
                                <a href="/user/edit/3"
                                    class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">Edit</a>
                                <a href="/user/delete/3"
                                    class="px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600">Hapus</a>

                            </div>

                            <a href="/articles/3" class="text-blue-600 font-medium hover:underline">Lihat</a>
                        </div>
                    </div>
                </div>

            </div> <!-- end grid -->

            <!-- empty / hint -->
            <div class="mt-10 text-center text-sm text-gray-500">
                Semua konten di atas adalah dummy — backend & route management dilakukan terpisah.
            </div>

        </div>
    </main>
</body>

</html>