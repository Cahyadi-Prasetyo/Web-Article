<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Komunis</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* CSS tambahan untuk transisi dan efek hover yang halus */
        .card-hover {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-4px); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <header class="sticky top-0 bg-white shadow-sm z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-gray-900 tracking-tight">Artikel Komunis</a>
            <nav>
                <a href="#" class="text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-lg text-sm font-medium transition duration-150">Login</a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <section class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                Sumber Inspirasi dan Informasi Terbaru
            </h1>
            <p class="text-xl text-gray-500 mb-8 max-w-3xl mx-auto">
                Temukan artikel-artikel mendalam, tips praktis, dan berita terkini dari berbagai topik pilihan.
            </p>
            <a href="#featured" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 shadow-lg transition duration-300 transform hover:scale-105">
                Lihat Artikel Pilihan &rarr;
            </a>
        </section>

        <section id="featured" class="mt-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-10 pb-4 border-b-2 border-gray-200 mb-8">
                Artikel Pilihan Minggu Ini
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <a href="#" class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 card-hover">
                    <img class="h-48 w-full object-cover" src="https://via.placeholder.com/600x400/90cdf4/ffffff?text=Image+1" alt="Article Cover">
                    <div class="p-6">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full mb-3">Teknologi</span>                        
                        <h3 class="text-xl font-bold text-gray-900 mb-3">5 Tren AI yang Akan Mengubah Cara Kerja Kita</h3>
                        <p class="text-gray-500 text-sm">Pelajari bagaimana kecerdasan buatan membentuk masa depan pekerjaan dan kehidupan sehari-hari.</p>
                        <p class="mt-4 text-xs text-gray-400">Oleh: Penulis A | 15 November 2025</p>
                    </div>
                </a>

                <a href="#" class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 card-hover">
                    <img class="h-48 w-full object-cover" src="https://via.placeholder.com/600x400/b794f4/ffffff?text=Image+2" alt="Article Cover">
                    <div class="p-6">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full mb-3">Desain</span>                  
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Prinsip Desain Minimalis untuk UX Terbaik</h3>
                        <p class="text-gray-500 text-sm">Menciptakan pengalaman pengguna yang bersih, intuitif, dan bebas dari distraksi.</p>
                        <p class="mt-4 text-xs text-gray-400">Oleh: Penulis B | 10 November 2025</p>
                    </div>
                </a>

                <a href="#" class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 card-hover">
                    <img class="h-48 w-full object-cover" src="https://via.placeholder.com/600x400/f6ad55/ffffff?text=Image+3" alt="Article Cover">
                    <div class="p-6">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full mb-3">Teknologi</span>             
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Strategi Investasi Jangka Panjang untuk Pemula</h3>
                        <p class="text-gray-500 text-sm">Panduan langkah demi langkah untuk membangun portofolio investasi yang stabil.</p>
                        <p class="mt-4 text-xs text-gray-400">Oleh: Penulis C | 8 November 2025</p>
                    </div>
                </a>
            </div>
            
            <div class="text-center mt-12">
                 <a href="#" class="inline-flex items-center justify-center px-6 py-3 border border-blue-600 text-base font-medium rounded-lg text-blue-600 hover:text-white hover:bg-blue-600 transition duration-300">
                    Lihat Semua Artikel
                </a>
            </div>
        </section>

    </main>

    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-500">
            <p>&copy; 2025 Situs Komunis. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>
    
</body>
</html>