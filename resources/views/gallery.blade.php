<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUNS CERAMICS - Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .logo {
            font-family: 'Nico Moji', cursive, sans-serif;
        }

        .nav-center {
            font-family: 'Itim', cursive, sans-serif;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            letter-spacing: 2px;
        }

        .nav-item,
        .role-badge {
            font-family: 'Itim', cursive, sans-serif;
            letter-spacing: 2px;
        }

        #mobileMenu {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            transition: transform 0.3s ease-in-out, backdrop-filter 0.3s ease-in-out;
        }

        #menuToggle {
            z-index: 60;
        }

        .gallery-card img {
            transition: transform 0.5s ease;
        }

        .gallery-card:hover img {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="min-h-screen bg-cover bg-center">
    <!-- Navbar -->
    <header class="flex justify-between items-center py-6 px-6 md:px-20 bg-[#212529] fixed top-0 left-0 w-full z-50">
        <a href="{{ route('index') }}" class="text-4xl font-black tracking-wider text-white logo
        cursor-pointer hover:opacity-80 transition-opacity">
            BUNS
        </a>

        <!-- Hamburger Menu -->
        <button id="hamburgerBtn" class="hamburger lg:hidden text-white z-60">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <nav class="nav-center hidden lg:flex items-center gap-10">
            <a href="{{ route('index') }}" class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Home</a>
            <a href="{{ route('class') }}" class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Class</a>
            <a href="{{ route('gallery') }}" class="font-bold text-lg text-white relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#7D3E35]">Gallery</a>
            <a href="{{ route('contact') }}" class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Contact</a>
        </nav>

        <div class="hidden lg:block">
            @if(session('user'))
            <div class="user-menu-wrapper flex items-center gap-3 order-1 lg:order-2">
                <div class="role-badge bg-[#212529] bg-opacity-90 shadow-md border-white border-2 text-white px-4 py-1 rounded-full font-bold text-sm hidden md:block">
                    {{ strtoupper(session('user')->role) }}
                </div>
                <div class="user-menu group relative">
                    <img src="{{ $member && $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}" alt="User Icon" class="w-10 h-10 rounded-full cursor-pointer border-2 border-white object-cover transition duration-300 transform group-hover:scale-110">
                    <div class="dropdown-content hidden absolute top-12 right-0 bg-white rounded-lg py-3 px-4 min-w-[220px] shadow-lg group-hover:block">
                        <a href="{{ route('account.profile') }}" class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <a href="#" class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            History
                        </a>
                        <form method="POST" action="/logout" class="w-full">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200 w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <button onclick="openModal()" class="order-1 lg:order-2 bg-[#212529] bg-opacity-90 shadow-md border-white border-2 text-white px-6 md:px-8 py-2 md:py-3 rounded-full font-bold hover:scale-105 transition-transform duration-200">
                LOGIN
            </button>
            @endif
        </div>
    </header>

    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu" class="fixed top-0 left-0 w-full h-screen bg-[#212529] z-40 transform -translate-x-full pt-24 px-8">
        <nav class="flex flex-col space-y-6">
            <a href="{{ route('index') }}" class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">HOME</a>
            <a href="{{ route('class') }}" class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CLASS</a>
            <a href="{{ route('gallery') }}" class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">GALLERY</a>
            <a href="{{ route('contact') }}" class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CONTACT</a>

            @if(!session('user'))
            <button
                onclick="openModal(); toggleMobileMenu();"
                class="mt-4 bg-[#212529] bg-opacity-90 shadow-md border-white border-2 text-white px-8 py-3 rounded-full font-bold hover:bg-gradient-to-r hover:from-[#212529] hover:to-[#3a4148] transition-all duration-300">
                LOGIN
            </button>
            @endif
        </nav>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden backdrop-blur-sm" id="mobileMenuOverlay"></div>

    <!-- Gallery Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-20 pt-32 pb-6 bg-white z-40">

        <!-- With this updated section -->
        <div class="flex flex-col md:flex-row items-center gap-4 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0 md:w-1/4">Gallery Collection.</h1>

            <div class="flex flex-col sm:flex-row w-full gap-4">
                <div class="flex-1 relative md:min-w-[400px] lg:min-w-[500px]">
                    <form action="{{ route('gallery') }}" method="GET" class="flex">
                        <input type="text" name="search" placeholder="Search by name or type..." value="{{ request('search') }}"
                            class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f3f4f6] text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </form>
                </div>

                <div class="relative flex-shrink-0">
                    <button id="filterButton" class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-3 hover:bg-gray-50 w-full sm:w-auto justify-center sm:justify-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span class="whitespace-nowrap">Filter by Type</span>
                    </button>

                    <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg z-10 border border-gray-200">
                        <div class="p-2">
                            <h4 class="text-sm font-semibold text-gray-700 px-2 py-1">Type</h4>
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('gallery') }}" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2 {{ !request('jenis') ? 'font-bold text-[#7D3E35]' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                        All Types
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('gallery', ['jenis' => 'Gelas']) }}" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2 {{ request('jenis') == 'bowl' ? 'font-bold text-[#7D3E35]' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                        Gelas
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('gallery', ['jenis' => 'Piring']) }}" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2 {{ request('jenis') == 'plate' ? 'font-bold text-[#7D3E35]' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                        Piring
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('gallery', ['jenis' => 'Mangkuk']) }}" class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2 {{ request('jenis') == 'vase' ? 'font-bold text-[#7D3E35]' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                        </svg>
                                        Mangkuk
                                    </a>
                                </li>
                                <li>
                                </li>
                                <li>
                                </li>
                            </ul>
                        </div>
                        <div class="border-t border-gray-200 p-2">
                            <a href="{{ route('gallery') }}" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Reset Filters
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(request('search') || request('jenis'))
        <div id="activeFilterIndicator" class="mb-4">
            <div class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1 text-sm">
                <span id="activeFilterText">
                    @if(request('search'))
                    Search: "{{ request('search') }}"
                    @endif
                    @if(request('jenis'))
                    @if(request('search')) | @endif
                    Type: {{ ucfirst(request('jenis')) }}
                    @endif
                </span>
                <a href="{{ route('gallery') }}" class="ml-2 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Gallery Cards Section -->
    <div class="container mx-auto px-6 md:px-20 pb-12 md:pb-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($gallery as $item)
            <div class="gallery-card bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:shadow-xl hover:-translate-y-2">
                <div class="h-64 overflow-hidden bg-gray-100 flex items-center justify-center relative">
                    @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}"
                        alt="{{ $item->nama }}"
                        class="w-full h-full object-cover">
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    @endif
                </div>

                <!-- Gallery Item Content -->
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->nama }}</h3>
                    <!-- With this updated section that has conditional colors -->
                    <div class="flex items-center mb-3">
                        @if(strtolower($item->jenis) == 'gelas')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ ucfirst($item->jenis) }}
                        </span>
                        @elseif(strtolower($item->jenis) == 'mangkuk')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            {{ ucfirst($item->jenis) }}
                        </span>
                        @elseif(strtolower($item->jenis) == 'piring')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-800">
                            {{ ucfirst($item->jenis) }}
                        </span>
                        @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#f3e7e6] text-[#7D3E35]">
                            {{ ucfirst($item->jenis) }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No gallery items found</h3>
                <p class="mt-1 text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                <a href="{{ route('gallery') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#592727] hover:bg-[#662f28] focus:outline-none">
                    Reset filters
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Login/Register Modal -->
    <div id="authModal" class="fixed hidden inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm items-center justify-center">
        <div class="relative w-full max-w-2xl mx-auto bg-white rounded-xl overflow-hidden shadow-xl">
            <!-- Modal Close Button -->
            <button class="absolute top-4 right-4 z-50 text-gray-800 hover:text-[#7D3E35] hover:bg-gray-200 rounded-full p-1 transition-colors duration-200" onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Back button for Register view -->
            <button id="backButton" class="absolute top-3 left-3 z-50 text-gray-800 hover:text-[#7D3E35] hover:bg-gray-200 rounded-full p-1 transition-colors duration-200 hidden" onclick="showLogin()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Login Panel -->
            <div id="loginPanel" class="flex flex-col sm:flex-row min-h-[330px] opacity-100 transition-opacity duration-500">
                <!-- Left Side - Image with Text -->
                <div class="bg-cover bg-center w-full sm:w-1/2 flex items-center justify-center text-white p-4 sm:p-6" style="background-image: url('images/login.png');">
                    <div class="bg-black bg-opacity-40 p-4 rounded">
                        <h3 class="text-xl mb-2">Hello...</h3>
                        <p class="text-sm">Enter your personal details and start journey with us</p>
                        <button onclick="showRegister()" class="mt-4 border border-white text-white px-6 py-2 rounded-full text-sm hover:bg-white hover:text-gray-800 transition-all">
                            Sign up
                        </button>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="w-full sm:w-1/2 p-4 sm:p-6">
                    <h2 class="text-xl font-bold text-center mb-6">Welcome To Buns</h2>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="loginUsername" name="username" placeholder="Username" class="flex-1 p-2 outline-none" required>
                        </div>

                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" placeholder="Password" class="flex-1 p-2 outline-none" required>
                        </div>

                        <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-gray-700 transition-all">
                            Login
                        </button>
                    </form>

                    <!-- Mobile Only Sign Up Link -->
                    <div class="sm:hidden mt-4 text-center">
                        <p class="text-gray-600">Don't have an account?</p>
                        <button onclick="showRegister()" class="text-red-700 font-medium hover:underline">
                            Sign up here
                        </button>
                    </div>
                </div>
            </div>

            <!-- Register Panel (Hidden by Default) -->
            <div id="registerPanel" class="flex hidden flex-col sm:flex-row">
                <!-- Left Side - Register Form -->
                <div class="w-full sm:w-1/2 p-4 sm:p-6">
                    <h2 class="text-xl font-bold text-center mb-6">Register</h2>

                    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                        @csrf
                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="registerUsername" name="username" placeholder="Username" class="flex-1 p-2 outline-none" required>
                        </div>

                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" name="email" placeholder="Email" class="flex-1 p-2 outline-none" required>
                        </div>

                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" placeholder="Password" class="flex-1 p-2 outline-none" required>
                        </div>

                        <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-gray-700 transition-all">
                            Sign up
                        </button>
                    </form>

                    <!-- Mobile Only Sign In Link -->
                    <div class="sm:hidden mt-4 text-center">
                        <p class="text-gray-600">Already have an account?</p>
                        <button onclick="showLogin()" class="text-red-700 font-medium hover:underline">
                            Sign in here
                        </button>
                    </div>
                </div>

                <!-- Right Side - Image with Text -->
                <div class="bg-cover bg-center w-full sm:w-1/2 flex items-center justify-center text-white p-4 sm:p-6" style="background-image: url('images/login.png');">
                    <div class="bg-black bg-opacity-40 p-4 rounded">
                        <h3 class="text-xl mb-2">Hello...</h3>
                        <p class="text-sm">Let's start the journey</p>
                        <button onclick="showLogin()" class="mt-4 border border-white text-white px-6 py-2 rounded-full text-sm hover:bg-white hover:text-gray-800 transition-all">
                            Sign in
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#212529] text-white py-16">
        <div class="container mx-auto px-4 md:px-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

                <div>
                    <a href="#" class="block mb-4 hover:text-red-400">About us</a>
                    <a href="{{ route('class') }}" class="block mb-4 hover:text-red-400">Class</a>
                    <a href="#" class="block mb-4 hover:text-red-400">Testimoni</a>
                </div>

                <div>
                    <a href="{{ route('index') }}" class="block mb-4 hover:text-red-400">Home</a>
                    <a href="{{ route('class') }}" class="block mb-4 hover:text-red-400">Class</a>
                    <a href="{{ route('gallery') }}" class="block mb-4 hover:text-red-400">Gallery</a>
                    <a href="{{ route('contact') }}" class="block mb-4 hover:text-red-400">Contact</a>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 w-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <circle cx="12" cy="12" r="4"></circle>
                            </svg>
                        </div>
                        <span class="text-lg">buns.ceramics</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="text-base">Gg. Babakan Asih Dalam, Babakan Asih, Kec. Bojongloa Kaler, Kota Bandung, Jawa Barat</div>
                    </div>
                </div>
            </div>

            <div class="text-center border-t border-gray-700 pt-8">
                <p>Copyright © 2025 Buns ceramics. All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script>
        // Modal for login and registration
        document.addEventListener('DOMContentLoaded', function() {
            // Open modal function
            window.openModal = function() {
                document.getElementById('authModal').classList.remove('hidden');
                document.getElementById('authModal').classList.add('flex');
                showLogin();
                document.getElementById('loginUsername').focus();
            };

            // Close modal function
            window.closeModal = function() {
                document.getElementById('authModal').classList.add('hidden');
                document.getElementById('authModal').classList.remove('flex');
            };

            // Show login panel
            window.showLogin = function() {
                document.getElementById('loginPanel').classList.remove('hidden');
                document.getElementById('registerPanel').classList.add('hidden');
                document.getElementById('backButton').classList.add('hidden');
                document.getElementById('loginUsername').focus();
            };

            // Show register panel
            window.showRegister = function() {
                document.getElementById('loginPanel').classList.add('hidden');
                document.getElementById('registerPanel').classList.remove('hidden');
                document.getElementById('backButton').classList.remove('hidden');
                document.getElementById('registerUsername').focus();
            };

            // Close modal when clicking outside
            document.getElementById('authModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });

            // User dropdown toggle
            const userIcon = document.querySelector('.user-menu img');
            const dropdown = document.querySelector('.dropdown-content');

            if (userIcon && dropdown) {
                userIcon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking elsewhere
                document.addEventListener('click', function() {
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Toggle filter dropdown
            document.getElementById('filterButton').addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('filterDropdown').classList.toggle('hidden');
            });

            document.addEventListener('click', function() {
                document.getElementById('filterDropdown').classList.add('hidden');
            });

            // Mobile menu functionality
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

            function toggleMobileMenu() {
                hamburgerBtn.classList.toggle('active');

                if (mobileMenu.classList.contains('-translate-x-full')) {
                    mobileMenu.classList.remove('-translate-x-full');
                    mobileMenu.classList.add('translate-x-0');
                    mobileMenuOverlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } else {
                    mobileMenu.classList.remove('translate-x-0');
                    mobileMenu.classList.add('-translate-x-full');
                    mobileMenuOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }

            window.toggleMobileMenu = toggleMobileMenu;

            if (hamburgerBtn && mobileMenu && mobileMenuOverlay) {
                hamburgerBtn.addEventListener('click', toggleMobileMenu);
                mobileMenuOverlay.addEventListener('click', toggleMobileMenu);
            }
        });
    </script>
</body>

</html>