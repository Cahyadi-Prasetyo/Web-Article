<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Artikel</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white font-sans text-gray-800">

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Top bar -->
    <header class="w-full bg-white/60 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-2xl font-extrabold text-gray-900">Artikel Komunis</div>
                <span class="text-sm text-gray-500">Edit Artikel</span>
            </div>
            <a href="/user/dashboard" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition">
                ← Kembali
            </a>
        </div>
    </header>

    <!-- Main -->
    <main class="flex items-start justify-center py-14 px-6">
        <div class="w-full max-w-3xl">

            <!-- Loading state -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-500">Memuat artikel...</p>
            </div>

            <div id="form-container" class="hidden bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100">
                    <h1 class="text-3xl font-extrabold text-gray-900">Edit Artikel</h1>
                    <p class="text-gray-500 mt-1">Perbarui data artikel.</p>
                </div>

                <!-- Error Message -->
                <div id="error-message" class="hidden mx-8 mt-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                </div>

                <div class="p-8">
                    <form id="update-form" class="space-y-6">

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required placeholder="Masukkan judul artikel"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                            <input type="text" name="categories" id="categories" required placeholder="Contoh: Teknologi, Programming"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat <span class="text-red-500">*</span></label>
                            <textarea name="excerpt" id="excerpt" required rows="3" placeholder="Ringkasan artikel"
                                class="block w-full rounded-xl border border-gray-200 px-4 py-3 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konten Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="content" id="content" required rows="12" placeholder="Tulis isi artikel di sini..."
                                class="block w-full rounded-2xl border border-gray-200 px-4 py-4 text-base shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"></textarea>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex flex-col md:flex-row gap-3 md:gap-4 mt-4">
                            <a href="/user/dashboard"
                                class="inline-block w-full md:w-auto text-center px-6 py-3 rounded-xl border border-gray-200 bg-white text-gray-700 hover:shadow-md transition">
                                Batal
                            </a>

                            <button type="button" onclick="submitForm('draft')" id="draft-btn"
                                class="inline-block w-full md:w-auto px-6 py-3 rounded-xl bg-gray-600 text-white font-semibold shadow-lg hover:bg-gray-700 transition">
                                💾 Simpan ke Draft
                            </button>

                            <button type="button" onclick="submitForm('publish')" id="publish-btn"
                                class="inline-block w-full md:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-600 transition">
                                🚀 Publish (Submit Review)
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </main>

    <script type="module">
        // Toast notification function
        window.showToast = function(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            }[type] || 'bg-gray-500';

            const icon = {
                'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
            }[type];

            toast.className = `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 transform transition-all duration-300 translate-x-0 opacity-100`;
            toast.innerHTML = `
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icon}
                </svg>
                <span class="font-medium">${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-4 hover:bg-white hover:bg-opacity-20 rounded p-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;

            document.getElementById('toast-container').appendChild(toast);

            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        };

        // Check auth
        const token = localStorage.getItem('auth_token');
        const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;

        if (!token || !user) {
            showToast('Silakan login terlebih dahulu', 'warning');
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        }

        // Get article ID from URL
        const articleId = {{ $id }};

        // Load article data
        async function loadArticle() {
            try {
                const response = await fetch('/api/my-articles', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load article');
                }

                const data = await response.json();
                const article = data.data.find(a => a.id === articleId);

                if (!article) {
                    showToast('Artikel tidak ditemukan', 'error');
                    setTimeout(() => {
                        window.location.href = '/user/dashboard';
                    }, 2000);
                    return;
                }

                // Check if can edit
                if (!['draft', 'rejected'].includes(article.status)) {
                    showToast('Artikel dengan status ' + article.status + ' tidak dapat diedit', 'warning');
                    setTimeout(() => {
                        window.location.href = '/user/dashboard';
                    }, 2000);
                    return;
                }

                // Fill form
                document.getElementById('title').value = article.title;
                document.getElementById('categories').value = article.categories;
                document.getElementById('excerpt').value = article.excerpt;
                document.getElementById('content').value = article.content;

                // Show form
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('form-container').classList.remove('hidden');
            } catch (error) {
                console.error('Error loading article:', error);
                showToast('Gagal memuat artikel', 'error');
                setTimeout(() => {
                    window.location.href = '/user/dashboard';
                }, 2000);
            }
        }

        // Submit form with action (draft or publish)
        window.submitForm = async function(action) {
            const title = document.getElementById('title').value;
            const categories = document.getElementById('categories').value;
            const excerpt = document.getElementById('excerpt').value;
            const content = document.getElementById('content').value;
            const errorDiv = document.getElementById('error-message');
            const draftBtn = document.getElementById('draft-btn');
            const publishBtn = document.getElementById('publish-btn');
            
            // Validation
            if (!title || !categories || !excerpt || !content) {
                errorDiv.textContent = 'Semua field harus diisi!';
                errorDiv.classList.remove('hidden');
                return;
            }
            
            // Reset error
            errorDiv.classList.add('hidden');
            draftBtn.disabled = true;
            publishBtn.disabled = true;
            
            if (action === 'draft') {
                draftBtn.textContent = 'Menyimpan...';
            } else {
                publishBtn.textContent = 'Mengirim...';
            }
            
            try {
                const response = await fetch(`/api/my-articles/${articleId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({ 
                        title, 
                        categories, 
                        excerpt, 
                        content,
                        action // 'draft' atau 'publish'
                    })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    if (action === 'draft') {
                        showToast('✅ Artikel berhasil disimpan sebagai draft!', 'success');
                    } else {
                        showToast('✅ Artikel berhasil dikirim untuk review admin!', 'success');
                    }
                    setTimeout(() => {
                        window.location.href = '/user/dashboard';
                    }, 2000);
                } else {
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join(', ');
                        errorDiv.textContent = errorMessages;
                    } else {
                        errorDiv.textContent = data.message || 'Gagal mengupdate artikel';
                    }
                    errorDiv.classList.remove('hidden');
                }
            } catch (error) {
                errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                errorDiv.classList.remove('hidden');
            } finally {
                draftBtn.disabled = false;
                publishBtn.disabled = false;
                draftBtn.textContent = '💾 Simpan ke Draft';
                publishBtn.textContent = '🚀 Publish (Submit Review)';
            }
        };

        // Load article on page load
        loadArticle();
    </script>

</body>

</html>
