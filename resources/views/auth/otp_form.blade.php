<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Verifikasi OTP</title>
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
            },
          },
        },
      },
    }
  </script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
  <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md text-center animate-fade-in">
    <!-- Header -->
    <div class="mb-6">
      <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-gradient-start to-gradient-end rounded-full flex items-center justify-center shadow-lg">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16.24 7.76a6 6 0 11-8.48 8.48 6 6 0 018.48-8.48zM12 14v.01M12 10h.01" />
        </svg>
      </div>
      <h2 class="text-2xl font-semibold text-gray-800">Masukkan Kode OTP</h2>
      <p class="text-sm text-gray-500 mt-1">Kode telah dikirim ke email Anda</p>
    </div>

    <!-- Error -->
    @if ($errors->any())
      <div class="mb-4 px-4 py-2 bg-red-50 text-red-600 rounded-md text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
      @csrf
      <input
        type="text"
        name="otp"
        maxlength="6"
        pattern="\d*"
        placeholder="Masukkan 6 digit OTP"
        required
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 text-center text-lg tracking-widest"
      />

      <button
        type="submit"
        class="w-full bg-gradient-to-r from-gradient-start to-gradient-end text-white font-medium py-3 rounded-lg hover:opacity-90 transition duration-200 shadow-md"
      >
        Verifikasi OTP
      </button>
    </form>
    
  <style>
    @keyframes fade-in {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
      animation: fade-in 0.6s ease-out;
    }
  </style>
</body>
</html>
