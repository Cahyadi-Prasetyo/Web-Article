<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hapus Artikel</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100">

    <!-- FULL SCREEN POPUP -->
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center">

        <div class="bg-white p-8 rounded-3xl shadow-xl w-96">
            <h2 class="text-xl font-bold text-gray-900">Hapus Artikel?</h2>
            <p class="text-gray-600 mt-2">
                Yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="mt-6 flex gap-3">
                <a href="/user/dashboard" class="w-full text-center px-4 py-2 bg-gray-200 rounded-xl hover:bg-gray-300">
                    Batal
                </a>

                <button class="w-full px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
                    Hapus (Dummy)
                </button>
            </div>
        </div>

    </div>

</body>

</html>