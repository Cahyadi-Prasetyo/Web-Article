@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali, Admin</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="refreshData()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Artikel -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Artikel</p>
                    <p id="total-articles" class="text-4xl font-bold mt-2">-</p>
                    <p class="text-blue-100 text-xs mt-2">Semua status</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Review -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Pending Review</p>
                    <p id="pending-articles" class="text-4xl font-bold mt-2">-</p>
                    <p class="text-yellow-100 text-xs mt-2">Menunggu approval</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Published -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Published</p>
                    <p id="published-articles" class="text-4xl font-bold mt-2">-</p>
                    <p class="text-green-100 text-xs mt-2">Artikel aktif</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Rejected -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Rejected</p>
                    <p id="rejected-articles" class="text-4xl font-bold mt-2">-</p>
                    <p class="text-red-100 text-xs mt-2">Artikel ditolak</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Artikel Pending Review (2/3 width) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-lg p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Artikel Menunggu Review</h3>
                    </div>
                    <a href="{{ route('list_article') }}" class="text-white hover:text-blue-100 font-medium text-sm flex items-center gap-1 transition">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <div id="pending-list" class="p-6">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions (1/3 width) -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Actions
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('list_article') }}" class="flex items-center justify-between p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition group">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Kelola Artikel</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('list_article') }}?filter=pending" class="flex items-center justify-between p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition group">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-yellow-700">Review Pending</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="/" target="_blank" class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition group">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">Lihat Website</span>
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Activity Summary -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Aktivitas Hari Ini
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-purple-100 text-sm">Artikel Baru</span>
                        <span id="today-new" class="text-xl font-bold">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-100 text-sm">Artikel Approved</span>
                        <span id="today-approved" class="text-xl font-bold">0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-100 text-sm">Artikel Rejected</span>
                        <span id="today-rejected" class="text-xl font-bold">0</span>
                    </div>
                </div>
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
            <button onclick="this.parentElement.remove()" class="ml-4 rounded p-1">
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

    // Load statistics
    async function loadStats() {
        try {
            const response = await fetch('/api/admin/articles', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to load stats');

            const data = await response.json();
            const articles = data.data || [];

            // Count by status
            const stats = {
                total: articles.length,
                pending: articles.filter(a => a.status === 'pending').length,
                published: articles.filter(a => a.status === 'published').length,
                rejected: articles.filter(a => a.status === 'rejected').length
            };

            // Animate numbers
            animateValue('total-articles', 0, stats.total, 1000);
            animateValue('pending-articles', 0, stats.pending, 1000);
            animateValue('published-articles', 0, stats.published, 1000);
            animateValue('rejected-articles', 0, stats.rejected, 1000);

            // Today's activity (mock data - you can calculate from created_at)
            const today = new Date().toDateString();
            const todayArticles = articles.filter(a => new Date(a.created_at).toDateString() === today);
            document.getElementById('today-new').textContent = todayArticles.length;
            document.getElementById('today-approved').textContent = todayArticles.filter(a => a.status === 'published').length;
            document.getElementById('today-rejected').textContent = todayArticles.filter(a => a.status === 'rejected').length;

        } catch (error) {
            console.error('Error loading stats:', error);
            showToast('Gagal memuat statistik', 'error');
        }
    }

    // Animate number counting
    function animateValue(id, start, end, duration) {
        const element = document.getElementById(id);
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current);
        }, 16);
    }

    // Load pending articles
    async function loadPendingArticles() {
        try {
            const response = await fetch('/api/admin/articles/pending', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to load pending articles');

            const data = await response.json();
            const articles = data.data || [];

            const listDiv = document.getElementById('pending-list');

            if (articles.length === 0) {
                listDiv.innerHTML = `
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500 font-medium">Tidak ada artikel pending</p>
                        <p class="text-gray-400 text-sm mt-1">Semua artikel sudah direview</p>
                    </div>
                `;
                return;
            }

            listDiv.innerHTML = `
                <div class="space-y-3">
                    ${articles.slice(0, 5).map((article, index) => `
                        <div class="group relative bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-4 hover:shadow-md transition-all duration-200 hover:border-blue-300">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                    ${index + 1}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition line-clamp-1">
                                        ${article.title}
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            ${article.author?.name || 'Unknown'}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            ${new Date(article.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}
                                        </span>
                                    </p>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            ${article.categories}
                                        </span>
                                    </div>
                                </div>
                                <a href="/admin/articles/${article.id}" class="flex-shrink-0 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm font-medium flex items-center gap-2 group-hover:shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Review
                                </a>
                            </div>
                        </div>
                    `).join('')}
                </div>
            `;

        } catch (error) {
            console.error('Error loading pending articles:', error);
            document.getElementById('pending-list').innerHTML = `
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-red-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-500 font-medium">Gagal memuat data</p>
                </div>
            `;
            showToast('Gagal memuat artikel pending', 'error');
        }
    }

    // Refresh data
    window.refreshData = async function() {
        showToast('Memuat ulang data...', 'info');
        await Promise.all([loadStats(), loadPendingArticles()]);
        showToast('Data berhasil dimuat ulang', 'success');
    };

    // Load data on page load
    loadStats();
    loadPendingArticles();

    // Show welcome toast only once per session (after login)
    const hasShownWelcome = sessionStorage.getItem('admin_welcome_shown');
    if (!hasShownWelcome) {
        setTimeout(() => {
            showToast('🎉 Selamat datang, Admin!', 'success');
            sessionStorage.setItem('admin_welcome_shown', 'true');
        }, 500);
    }
</script>

@endsection
