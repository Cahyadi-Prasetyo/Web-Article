<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | Artikel Komunis</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans min-h-screen antialiased">

    <header class="sticky top-0 bg-white shadow-lg z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold text-blue-600 tracking-wider hover:text-blue-700 transition duration-150">
                Artikel Komunis
            </a>
        </div>
    </header>

    <main class="flex items-center justify-center min-h-[85vh] px-4 fade-in py-8">
        <div class="bg-white p-8 w-full max-w-md rounded-xl shadow-2xl shadow-gray-200 border border-gray-100">

            <h2 class="text-3xl font-bold text-gray-900 text-center mb-1">
                Daftar Akun Baru
            </h2>

            <p class="text-center text-gray-500 mb-8 text-base">
                Buat akun untuk mulai menulis artikel.
            </p>

            <!-- Error Message -->
            <div id="error-message" class="hidden mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            </div>

            <!-- Success Message -->
            <div id="success-message" class="hidden mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            </div>

            <form id="register-form">

                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="John Doe"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900
                               focus:ring-blue-500 focus:border-blue-500 focus:bg-white shadow-sm transition 
                               duration-150 ease-in-out placeholder-gray-400">
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nama.pengguna@domain.com"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900
                               focus:ring-blue-500 focus:border-blue-500 focus:bg-white shadow-sm transition 
                               duration-150 ease-in-out placeholder-gray-400">
                </div>

                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900
                               focus:ring-blue-500 focus:border-blue-500 focus:bg-white shadow-sm transition
                               duration-150 ease-in-out placeholder-gray-400">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ketik ulang password"
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-gray-50 text-gray-900
                               focus:ring-blue-500 focus:border-blue-500 focus:bg-white shadow-sm transition
                               duration-150 ease-in-out placeholder-gray-400">
                </div>

                <button
                    type="submit"
                    id="register-btn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-bold text-lg 
                           shadow-lg shadow-blue-500/50 transition duration-300 transform hover:scale-[1.01]">
                    Daftar
                </button>

                <a href="{{ route('login') }}"
                    class="block mt-4 text-center w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-xl font-semibold 
                           transition duration-200 text-lg">
                    Sudah Punya Akun? Login
                </a>

                <a href="/"
                    class="block mt-4 text-center w-full text-blue-600 hover:text-blue-800 py-2.5 rounded-xl font-semibold 
                           transition duration-200 text-sm">
                    ← Kembali ke Halaman Utama
                </a>

            </form>

        </div>
    </main>

    <footer class="bg-white border-t border-gray-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-xs text-gray-500">
            <p>&copy; 2025 Situs Komunis. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;
            const errorDiv = document.getElementById('error-message');
            const successDiv = document.getElementById('success-message');
            const registerBtn = document.getElementById('register-btn');
            
            // Reset messages
            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            registerBtn.disabled = true;
            registerBtn.textContent = 'Loading...';
            
            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ name, email, password, password_confirmation })
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    // Simpan token dan user data
                    localStorage.setItem('auth_token', data.token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    
                    // Clear welcome toast flag
                    sessionStorage.removeItem('user_welcome_shown');
                    
                    // Tampilkan success message
                    errorDiv.classList.add('hidden');
                    successDiv.textContent = '✅ Registrasi berhasil! Mengalihkan ke dashboard...';
                    successDiv.classList.remove('hidden');
                    
                    // Redirect ke dashboard user
                    setTimeout(() => {
                        window.location.href = '/user/dashboard';
                    }, 1500);
                } else {
                    // Tampilkan error
                    if (data.errors) {
                        const errorMessages = Object.values(data.errors).flat().join(', ');
                        errorDiv.textContent = errorMessages;
                    } else {
                        errorDiv.textContent = data.message || 'Registrasi gagal';
                    }
                    errorDiv.classList.remove('hidden');
                }
            } catch (error) {
                errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                errorDiv.classList.remove('hidden');
            } finally {
                registerBtn.disabled = false;
                registerBtn.textContent = 'Daftar';
            }
        });
    </script>

</body>

</html>
