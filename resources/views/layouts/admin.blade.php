<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .min-h-screen-minus-header {
            min-height: calc(100vh - 4rem); /* tinggi navbar 4rem */
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-20 h-16 flex items-center">
        <div class="max-w-full w-full px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>

            <div class="flex items-center space-x-4">
                <button class="text-gray-500 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </button>

                <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                    AD
                </div>
            </div>
        </div>
    </header>

    <div class="flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-xl min-h-screen-minus-header sticky top-16 z-10 p-4 pt-8">
            <nav class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" data-menu="dashboard"
                   class="menu-link flex items-center px-4 py-2 text-sm rounded-lg transition duration-150 text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-10v10a1 1 0 001 1h3m-9-6h2m-2 0h2m-2 0h2"/>
                    </svg>
                    Dashboard
                </a>

                <!-- Daftar Artikel -->
                <a href="{{ route('list_article') }}" data-menu="articles"
                   class="menu-link flex items-center px-4 py-2 text-sm rounded-lg transition text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 0h2a2 2 0 012 2v10a2 2 0 01-2 2h-4m-12-6a4 4 0 110-8 4 4 0 010 8z"/>
                    </svg>
                    Daftar Artikel
                </a>

                <!-- Pengguna
                <a href="#" data-menu="users"
                   class="menu-link flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20h-5v-2a3 3 0 00-5.356-1.857M9 20l-5-5-5-5m9-5a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Pengguna
                </a> -->

            </nav>

            <!-- Logout -->
            <div class="mt-16 pt-4 border-t">
                <button onclick="handleLogout()"
                   class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </div>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script>
        // Check auth on page load
        const token = localStorage.getItem('auth_token');
        const user = localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null;

        if (!token || !user || user.role !== 'admin') {
            window.location.href = '/login';
        }

        // Set active menu based on current URL
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('.menu-link');
            
            menuLinks.forEach(link => {
                const href = link.getAttribute('href');
                const menu = link.getAttribute('data-menu');
                
                // Check if current path matches the link
                let isActive = false;
                
                if (menu === 'dashboard' && currentPath === '/admin/dashboard') {
                    isActive = true;
                } else if (menu === 'articles' && currentPath.includes('/admin/articles')) {
                    isActive = true;
                } else if (menu === 'users' && currentPath.includes('/admin/users')) {
                    isActive = true;
                }
                
                // Apply active styles
                if (isActive) {
                    link.classList.remove('text-gray-700', 'hover:bg-gray-100', 'hover:text-blue-600');
                    link.classList.add('bg-blue-600', 'text-white', 'shadow');
                } else {
                    link.classList.remove('bg-blue-600', 'text-white', 'shadow');
                    link.classList.add('text-gray-700', 'hover:bg-gray-100', 'hover:text-blue-600');
                }
            });
        });

        // Toast notification function (if not already defined)
        if (typeof window.showToast === 'undefined') {
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

                let container = document.getElementById('toast-container');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    container.className = 'fixed top-4 right-4 z-50 space-y-2';
                    document.body.appendChild(container);
                }
                container.appendChild(toast);

                setTimeout(() => {
                    toast.style.transform = 'translateX(400px)';
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            };
        }

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
            
            modal.onclick = (e) => {
                if (e.target === modal) modal.remove();
            };
        };

        // Logout function with confirmation
        window.handleLogout = function() {
            showConfirmModal(
                'Logout?',
                'Anda akan keluar dari akun admin.',
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
    </script>

</body>
</html>
