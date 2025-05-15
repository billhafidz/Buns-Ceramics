<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

        @if($errors->any())
            <div class="text-red-500 mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" class="w-full border px-4 py-2 rounded" required>
            </div>
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password" class="w-full border px-4 py-2 rounded" required>
            </div>
            <button type="submit" class="w-full bg-red-600 text-white py-2 rounded">Login</button>
        </form>
    </div>
</body>
</html>
