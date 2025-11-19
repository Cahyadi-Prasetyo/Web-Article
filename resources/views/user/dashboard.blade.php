<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — User</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-50 to-white font-sans text-gray-800">

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[10000] space-y-2"></div>

    <!-- Top bar -->
    <header class="w-full bg-white/60 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-2xl font-extrabold text-gray-900">Artikel Komunis</div>
                <span class="text-sm text-gray-500">Dashboard User</span>
            </div>

            <div class="flex items-center gap-4">
                <span id="user-name" class="text-sm text-gray-600"></span>
                <button onclick="handleLogout()"
                    class="px-4 py-2 bg-red-500 text-white rounded-xl shadow-sm hover:bg-red-600 transition">
                    Logout
                </button>
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
                        <h1 class="text-3xl font-extrabold text-gray-900">Halo, <span id="welcome-name">User</span>!</h1>
                        <p class="text-gray-500 mt-1">Kelola artikelmu dengan mudah — lihat, edit, atau tambah artikel baru.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="/user/create"
                            class="px-5 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-600 transition">
                            + Buat Artikel Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter tabs -->
            <div class="mb-6 flex gap-2 flex-wrap">
                <button onclick="filterArticles('all')" class="filter-btn px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
                    Semua
                </button>
                <button onclick="filterArticles('draft')" class="filter-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Draft
                </button>
                <button onclick="filterArticles('pending')" class="filter-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Pending
                </button>
                <button onclick="filterArticles('published')" class="filter-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Published
                </button>
                <button onclick="filterArticles('rejected')" class="filter-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                    Rejected
                </button>
            </div>

            <!-- Loading state -->
            <div id="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-500">Memuat artikel...</p>
            </div>

            <!-- Empty state -->
            <div id="empty-state" class="hidden text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada artikel. Buat artikel pertamamu!</p>
            </div>

            <!-- article grid -->
            <div id="articles-grid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Articles will be loaded here -->
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

        // Confirmation modal function
        window.showConfirmModal = function(title, message, confirmText, onConfirm) {
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(2px);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 99999;
            `;
            modal.innerHTML = `
                <div style="background: white; border-radius: 12px; padding: 24px; max-width: 28rem; width: 100%; margin: 0 16px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); position: relative; z-index: 100000;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin-bottom: 12px;">${title}</h3>
                    <p style="color: #4B5563; margin-bottom: 24px;">${message}</p>
                    <div style="display: flex; gap: 12px;">
                        <button onclick="this.closest('[style*=fixed]').remove()" 
                            style="flex: 1; padding: 8px 16px; background: #E5E7EB; color: #374151; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                            onmouseover="this.style.background='#D1D5DB'" 
                            onmouseout="this.style.background='#E5E7EB'">
                            Batal
                        </button>
                        <button id="confirm-btn"
                            style="flex: 1; padding: 8px 16px; background: #DC2626; color: white; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                            onmouseover="this.style.background='#B91C1C'" 
                            onmouseout="this.style.background='#DC2626'">
                            ${confirmText}
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            modal.querySelector('#confirm-btn').onclick = () => {
                modal.remove();
                onConfirm();
            };
            
            // Close on backdrop click
            modal.onclick = (e) => {
                if (e.target === modal) modal.remove();
            };
        };

        let currentFilter = 'all';
        let allArticles = [];

        // Check auth
        const token = localStorage.getItem('auth_token');
        const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;

        if (!token || !user) {
            showToast('Silakan login terlebih dahulu', 'warning');
            setTimeout(() => {
                window.location.href = '/login';
            }, 2000);
        }

        // Display user name
        document.getElementById('user-name').textContent = user.name;
        document.getElementById('welcome-name').textContent = user.name;

        // Logout function with confirmation
        window.handleLogout = function() {
            showConfirmModal(
                'Logout?',
                'Anda akan keluar dari akun ini.',
                'Logout',
                async () => {
                    showToast('Logging out...', 'info');
                    
                    try {
                        await fetch('/api/logout', {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json'
                            }
                        });
                    } catch (error) {
                        console.error('Logout error:', error);
                    }
                    
                    // Clear all storage
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('user');
                    sessionStorage.clear(); // Clear welcome toast flags
                    
                    showToast('👋 Logout berhasil!', 'success');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1500);
                }
            );
        };

        // Load articles
        async function loadArticles() {
            try {
                const response = await fetch('/api/my-articles', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Failed to load articles');
                }

                const data = await response.json();
                allArticles = data.data || [];
                
                document.getElementById('loading').classList.add('hidden');
                
                if (allArticles.length === 0) {
                    document.getElementById('empty-state').classList.remove('hidden');
                } else {
                    displayArticles(allArticles);
                }
            } catch (error) {
                console.error('Error loading articles:', error);
                document.getElementById('loading').classList.add('hidden');
                showToast('Gagal memuat artikel', 'error');
            }
        }

        // Display articles
        function displayArticles(articles) {
            const grid = document.getElementById('articles-grid');
            const emptyState = document.getElementById('empty-state');
            
            if (articles.length === 0) {
                grid.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }
            
            emptyState.classList.add('hidden');
            grid.classList.remove('hidden');
            
            grid.innerHTML = articles.map(article => {
                const statusColors = {
                    'draft': 'bg-gray-100 text-gray-700',
                    'pending': 'bg-yellow-100 text-yellow-700',
                    'published': 'bg-green-100 text-green-700',
                    'rejected': 'bg-red-100 text-red-700',
                    'archived': 'bg-purple-100 text-purple-700'
                };
                
                const canEdit = ['draft', 'rejected'].includes(article.status);
                const canDelete = ['draft', 'rejected'].includes(article.status);
                
                // Status info text
                let statusInfo = '';
                if (article.status === 'pending') {
                    statusInfo = '<p class="text-xs text-blue-600 mb-3">⏳ Menunggu review admin...</p>';
                } else if (article.status === 'published') {
                    statusInfo = '<p class="text-xs text-green-600 mb-3">✅ Artikel sudah dipublikasi!</p>';
                }
                
                return `
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="h-44 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                            <span class="text-4xl">📄</span>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm ${statusColors[article.status] || 'bg-gray-100 text-gray-700'} px-3 py-1 rounded-full font-medium">
                                    ${article.status.toUpperCase()}
                                </span>
                                <span class="text-xs text-gray-400">${new Date(article.created_at).toLocaleDateString('id-ID')}</span>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">${article.title}</h3>
                            <p class="text-sm text-gray-600 mb-2 line-clamp-2">${article.excerpt || 'Tidak ada deskripsi'}</p>
                            <p class="text-xs text-gray-400 mb-4">Kategori: ${article.categories}</p>

                            ${statusInfo}

                            ${article.status === 'rejected' && article.rejection_reason ? `
                                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-xs text-red-700"><strong>Alasan ditolak:</strong> ${article.rejection_reason}</p>
                                    <p class="text-xs text-red-600 mt-2">💡 Edit artikel dan publish ulang untuk submit review lagi</p>
                                </div>
                            ` : ''}

                            <div class="flex flex-wrap gap-2">
                                ${canEdit ? `
                                    <button onclick="editArticle(${article.id})" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm">
                                        ✏️ Edit
                                    </button>
                                ` : ''}
                                
                                ${canDelete ? `
                                    <button onclick="deleteArticle(${article.id})" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                        🗑️ Hapus
                                    </button>
                                ` : ''}
                                
                                ${article.status === 'published' ? `
                                    <a href="/articles/${article.slug}" target="_blank" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-sm">
                                        👁️ Lihat
                                    </a>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Filter articles
        window.filterArticles = function(status) {
            currentFilter = status;
            
            // Update button styles
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            event.target.classList.remove('bg-gray-200', 'text-gray-700');
            event.target.classList.add('bg-blue-600', 'text-white');
            
            // Filter articles
            const filtered = status === 'all' 
                ? allArticles 
                : allArticles.filter(a => a.status === status);
            
            displayArticles(filtered);
        };

        // Delete article with confirmation modal
        window.deleteArticle = function(id) {
            showConfirmModal(
                'Hapus Artikel?',
                'Artikel ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.',
                'Hapus',
                async () => {
                    showToast('Menghapus artikel...', 'info');
                    
                    try {
                        const response = await fetch(`/api/my-articles/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Accept': 'application/json'
                            }
                        });

                        if (response.ok) {
                            showToast('🗑️ Artikel berhasil dihapus!', 'success');
                            setTimeout(() => loadArticles(), 1000);
                        } else {
                            showToast('Gagal menghapus artikel', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan saat menghapus artikel', 'error');
                    }
                }
            );
        };

        // Edit article (redirect to edit page)
        window.editArticle = function(id) {
            window.location.href = `/user/edit/${id}`;
        };

        // Load articles on page load
        loadArticles();
    </script>

</body>

</html>
