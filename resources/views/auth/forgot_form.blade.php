<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header with gradient background -->
        <div class="bg-gradient-to-r from-gradient-start to-gradient-end py-6 px-8 text-center">
            <h1 class="text-2xl font-semibold text-white">Reset Password</h1>
        </div>
        
        <!-- Form content -->
        <div class="p-8">
            <div class="text-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <p class="mt-4 text-gray-600">Masukkan alamat email Anda untuk menerima kode OTP</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-lg text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('otp.send') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="contoh@email.com"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition duration-200"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-gradient-start to-gradient-end text-white py-3 px-4 rounded-lg font-medium hover:opacity-90 transition duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 shadow-md"
                >
                    Kirim Kode OTP
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('index') }}" class="text-sm text-primary-600 hover:text-primary-500 font-medium">
                    Kembali ke halaman login
                </a>
            </div>
        </div>
    </div>
</body>
</html>