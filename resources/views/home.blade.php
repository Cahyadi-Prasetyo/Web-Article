<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Artikel Komunis</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
            <a href="/" class="text-2xl font-bold text-gray-900 tracking-tight">Artikel Komunis</a>
            <nav class="flex gap-3">
                <button id="user-menu" class="hidden text-gray-700 hover:text-blue-600 py-2 px-4 rounded-lg text-sm font-medium transition duration-150">
                    Dashboard
                </button>
                <a href="{{ route('login') }}" id="login-btn" class="text-white bg-blue-600 hover:bg-blue-700 py-2 px-4 rounded-lg text-sm font-medium transition duration-150">
                    Login
                </a>
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
            <h2 class="text-3xl font-bold text-gray-900 mb-10 pb-4 border-b-2 border-gray-200">
                Artikel Terbaru
            </h2>

            <!-- Loading state -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-500">Memuat artikel...</p>
            </div>

            <!-- Empty state -->
            <div id="empty-state" class="hidden text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasi</p>
            </div>

            <!-- Articles grid -->
            <div id="articles-grid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Articles will be loaded here -->
            </div>

            <div class="text-center mt-12">
                <p id="article-count" class="text-gray-500 text-sm"></p>
            </div>
        </section>

    </main>

    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-500">
            <p>&copy; 2025 Situs Komunis. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script type="module">
        // Check if user is logged in
        const token = localStorage.getItem('auth_token');
        const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;

        if (token && user) {
            document.getElementById('login-btn').classList.add('hidden');
            const userMenu = document.getElementById('user-menu');
            userMenu.classList.remove('hidden');
            userMenu.textContent = user.role === 'admin' ? 'Admin Dashboard' : 'Dashboard';
            userMenu.onclick = () => {
                window.location.href = user.role === 'admin' ? '/admin/dashboard' : '/user/dashboard';
            };
        }

        // Load published articles
        async function loadArticles() {
            try {
                const response = await fetch('/api/articles', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load articles');

                const data = await response.json();
                const articles = data.data || [];
                
                document.getElementById('loading').classList.add('hidden');
                
                if (articles.length === 0) {
                    document.getElementById('empty-state').classList.remove('hidden');
                } else {
                    displayArticles(articles);
                    document.getElementById('article-count').textContent = `Menampilkan ${articles.length} artikel`;
                }
            } catch (error) {
                console.error('Error loading articles:', error);
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('empty-state').classList.remove('hidden');
            }
        }

        // Display articles
        function displayArticles(articles) {
            const grid = document.getElementById('articles-grid');
            grid.classList.remove('hidden');
            
            const categoryColors = [
                'bg-blue-100 text-blue-800',
                'bg-purple-100 text-purple-800',
                'bg-green-100 text-green-800',
                'bg-yellow-100 text-yellow-800',
                'bg-pink-100 text-pink-800',
                'bg-indigo-100 text-indigo-800'
            ];
            
            grid.innerHTML = articles.map((article, index) => {
                const colorClass = categoryColors[index % categoryColors.length];
                const publishedDate = new Date(article.published_at).toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                return `
                    <a href="/articles/${article.slug}" class="block bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition duration-300 card-hover">
                        <div class="h-48 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                            <span class="text-6xl">📄</span>
                        </div>
                        <div class="p-6">
                            <span class="inline-block ${colorClass} text-xs font-medium px-3 py-1 rounded-full mb-3">
                                ${article.categories}
                            </span>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">${article.title}</h3>
                            <p class="text-gray-500 text-sm line-clamp-3">${article.excerpt}</p>
                            <p class="mt-4 text-xs text-gray-400">
                                Oleh: ${article.author?.name || 'Unknown'} | ${publishedDate}
                            </p>
                        </div>
                    </a>
                `;
            }).join('');
        }

        // Load articles on page load
        loadArticles();
    </script>

</body>

</html>
