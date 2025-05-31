<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Email</title>
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
                        dark: '#121212',
                        'dark-light': '#1e1e1e',
                        'darkbg': '#262626',
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
    </style>
</head>

<body class="bg-darkbg min-h-screen flex items-center justify-center p-6 font-sans">
    <div class="w-full max-w-md bg-white rounded-xl card-shadow overflow-hidden border border-gray-100 animate-fade-in">
        <!-- Header with black background -->
        <div class="bg-black py-8 px-8 text-center relative header-glow">
            <h1 class="text-2xl font-semibold text-white tracking-wide">Reset Password</h1>
        </div>

        <!-- Form content -->
        <div class="p-8 space-y-8">
            <div class="text-center">
                <div class="w-20 h-20 mx-auto bg-black bg-opacity-5 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-lock text-3xl text-black"></i>
                </div>
                <p class="text-gray-600">Masukkan alamat email Anda untuk menerima kode OTP</p>
            </div>

            @if ($errors->any())
            <div class="p-3 bg-red-50 text-red-600 rounded-lg text-sm border-l-4 border-red-500">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('otp.send') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            placeholder="contoh@email.com"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 input-focus bg-white focus:outline-none">
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-black text-white py-3 px-4 rounded-lg font-medium transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 btn-effect flex items-center justify-center gap-2">
                    <span>Kirim Kode OTP</span>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>

            <div class="pt-4 text-center relative before:content-[''] before:absolute before:left-0 before:right-0 before:top-0 before:h-px before:bg-gradient-to-r before:from-transparent before:via-gray-300 before:to-transparent">
                <a href="{{ route('index') }}" class="text-sm text-black hover:text-gray-600 font-medium inline-flex items-center gap-1">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Kembali ke halaman login</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card-shadow');
            setTimeout(() => {
                card.style.opacity = '1';
            }, 100);
        });
    </script>
</body>

</html>