<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="flex">

        <div class="w-64 bg-white h-screen shadow-lg p-4">
            <h2 class="text-xl font-bold mb-2">Admin Panel</h2>
            <p class="text-sm text-gray-600 mb-6">Login sebagai: <strong>{{ session('admin_nama') }}</strong></p>
            <ul class="space-y-2">
                <li><a href="{{ route('admin.dashboard') }}" class="block p-2 hover:bg-gray-200 rounded">🏠 Dashboard</a></li>
                <li><a href="{{ route('admin.gallery') }}" class="block p-2 hover:bg-gray-200 rounded">📷 Gallery</a></li>
                <li><a href="{{ route('admin.users') }}" class="block p-2 hover:bg-gray-200 rounded">👥 Users</a></li>
                <li><a href="{{ route('admin.members') }}" class="block p-2 hover:bg-gray-200 rounded">💳 Members</a></li>
                <li><a href="{{ route('admin-buns.classes.index') }}" class="block p-2 hover:bg-gray-200 rounded">📚 Classes</a></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="block w-full text-left p-2 hover:bg-red-100 rounded text-red-600">🚪 Logout</button>
                    </form>
                </li>
            </ul>
        </div>


        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>
</body>

</html>