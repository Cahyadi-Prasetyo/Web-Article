@extends('layouts.admin')

@section('title', 'Detail Artikel')

@section('content')

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<div class="px-6 py-8">

    <!-- Loading state -->
    <div id="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
        <p class="mt-4 text-gray-500">Memuat artikel...</p>
    </div>

    <!-- Article detail -->
    <div id="article-detail" class="hidden">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail Artikel</h1>
            <a href="{{ route('list_article') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            
            <!-- Status Badge -->
            <div class="mb-6">
                <span id="status-badge" class="px-4 py-2 rounded-full text-sm font-semibold"></span>
            </div>

            <!-- Title -->
            <h2 id="article-title" class="text-3xl font-bold text-gray-900 mb-4"></h2>

            <!-- Meta info -->
            <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-6 pb-6 border-b">
                <div>
                    <span class="font-semibold">Penulis:</span>
                    <span id="article-author"></span>
                </div>
                <div>
                    <span class="font-semibold">Kategori:</span>
                    <span id="article-categories"></span>
                </div>
                <div>
                    <span class="font-semibold">Dibuat:</span>
                    <span id="article-created"></span>
                </div>
                <div id="published-date-container" class="hidden">
                    <span class="font-semibold">Dipublikasi:</span>
                    <span id="article-published"></span>
                </div>
            </div>

            <!-- Rejection reason (if rejected) -->
            <div id="rejection-reason-container" class="hidden mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm font-semibold text-red-700 mb-2">Alasan Penolakan:</p>
                <p id="rejection-reason" class="text-sm text-red-600"></p>
            </div>

            <!-- Excerpt -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Ringkasan</h3>
                <p id="article-excerpt" class="text-gray-600"></p>
            </div>

            <!-- Content -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Konten</h3>
                <div id="article-content" class="prose max-w-none text-gray-700 whitespace-pre-wrap"></div>
            </div>

            <!-- Actions -->
            <div id="actions-container" class="flex flex-wrap gap-3 pt-6 border-t">
                <!-- Actions will be loaded here based on status -->
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Tolak Artikel</h3>
            <p class="text-gray-600 mb-4">Berikan alasan penolakan artikel ini:</p>
            
            <textarea id="rejection-reason-input" rows="4" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                placeholder="Contoh: Konten tidak sesuai dengan standar editorial..."></textarea>
            
            <div class="flex gap-3 mt-6">
                <button onclick="closeRejectModal()" 
                    class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button onclick="confirmReject()" 
                    class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Tolak Artikel
                </button>
            </div>
        </div>
    </div>

</div>

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

    if (!token || !user || user.role !== 'admin') {
        window.location.href = '/login';
    }

    // Confirmation modal function with color option
    window.showConfirmModal = function(title, message, confirmText, onConfirm, color = 'blue') {
        const colors = {
            'blue': { bg: '#2563EB', hover: '#1D4ED8' },
            'red': { bg: '#DC2626', hover: '#B91C1C' },
            'green': { bg: '#16A34A', hover: '#15803D' },
            'yellow': { bg: '#CA8A04', hover: '#A16207' }
        };
        
        const btnColor = colors[color] || colors.blue;
        
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
                        style="flex: 1; padding: 8px 16px; background: ${btnColor.bg}; color: white; border-radius: 8px; border: none; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                        onmouseover="this.style.background='${btnColor.hover}'" 
                        onmouseout="this.style.background='${btnColor.bg}'">
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
        
        modal.onclick = (e) => {
            if (e.target === modal) modal.remove();
        };
    };

    // Get article ID from URL
    const articleId = {{ $id }};
    let currentArticle = null;

    // Load article
    async function loadArticle() {
        try {
            const response = await fetch('/api/admin/articles', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to load article');

            const data = await response.json();
            currentArticle = data.data.find(a => a.id === articleId);

            if (!currentArticle) {
                showToast('Artikel tidak ditemukan', 'error');
                setTimeout(() => {
                    window.location.href = '{{ route("list_article") }}';
                }, 2000);
                return;
            }

            displayArticle(currentArticle);
            
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('article-detail').classList.remove('hidden');
        } catch (error) {
            console.error('Error loading article:', error);
            showToast('Gagal memuat artikel', 'error');
            setTimeout(() => {
                window.location.href = '{{ route("list_article") }}';
            }, 2000);
        }
    }

    // Display article
    function displayArticle(article) {
        const statusColors = {
            'draft': 'bg-gray-100 text-gray-700',
            'pending': 'bg-yellow-100 text-yellow-700',
            'published': 'bg-green-100 text-green-700',
            'rejected': 'bg-red-100 text-red-700',
            'archived': 'bg-purple-100 text-purple-700'
        };

        // Status badge
        const statusBadge = document.getElementById('status-badge');
        statusBadge.textContent = article.status.toUpperCase();
        statusBadge.className = `px-4 py-2 rounded-full text-sm font-semibold ${statusColors[article.status]}`;

        // Article info
        document.getElementById('article-title').textContent = article.title;
        document.getElementById('article-author').textContent = article.author?.name || 'Unknown';
        document.getElementById('article-categories').textContent = article.categories;
        document.getElementById('article-created').textContent = new Date(article.created_at).toLocaleDateString('id-ID', {
            year: 'numeric', month: 'long', day: 'numeric'
        });

        if (article.published_at) {
            document.getElementById('published-date-container').classList.remove('hidden');
            document.getElementById('article-published').textContent = new Date(article.published_at).toLocaleDateString('id-ID', {
                year: 'numeric', month: 'long', day: 'numeric'
            });
        }

        // Rejection reason
        if (article.status === 'rejected' && article.rejection_reason) {
            document.getElementById('rejection-reason-container').classList.remove('hidden');
            document.getElementById('rejection-reason').textContent = article.rejection_reason;
        }

        document.getElementById('article-excerpt').textContent = article.excerpt;
        document.getElementById('article-content').textContent = article.content;

        // Actions based on status
        const actionsContainer = document.getElementById('actions-container');
        let actions = '';

        if (article.status === 'pending') {
            actions = `
                <button onclick="approveArticle()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    ✓ Approve & Publish
                </button>
                <button onclick="openRejectModal()" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                    ✗ Reject
                </button>
            `;
        } else if (article.status === 'published') {
            actions = `
                <button onclick="unpublishArticle()" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-semibold">
                    Unpublish
                </button>
                <a href="/articles/${article.slug}" target="_blank" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    Lihat di Situs
                </a>
            `;
        }

        actions += `
            <button onclick="deleteArticle()" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                Hapus Artikel
            </button>
        `;

        actionsContainer.innerHTML = actions;
    }

    // Approve article with confirmation (green button)
    window.approveArticle = function() {
        showConfirmModal(
            'Approve Artikel?',
            'Artikel ini akan dipublikasi dan tampil di halaman utama.',
            'Approve & Publish',
            async () => {
                showToast('Memproses approval...', 'info');

                try {
                    const response = await fetch(`/api/admin/articles/${articleId}/approve`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        showToast('✅ Artikel berhasil di-approve dan dipublish!', 'success');
                        setTimeout(() => loadArticle(), 1000);
                    } else {
                        const data = await response.json();
                        showToast(data.message || 'Gagal approve artikel', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat approve artikel', 'error');
                }
            },
            'green' // Green color for approve
        );
    };

    // Reject modal
    window.openRejectModal = function() {
        document.getElementById('reject-modal').classList.remove('hidden');
    };

    window.closeRejectModal = function() {
        document.getElementById('reject-modal').classList.add('hidden');
        document.getElementById('rejection-reason-input').value = '';
    };

    window.confirmReject = async function() {
        const reason = document.getElementById('rejection-reason-input').value.trim();

        if (!reason) {
            showToast('Alasan penolakan harus diisi', 'warning');
            return;
        }

        showToast('Memproses penolakan...', 'info');

        try {
            const response = await fetch(`/api/admin/articles/${articleId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ rejection_reason: reason })
            });

            if (response.ok) {
                showToast('❌ Artikel berhasil ditolak', 'success');
                closeRejectModal();
                setTimeout(() => loadArticle(), 1000);
            } else {
                const data = await response.json();
                showToast(data.message || 'Gagal reject artikel', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat reject artikel', 'error');
        }
    };

    // Unpublish article with confirmation (yellow button)
    window.unpublishArticle = function() {
        showConfirmModal(
            'Unpublish Artikel?',
            'Artikel ini akan dihapus dari halaman utama dan diarsipkan.',
            'Unpublish',
            async () => {
                showToast('Memproses unpublish...', 'info');

                try {
                    const response = await fetch(`/api/admin/articles/${articleId}/unpublish`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        showToast('📦 Artikel berhasil di-unpublish', 'success');
                        setTimeout(() => loadArticle(), 1000);
                    } else {
                        const data = await response.json();
                        showToast(data.message || 'Gagal unpublish artikel', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat unpublish artikel', 'error');
                }
            },
            'yellow' // Yellow color for unpublish
        );
    };

    // Delete article with confirmation (red button)
    window.deleteArticle = function() {
        showConfirmModal(
            'Hapus Artikel?',
            'Artikel ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!',
            'Hapus Permanen',
            async () => {
                showToast('Menghapus artikel...', 'info');

                try {
                    const response = await fetch(`/api/admin/articles/${articleId}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        showToast('🗑️ Artikel berhasil dihapus', 'success');
                        setTimeout(() => {
                            window.location.href = '{{ route("list_article") }}';
                        }, 2000);
                    } else {
                        const data = await response.json();
                        showToast(data.message || 'Gagal menghapus artikel', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus artikel', 'error');
                }
            },
            'red' // Red color for delete
        );
    };

    // Load article on page load
    loadArticle();
</script>

@endsection
