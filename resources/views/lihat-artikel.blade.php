<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel</title>

   @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .card-hover {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 
                        0 4px 6px -2px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <!-- HEADER -->
    <header class="sticky top-0 bg-white shadow-sm z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-900 tracking-tight">Artikel Komunis</a>
            <nav>
                <a href="#" class="text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-lg text-sm font-medium transition">Login</a>
            </nav>
        </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

        <!-- Tombol kembali -->
        <a href="/" class="inline-block mb-8 text-blue-600 hover:text-blue-800 text-sm font-medium">
            &larr; Kembali ke Beranda
        </a>

        <!-- COVER ARTIKEL -->
        <div class="w-full h-72 rounded-2xl overflow-hidden shadow-lg">
            <img src="https://via.placeholder.com/1200x600/90cdf4/ffffff?text=Cover+Artikel"
                 class="w-full h-full object-cover"
                 alt="Cover Artikel">
        </div>

        <!-- TAG + JUDUL -->
        <div class="mt-6">
            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-4 py-1 rounded-full">
                Teknologi
            </span>

            <h1 class="text-4xl font-extrabold text-gray-900 mt-4 tracking-tight">
                5 Tren AI yang Akan Mengubah Cara Kerja Kita
            </h1>

            <p class="text-gray-500 text-sm mt-2">
                Oleh <span class="font-semibold text-gray-700">Penulis A</span> • 15 November 2025
            </p>
        </div>

        <!-- KONTEN ARTIKEL -->
        <article class="mt-10 prose prose-lg max-w-none text-gray-700 leading-relaxed">
            <p>
                Kecerdasan buatan (AI) terus berkembang pesat dan memberikan dampak besar di berbagai bidang,
                termasuk dunia kerja. Dari otomatisasi proses hingga pengambilan keputusan berbasis data,
                teknologi ini semakin menjadi bagian integral dari kehidupan kita.
            </p>

            <h2>1. Otomatisasi Cerdas</h2>
            <p>
                AI memungkinkan perusahaan untuk mengotomatisasi tugas-tugas repetitif sehingga karyawan dapat
                fokus pada pekerjaan yang memerlukan kreativitas dan pemikiran strategis.
            </p>

            <h2>2. Kolaborasi Manusia dan Mesin</h2>
            <p>
                Banyak pekerjaan kini melibatkan interaksi antara manusia dan AI. Teknologi ini membantu mengurangi kesalahan,
                meningkatkan efisiensi, dan memberikan rekomendasi yang lebih akurat.
            </p>

            <h2>3. Personalisasi dalam Skala Besar</h2>
            <p>
                AI memungkinkan perusahaan untuk memberikan layanan dan produk yang lebih personal berdasarkan data pengguna.
            </p>

            <h2>4. Perkembangan Chatbot dan Asisten Virtual</h2>
            <p>
                Chatbot semakin canggih dan mampu menangani percakapan kompleks, memberikan layanan 24/7 kepada pelanggan.
            </p>

            <h2>5. Analisis Data Real-Time</h2>
            <p>
                Dengan AI, perusahaan dapat memproses data dalam jumlah besar secara real-time,
                memberikan insight yang lebih cepat untuk pengambilan keputusan.
            </p>

            <p>
                Dalam beberapa tahun ke depan, perkembangan AI diprediksi akan semakin pesat dan menciptakan peluang baru
                yang belum pernah ada sebelumnya.
            </p>
        </article>

        <!-- ARTIKEL TERKAIT -->
        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Artikel Terkait</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <a href="#" class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition card-hover">
                    <img class="h-40 w-full object-cover"
                         src="https://via.placeholder.com/600x400/b794f4/ffffff?text=Artikel+Terkait"
                         alt="">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900">Prinsip Desain Minimalis untuk UX Terbaik</h3>
                        <p class="mt-2 text-gray-500 text-sm">Menciptakan UI modern dan fungsional.</p>
                    </div>
                </a>

                <a href="#" class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition card-hover">
                    <img class="h-40 w-full object-cover"
                         src="https://via.placeholder.com/600x400/f6ad55/ffffff?text=Artikel+Terkait+2"
                         alt="">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900">AI dalam Industri Keuangan Modern</h3>
                        <p class="mt-2 text-gray-500 text-sm">Bagaimana AI mengubah cara analisa risiko.</p>
                    </div>
                </a>

            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-500">
            <p>&copy; 2025 Situs Komunis. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

</body>
</html>
