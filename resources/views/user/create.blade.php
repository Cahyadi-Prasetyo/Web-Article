<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Buat Artikel</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white font-sans text-gray-800">

    <!-- Top bar (minimal) -->
    <header class="w-full bg-white/60 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-2xl font-extrabold text-gray-900">Artikel Komunis</div>
                <span class="text-sm text-gray-500">User Dashboard</span>
            </div>
    </header>

    <!-- Main: centered premium card -->
    <main class="flex items-start justify-center py-14 px-6">
        <div class="w-full max-w-3xl">

            <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h1 class="text-3xl font-extrabold text-gray-900">Buat Artikel Baru</h1>
                    <p class="text-gray-500 mt-1">Isi data artikel sesuai kolom.</p>
                </div>

                <div class="p-8">
                    <!-- NOTE: form ini hanya tampilan (dummy). Kalau mau submit ke backend, tambahkan action & method -->
                    <form enctype="multipart/form-data" class="space-y-6">

                        <!-- row: title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul (title)</label>
                            <input type="text" name="title" placeholder="Masukkan judul artikel"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                        </div>

                        <!-- row: categories & slug (side-by-side on wide screens) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori
                                    (categories)</label>
                                <input type="text" name="categories" placeholder="Contoh: Laravel,PHP,Frontend"
                                    class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Slug (slug)</label>
                                <input type="text" name="slug" placeholder="contoh-slug-artikel"
                                    class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                            </div>
                        </div>

                        <!-- row: excerpt -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat
                                (excerpt)</label>
                            <textarea name="excerpt" rows="3" placeholder="Ringkasan / excerpt singkat"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>
                        </div>

                        <!-- row: content (big) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konten Lengkap (content)</label>
                            <textarea name="content" rows="8" placeholder="Tulis isi artikel di sini..."
                                class="block w-full rounded-2xl border border-gray-200 px-4 py-4 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>
                        </div>

                        <!-- row: image upload + status -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Artikel
                                    (image)</label>
                                <div class="flex items-center gap-4">
                                    <label
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm cursor-pointer hover:bg-blue-700 transition">
                                        <input type="file" name="image" class="hidden" />
                                        Pilih Gambar
                                    </label>
                                    <span class="text-sm text-gray-500">PNG / JPG / WEBP — maksimal 2MB (contoh)</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status"
                                    class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="draft">Draft</option>
                                    <option value="published">Publish</option>
                                </select>
                            </div>
                        </div>

                        <!-- hidden author_id (dummy) -->
                        <input type="hidden" name="author_id" value="1" />

                        <!-- info row -->
                        <div class="text-sm text-gray-500 italic">
                            *published_at akan ditetapkan otomatis oleh backend (tidak perlu diisi di form ini)
                        </div>

                        <!-- action buttons -->
                        <div class="flex flex-col md:flex-row gap-3 md:gap-4 mt-4">
                            <a href="/user/dashboard"
                                class="inline-block w-full md:w-auto text-center px-6 py-3 rounded-xl border border-gray-200 bg-white text-gray-700 hover:shadow-md transition">
                                Batal
                            </a>

                            <button type="button"
                                class="inline-block w-full md:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-600 transition">
                                Simpan (Dummy)
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Small footer note under card -->
            <div class="mt-6 text-center text-sm text-gray-500">
                Tampilan hanya demonstrasi. Integrasi backend ditangani terpisah.
            </div>
        </div>
    </main>

</body>

</html>