<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title id="page-title">Artikel | Artikel Komunis</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans">

    <header class="sticky top-0 bg-white shadow-sm z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-gray-900 tracking-tight">Artikel Komunis</a>
            <nav>
                <a href="/" class="text-gray-700 hover:text-blue-600 py-2 px-4 rounded-lg text-sm font-medium transition duration-150">
                    ← Kembali ke Home
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <!-- Loading state -->
        <div id="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-500">Memuat artikel...</p>
        </div>

        <!-- Article content -->
        <article id="article-content" class="hidden bg-white rounded-xl shadow-lg p-8 md:p-12">
            
            <!-- Category badge -->
            <div class="mb-4">
                <span id="article-category" class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-3 py-1 rounded-full"></span>
            </div>

            <!-- Title -->
            <h1 id="article-title" class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6"></h1>

            <!-- Meta info -->
            <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-8 pb-8 border-b">
                <div>
                    <span class="font-semibold">Penulis:</span>
                    <span id="article-author"></span>
                </div>
                <div>
                    <span class="font-semibold">Dipublikasi:</span>
                    <span id="article-date"></span>
                </div>
            </div>

            <!-- Excerpt -->
            <div class="mb-8 p-6 bg-blue-50 border-l-4 border-blue-600 rounded-r-lg">
                <p id="article-excerpt" class="text-lg text-gray-700 italic"></p>
            </div>

            <!-- Content -->
            <div id="article-body" class="prose prose-lg max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">
            </div>

            <!-- Back button -->
            <div class="mt-12 pt-8 border-t">
                <a href="/" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    ← Kembali ke Beranda
                </a>
            </div>
        </article>

        <!-- Error state -->
        <div id="error-state" class="hidden text-center py-12">
            <p class="text-red-500 text-lg mb-4">Artikel tidak ditemukan</p>
            <a href="/" class="text-blue-600 hover:text-blue-700 font-medium">
                ← Kembali ke Beranda
            </a>
        </div>

    </main>

    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-sm text-gray-500">
            <p>&copy; 2025 Situs Komunis. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script type="module">
        // Get slug from URL
        const pathParts = window.location.pathname.split('/');
        const slug = pathParts[pathParts.length - 1];

        // Load article
        async function loadArticle() {
            try {
                const response = await fetch(`/api/articles/${slug}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Article not found');
                }

                const article = await response.json();
                displayArticle(article);
                
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('article-content').classList.remove('hidden');
            } catch (error) {
                console.error('Error loading article:', error);
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('error-state').classList.remove('hidden');
            }
        }

        // Display article
        function displayArticle(article) {
            document.getElementById('page-title').textContent = `${article.title} | Artikel Komunis`;
            document.getElementById('article-category').textContent = article.categories;
            document.getElementById('article-title').textContent = article.title;
            document.getElementById('article-author').textContent = article.author?.name || 'Unknown';
            
            const publishedDate = new Date(article.published_at).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('article-date').textContent = publishedDate;
            
            document.getElementById('article-excerpt').textContent = article.excerpt;
            document.getElementById('article-body').textContent = article.content;
        }

        // Load article on page load
        loadArticle();
    </script>

</body>

</html>
