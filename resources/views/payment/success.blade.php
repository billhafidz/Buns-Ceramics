<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Thank You</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-xl rounded-2xl p-8 max-w-lg text-center">
    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
      <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 mb-2">Thank You for Your Purchase!</h1>
    <p class="text-gray-600 mb-6">
      Your payment has been received successfully. We truly appreciate your business and hope you enjoy our service.
    </p>
    <a href="{{ route('index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">
      Back to Home
    </a>
  </div>
</body>
</html>