<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Verifikasi OTP</title>
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
        },
      },
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
      letter-spacing: 0.5em;
    }

    .input-focus::placeholder {
      letter-spacing: normal;
    }

    .input-focus:focus {
      border-color: #000;
      box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
    }

    @keyframes pulse-ring {
      0% {
        transform: scale(0.8);
        opacity: 0.8;
      }

      50% {
        transform: scale(1);
        opacity: 0.5;
      }

      100% {
        transform: scale(0.8);
        opacity: 0.8;
      }
    }

    .pulse-animation {
      animation: pulse-ring 2s infinite;
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

<body class="bg-darkbg flex items-center justify-center min-h-screen font-sans p-6">
  <div class="bg-white p-8 rounded-2xl card-shadow w-full max-w-md text-center animate-fade-in border border-gray-100">
    <!-- Header -->
    <div class="mb-8">
      <div class="relative w-20 h-20 mx-auto mb-5">
        <div class="absolute inset-0 bg-black bg-opacity-5 rounded-full pulse-animation"></div>
        <div class="absolute inset-0 bg-black rounded-full flex items-center justify-center">
          <i class="fas fa-shield-alt text-white text-xl"></i>
        </div>
      </div>
      <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">Verifikasi OTP</h2>
      <p class="text-sm text-gray-500 mt-2">Kode verifikasi telah dikirim ke email Anda</p>
    </div>

    <!-- Error -->
    @if ($errors->any())
    <div class="mb-5 px-4 py-3 bg-red-50 text-red-600 rounded-lg text-sm border-l-4 border-red-500 flex items-start">
      <i class="fas fa-exclamation-circle mt-0.5 mr-2"></i>
      <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
      @csrf
      <div class="space-y-2">
        <label for="otp" class="block text-sm font-medium text-gray-700 text-left">Kode OTP</label>
        <input
          type="text"
          id="otp"
          name="otp"
          maxlength="6"
          pattern="\d*"
          placeholder="Masukkan 6 digit kode"
          required
          class="w-full px-4 py-3.5 border border-gray-200 rounded-lg focus:outline-none input-focus bg-white text-center text-lg font-medium"
          autocomplete="one-time-code" />
        <p class="text-xs text-gray-400 text-left mt-1">Masukkan kode 6 digit yang dikirim ke email Anda</p>
      </div>

      <button
        type="submit"
        class="w-full bg-black text-white font-medium py-3.5 rounded-lg transition duration-200 btn-effect flex items-center justify-center gap-2">
        <span>Verifikasi</span>
        <i class="fas fa-arrow-right"></i>
      </button>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-100">
      <button class="text-sm text-gray-600 hover:text-black transition duration-200 flex items-center justify-center gap-1 mx-auto">
        <i class="fas fa-redo text-xs"></i>
        <span>Kirim ulang kode OTP</span>
      </button>
    </div>
  </div>
</body>

</html>