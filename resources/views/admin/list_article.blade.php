@extends('layouts.admin')

@section('title', 'Manajemen Artikel')

@section('content')

<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<div class="px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Artikel</h1>
    </div>

    <!-- Filter tabs -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <button onclick="filterArticles('all')" class="filter-btn px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">
            Semua
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
        <button onclick="filterArticles('draft')" class="filter-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
            Draft
        </button>
        <button onclick="filterArticles('archived')" class="filter-btn px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
            Archived
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">

        <!-- Loading state -->
        <div id="loading" class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p class="mt-4 text-gray-500">Memuat artikel...</p>
        </div>

        <!-- Table -->
        <div id="table-container" class="hidden overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Penulis</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody id="articles-tbody" class="bg-white divide-y divide-gray-200">
                    <!-- Articles will be loaded here -->
                </tbody>
            </table>
        </div>

        <!-- Empty state -->
        <div id="empty-state" class="hidden text-center py-12">
            <p class="text-gray-500 text-lg">Tidak ada artikel</p>
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

    let currentFilter = 'all';
    let allArticles = [];

    // Check auth
    const token = localStorage.getItem('auth_token');
    const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;

    if (!token || !user || user.role !== 'admin') {
        window.location.href = '/login';
    }

    // Load articles
    async function loadArticles() {
        try {
            const url = currentFilter === 'all' 
                ? '/api/admin/articles' 
                : `/api/admin/articles?status=${currentFilter}`;

            const response = await fetch(url, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Failed to load articles');

            const data = await response.json();
            allArticles = data.data || [];
            
            document.getElementById('loading').classList.add('hidden');
            
            if (allArticles.length === 0) {
                document.getElementById('table-container').classList.add('hidden');
                document.getElementById('empty-state').classList.remove('hidden');
            } else {
                document.getElementById('empty-state').classList.add('hidden');
                document.getElementById('table-container').classList.remove('hidden');
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
        const tbody = document.getElementById('articles-tbody');
        
        const statusColors = {
            'draft': 'bg-gray-100 text-gray-700',
            'pending': 'bg-yellow-100 text-yellow-700',
            'published': 'bg-green-100 text-green-700',
            'rejected': 'bg-red-100 text-red-700',
            'archived': 'bg-purple-100 text-purple-700'
        };
        
        tbody.innerHTML = articles.map((article, index) => `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-sm text-gray-600">${index + 1}</td>
                <td class="px-4 py-3 text-sm font-semibold text-gray-800 max-w-xs truncate">
                    ${article.title}
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">${article.author?.name || 'Unknown'}</td>
                <td class="px-4 py-3 text-sm text-gray-600">${article.categories}</td>
                <td class="px-4 py-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusColors[article.status] || 'bg-gray-100 text-gray-700'}">
                        ${article.status.toUpperCase()}
                    </span>
                </td>
                <td class="px-4 py-3 text-sm text-gray-600">
                    ${new Date(article.created_at).toLocaleDateString('id-ID')}
                </td>
                <td class="px-4 py-3 text-center">
                    <a href="/admin/articles/${article.id}"
                       class="px-3 py-1 rounded bg-blue-600 text-white text-xs hover:bg-blue-700 transition">
                        Detail
                    </a>
                </td>
            </tr>
        `).join('');
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
        
        // Reload articles
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('table-container').classList.add('hidden');
        document.getElementById('empty-state').classList.add('hidden');
        loadArticles();
    };

    // Load articles on page load
    loadArticles();
</script>

@endsection
