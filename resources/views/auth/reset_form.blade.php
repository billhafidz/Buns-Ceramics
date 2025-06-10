<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        darkbg: '#262626',
                    }
                }
            }
        }
    </script>
    <style>
        .card-shadow {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .btn-effect {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-effect:after {
            content: '';
            position: absolute;
            width: 0%;
            height: 100%;
            top: 0;
            left: 50%;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .btn-effect:hover:after {
            width: 110%;
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
        }

        .header-glow {
            position: relative;
        }

        .header-glow:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }

        .password-input-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: #000;
        }
    </style>
</head>

<body class="bg-darkbg flex items-center justify-center min-h-screen font-sans p-6">
    <div class="bg-white p-8 rounded-2xl card-shadow w-full max-w-md animate-fade-in border border-gray-100">
        <!-- Header -->
        <div class="bg-black py-8 px-8 text-center relative header-glow -mx-8 -mt-8 mb-8 rounded-t-2xl">
            <h1 class="text-2xl font-semibold text-white tracking-wide">Ubah Password</h1>
        </div>

        <div class="mb-6 text-center">
            <div class="w-20 h-20 mx-auto bg-black bg-opacity-5 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-key text-3xl text-black"></i>
            </div>
            <p class="text-gray-600">Masukkan password baru untuk akun Anda</p>
        </div>

        <!-- Error -->
        @if ($errors->any())
        <div class="mb-5 px-4 py-3 bg-red-50 text-red-600 rounded-lg text-sm border-l-4 border-red-500 flex items-start">
            <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.reset') }}" class="space-y-6 text-left">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                <div class="password-input-container">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        placeholder="Masukkan password baru"
                        class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg input-focus bg-white focus:outline-none" />
                    <span class="password-toggle" onclick="togglePasswordVisibility('password')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-1 ml-1">Password minimal 8 karakter</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                <div class="password-input-container">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        placeholder="Konfirmasi password baru"
                        class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg input-focus bg-white focus:outline-none" />
                    <span class="password-toggle" onclick="togglePasswordVisibility('password_confirmation')">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button
                type="submit"
                class="w-full bg-black text-white py-3.5 rounded-lg font-medium transition duration-200 btn-effect flex items-center justify-center gap-2 mt-8">
                <span>Simpan Password Baru</span>
                <i class="fas fa-check-circle"></i>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 text-center relative before:content-[''] before:absolute before:left-0 before:right-0 before:top-0 before:h-px before:bg-gradient-to-r before:from-transparent before:via-gray-300 before:to-transparent">
            <a href="{{ route('index') }}" class="text-sm text-black hover:text-gray-600 font-medium inline-flex items-center gap-1">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke halaman login</span>
            </a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card-shadow');
            setTimeout(() => {
                card.style.opacity = '1';
            }, 100);
        });
    </script>
</body>

</html>