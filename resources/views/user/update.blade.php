<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Edit Artikel</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white font-sans text-gray-800">

    <!-- Top bar -->
    <header class="w-full bg-white/60 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-2xl font-extrabold text-gray-900">Artikel Komunis</div>
                <span class="text-sm text-gray-500">Edit Artikel</span>
            </div>
    </header>

    <!-- Main -->
    <main class="flex items-start justify-center py-14 px-6">
        <div class="w-full max-w-3xl">

            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h1 class="text-3xl font-extrabold text-gray-900">Edit Artikel</h1>
                    <p class="text-gray-500 mt-1">Tampilan saja (dummy).</p>
                </div>

                <div class="p-8">
                    <form class="space-y-6">

                        <!-- title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
                            <input type="text" value="Contoh Judul Artikel"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-400">
                        </div>

                        <!-- categories + slug -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                <input type="text" value="Laravel,PHP"
                                    class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-400">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                                <input type="text" value="contoh-slug-artikel"
                                    class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-400">
                            </div>
                        </div>

                        <!-- excerpt -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea rows="3"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-400">Ini adalah contoh excerpt artikel.</textarea>
                        </div>

                        <!-- content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konten</label>
                            <textarea rows="8"
                                class="block w-full rounded-2xl border border-gray-200 px-4 py-4 shadow-sm focus:ring-2 focus:ring-blue-400">Ini konten panjang artikel (dummy).</textarea>
                        </div>

                        <!-- image -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Artikel</label>
                                <div class="flex items-center gap-4">
                                    <label
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm cursor-pointer hover:bg-blue-700 transition">
                                        <input type="file" class="hidden" />
                                        Pilih Gambar
                                    </label>
                                    <span class="text-sm text-gray-500">Tidak terhubung ke backend</span>
                                </div>

                                <div class="mt-3">
                                    <img src="https://via.placeholder.com/150"
                                        class="w-32 h-32 object-cover rounded-xl border" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select
                                    class="block w-full rounded-xl border border-gray-200 px-4 py-3 shadow-sm focus:ring-2 focus:ring-blue-400">
                                    <option selected>Draft</option>
                                    <option>Publish</option>
                                </select>
                            </div>
                        </div>

                        <!-- actions -->
                        <div class="flex flex-col md:flex-row gap-3 mt-4">
                            <a href="/user/dashboard"
                                class="px-6 py-3 rounded-xl border border-gray-200 bg-white text-gray-700 text-center hover:shadow-md">Batal</a>

                            <button type="button"
                                class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700">
                                Update (Dummy)
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </main>

</body>

</html>