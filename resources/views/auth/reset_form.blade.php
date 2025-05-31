<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            500: '#3a7bd5',
                            600: '#2c6bc7',
                        },
                        gradient: {
                            start: '#3a7bd5',
                            end: '#00d2ff',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center animate-fade-in">
        <!-- Header -->
        <div class="mb-6">
            <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-gradient-start to-gradient-end rounded-full flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800">Ubah Password</h2>
            <p class="text-sm text-gray-500 mt-1">Masukkan password baru Anda</p>
        </div>

        <!-- Error -->
        @if ($errors->any())
            <div class="mb-4 px-4 py-2 bg-red-50 text-red-600 rounded-md text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.reset') }}" class="space-y-4 text-left">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    placeholder="••••••••"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                />
            </div>

            <button
                type="submit"
                class="w-full bg-gradient-to-r from-gradient-start to-gradient-end text-white font-semibold py-3 rounded-lg hover:opacity-90 transition duration-200 shadow-md"
            >
                Reset Password
            </button>
        </form>

        <!-- Optional Footer -->
        <div class="mt-6 text-sm text-gray-500">
            Sudah ingat password?
            <a href="{{ route('index') }}" class="text-primary-600 hover:underline font-medium">
                Kembali ke login
            </a>
        </div>
    </div>
</body>
</html>
