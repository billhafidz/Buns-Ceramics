<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUNS CERAMICS</title>
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🫱🏻‍🫲🏽</text></svg>">
    {{-- <link href="/src/styles.css" rel="stylesheet"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .logo {
            font-family: 'Grand Hotel', cursive, sans-serif;
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

        .scrollbar-hide::-webkit-scrollbar {
            width: 0.5rem;
        }

        .scrollbar-hide::-webkit-scrollbar-thumb {
            background-color: transparent;
        }

        .scrollbar-hide:hover::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
        }

        html {
            overflow-y: scroll;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .animate-fade-in-out {
            animation: fadeInOut 3s ease-in-out forwards;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            10% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
                transform: translateY(0);
            }

            100% {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body class="min-h-screen bg-cover bg-center">
    <!-- Navbar -->
    <header class="flex justify-between items-center py-6 px-6 md:px-20 bg-[#262626] fixed top-0 left-0 w-full z-50">
        <a href="{{ route('index') }}"
            class="text-4xl font-black tracking-wider text-white logo
        cursor-pointer hover:opacity-80 transition-opacity">
            Buns
        </a>

        <!-- Desktop Navigation -->
        <nav class="nav-center hidden lg:flex items-center gap-10">
            <a href="{{ route('index') }}"
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Home</a>
            <a href="{{ route('class') }}"
                class="font-bold text-lg text-white relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#7D3E35]">Class</a>
            <a href="{{ route('gallery') }}"
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Gallery</a>
            <a href="{{ route('contact') }}"
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Contact</a>
        </nav>

        <div class="flex items-center gap-3">
            @if (session('user'))
                @php
                    $role = strtolower(session('user')->role ?? '');
                    $canClick = $role === 'member';
                @endphp

                <span
                    class="bg-[#212529] role-badge bg-opacity-90 shadow-md border-white border-2 text-white px-4 py-1 rounded-full font-bold text-sm {{ $canClick ? 'cursor-pointer' : 'cursor-default' }}"
                    @if ($canClick) onclick="showMemberInfo()" @endif>
                    {{ strtoupper(session('user')->role ?? '') }}
                </span>

                <div class="user-menu group relative">
                    <img src="{{ $member && $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}"
                        alt="User Icon"
                        class="w-9 h-9 rounded-full cursor-pointer border-2 border-white object-cover transition duration-300 transform group-hover:scale-110">

                    <div
                        class="dropdown-content hidden absolute top-12 right-0 bg-white rounded-lg py-3 px-4 min-w-[220px] shadow-lg group-hover:block z-50">
                        <a href="{{ route('account.profile') }}"
                            class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <a href="{{ route('account.history') }}"
                            class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            History
                        </a>
                        <form method="POST" action="/logout" class="w-full">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200 w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <button onclick="openModal()"
                    class="bg-[#262626] bg-opacity-90 shadow-md border-white border-2 text-white px-6 md:px-8 py-2 md:py-3 rounded-full font-bold hover:scale-105 transition-transform duration-200">
                    LOGIN
                </button>
            @endif

            <button id="hamburgerBtn" class="lg:hidden text-white ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Member Info Modal -->
    @if (session('user') && $member)
        <div id="memberInfoModal"
            class="fixed hidden inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm items-center justify-center p-2 sm:p-4">

            <div
                class="relative w-full max-w-sm sm:max-w-2xl bg-white rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden">
                <div class="flex flex-col sm:flex-row">

                    <div class="w-full sm:w-1/2 bg-cover bg-center h-32 sm:h-auto sm:min-h-[300px] relative"
                        style="background-image: url('{{ asset('images/login.png') }}');">
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-center">
                            <h3
                                class="font-playfair text-3xl font-semibold mb-2 text-white tracking-wide drop-shadow-lg">
                                Buns</h3>
                            <h3 class="font-playfair text-3xl font-light text-white tracking-widest drop-shadow-lg">
                                Ceramics</h3>
                        </div>
                    </div>

                    <div class="w-full sm:w-1/2 p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Member Card</h2>

                        <div class="text-center mb-4">
                            <img src="{{ $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}"
                                alt="Profile Picture" class="w-20 h-20 rounded-full mx-auto object-cover shadow-lg">
                        </div>

                        <div class="space-y-4">
                            <div class="relative">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                    {{ $member->nama_member }}
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                        </path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <div
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                    {{ $member->email_member }}
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.75 2.524 9.026 9.026 0 00-.3.04z">
                                        </path>
                                    </svg>
                                </div>
                                <div
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                    @php
                                        $latestTransaction = $member->transactions()->latest('created_at')->first();
                                    @endphp
                                    {{ $latestTransaction ? $latestTransaction->nama_kelas : 'Belum ada kelas' }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="button" onclick="window.print()"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zM5 14H4v-2h1v2zm1 0v2h6v-2H6zm9 0v-2h1v2h-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Print
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu"
        class="fixed top-0 left-0 w-full h-screen bg-[#262626] z-40 transform -translate-x-full pt-24 px-8">
        <nav class="flex flex-col space-y-6">
            <a href="{{ route('index') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">HOME</a>
            <a href="#class" class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CLASS</a>
            <a href="{{ route('gallery') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">GALLERY</a>
            <a href="{{ route('contact') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CONTACT</a>

            @if (!session('user'))
                <button onclick="openModal(); toggleMobileMenu();"
                    class="mt-4 bg-[#262626] bg-opacity-90 shadow-md border-white border-2 text-white px-8 py-3 rounded-full font-bold hover:bg-gradient-to-r hover:from-[#212529] hover:to-[#3a4148] transition-all duration-300">
                    LOGIN
                </button>
            @endif
        </nav>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden backdrop-blur-sm" id="mobileMenuOverlay"></div>

    <!-- Classes Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-20 pt-32 pb-6 bg-white z-40">
        <div class="flex items-center justify-between gap-4 mb-6">

            <div class="flex-1 relative min-w-0">
                <input type="text" id="searchInput" placeholder="Search by class, name or benefit..."
                    class="w-full p-3 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#f3f4f6] text-sm sm:text-base">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-3.5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <div class="relative flex-shrink-0">
                <button id="filterButton"
                    class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-3 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="whitespace-nowrap">Filter</span>
                </button>

                <div id="filterDropdown"
                    class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg z-10 border border-gray-200">
                    <div class="p-2">
                        <h4 class="text-sm font-semibold text-gray-700 px-2 py-1">Sort by</h4>
                        <ul class="space-y-1">
                            <li>
                                <button onclick="sortClasses('name_asc')"
                                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Name (A-Z)
                                </button>
                            </li>
                            <li>
                                <button onclick="sortClasses('name_desc')"
                                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Name (Z-A)
                                </button>
                            </li>
                            <li>
                                <button onclick="sortClasses('price_asc')"
                                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Price (Low to High)
                                </button>
                            </li>
                            <li>
                                <button onclick="sortClasses('price_desc')"
                                    class="w-full text-left px-3 py-2 text-sm hover:bg-gray-100 rounded flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>
                                    Price (High to Low)
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="border-t border-gray-200 p-2">
                        <button onclick="resetFilters()"
                            class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="activeFilterIndicator" class="hidden mb-4">
            <div class="inline-flex items-center bg-gray-100 rounded-full px-3 py-1 text-sm">
                <span id="activeFilterText"></span>
                <button onclick="resetFilters()" class="ml-2 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Classes Section -->
    <div class="container mx-auto px-6 md:px-20 pb-12 md:pb-16">
        <div id="classesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($langganans->where('status', 'active') as $langganan)
                <div class="class-card bg-white rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:shadow-xl hover:-translate-y-2"
                    data-name="{{ strtolower($langganan->pilihan_subs) }}"
                    data-description="{{ strtolower($langganan->penjelasan_subs) }}"
                    data-price="{{ $langganan->harga_subs }}"
                    data-benefits="{{ strtolower(implode(',', json_decode($langganan->benefit_subs, true) ?? [])) }}">

                    <div class="h-64 overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if ($langganan->gambar_subs)
                            <img src="{{ asset('storage/langganan_images/' . $langganan->gambar_subs) }}"
                                alt="{{ $langganan->pilihan_subs }}" class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @endif
                    </div>

                    <!-- Class Content -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $langganan->pilihan_subs }}</h3>
                        {{-- <p class="text-gray-600 mb-4 line-clamp-3 text-justify">{{ $langganan->penjelasan_subs }}</p> --}}

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xl font-bold text-[#7D3E35]">Rp.
                                {{ number_format($langganan->harga_subs, 0, ',', '.') }}</span>
                            <button onclick="showClassDetail({{ $langganan->id_langganan }})"
                                class="bg-[#592727] text-white px-4 md:px-6 py-2 md:py-3 rounded-lg font-bold inline-block hover:bg-[#662f28] transition-all">
                                DETAIL
                            </button>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Includes:</h4>
                            <ul class="space-y-1">
                                @foreach (array_slice(json_decode($langganan->benefit_subs, true), 0, 3) as $benefit)
                                    <li class="flex items-start">
                                        <svg class="h-4 w-4 text-green-500 mt-1 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm text-gray-600">{{ $benefit }}</span>
                                    </li>
                                @endforeach
                                @if (count(json_decode($langganan->benefit_subs, true)) > 3)
                                    <li class="text-sm text-gray-500">+
                                        {{ count(json_decode($langganan->benefit_subs, true)) - 3 }} more benefits</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="emptyState" class="hidden text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada kelas yang ditemukan</h3>
            <p class="mt-1 text-gray-500">Coba sesuaikan pencarian atau filter Anda untuk menemukan apa yang Anda cari.
            </p>
            <button onclick="resetFilters()"
                class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-[#592727] hover:bg-[#662f28] focus:outline-none">
                Reset filters
            </button>
        </div>
    </div>

    <!-- Class Detail Modal -->
    <div id="classDetailModal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-2xl w-full max-w-4xl mx-4" style="max-height: 90vh;">

            <!-- Close Button -->
            <button onclick="closeClassDetail()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors rounded-full w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 h-full max-h-[90vh] overflow-y-auto scrollbar-hide">
                <div
                    class="h-64 lg:h-auto bg-gray-100 flex items-center justify-center relative overflow-hidden rounded-l-lg">
                    <img id="detailClassImage" src="" alt="Class Image"
                        class="hidden absolute inset-0 w-full h-full object-cover">
                    <svg id="detailClassImagePlaceholder" xmlns="http://www.w3.org/2000/svg"
                        class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>

                <div class="p-6 md:p-8 flex flex-col rounded-r-lg" style="max-height: calc(90vh - 1px);">
                    <div class="flex-grow overflow-y-auto scrollbar-hide">
                        <h2 id="detailClassName" class="text-3xl font-bold text-gray-800 mb-2"></h2>
                        <p id="detailClassPrice" class="text-xl font-bold text-[#7D3E35] mb-4"></p>

                        <div class="mb-6 text-justify">
                            <p id="detailClassDescription" class="text-gray-700"></p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Facilities Included:</h3>
                            <ul id="detailClassBenefits" class="space-y-2"></ul>
                        </div>
                    </div>

                    <div class="mt-auto pt-4 min-h-[50px]">
                        <div class="flex justify-center">
                            @if (session('user'))
                                <a href="{{ route('subscribe') }}" onclick="return onSubscribeClick()"
                                    class="w-full md:w-auto px-8 py-3 bg-[#592727] text-white rounded-lg font-bold hover:bg-[#662f28] transition-colors text-center">
                                    Subscribe Now
                                </a>
                            @else
                                <button onclick="openModal(); closeClassDetail();"
                                    class="w-full md:w-auto px-8 py-3 bg-[#592727] text-white rounded-lg font-bold hover:bg-[#662f28] transition-colors">
                                    Subscribe Now
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login/Register Modal -->
    <div id="authModal"
        class="fixed hidden inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm items-center justify-center">
        <div class="relative w-full max-w-2xl mx-auto bg-white rounded-xl overflow-hidden shadow-xl">
            <!-- Modal Close Button -->
            <button
                class="absolute top-4 right-4 z-50 text-[#262626] hover:text-[#7D3E35] hover:bg-gray-200 rounded-full p-1 transition-colors duration-200"
                onclick="closeModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Back button for Register view -->
            <button id="backButton"
                class="absolute top-3 left-3 z-50 text-[#262626] hover:text-[#7D3E35] hover:bg-gray-200 rounded-full p-1 transition-colors duration-200 hidden"
                onclick="showLogin()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Login Panel -->
            <div id="loginPanel"
                class="flex flex-col sm:flex-row min-h-[330px] opacity-100 transition-opacity duration-500">
                <!-- Left Side - Image with Text -->
                <div class="bg-cover bg-center w-full sm:w-1/2 flex items-center justify-center text-white p-4 sm:p-6"
                    style="background-image: url('images/login.png');">
                    <div class="bg-black bg-opacity-40 p-4 rounded">
                        <h3 class="text-xl mb-2">Hello...</h3>
                        <p class="text-sm">Enter your personal details and start journey with us</p>
                        <button onclick="showRegister()"
                            class="mt-4 border border-white text-white px-6 py-2 rounded-full text-sm hover:bg-white hover:text-gray-800 transition-all">
                            Sign up
                        </button>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="w-full sm:w-1/2 p-4 sm:p-6">
                    <h2 class="text-xl font-bold text-center mb-6">Welcome To Buns</h2>
                    <div id="loginError" class="text-center text-red-500 text-sm mb-4 hidden">The account is not
                        registered</div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4"
                        onsubmit="return validateLoginForm()">
                        @csrf
                        <div class="flex flex-col">
                            <div class="flex border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 p-3 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="loginUsername" name="username" placeholder="Username"
                                    class="flex-1 p-2 outline-none" value="{{ old('username') }}">
                            </div>
                            <span id="loginUsernameError" class="text-red-500 text-sm mt-1 hidden">Username cannot be
                                empty</span>
                        </div>

                        <div class="flex flex-col">
                            <div class="flex border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 p-3 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="password" id="loginPassword" name="password" placeholder="Password"
                                    class="flex-1 p-2 outline-none">
                            </div>
                            <span id="loginPasswordError" class="text-red-500 text-sm mt-1 hidden">Password cannot be
                                empty</span>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#262626] text-white py-2 rounded-lg hover:bg-opacity-90 transition-all">
                            Login
                        </button>

                        {{-- Link lupa password --}}
                        <div class="text-center">
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-gray-500 hover:text-gray-800 underline transition-all">
                                Forget Password?
                            </a>
                        </div>
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

            <!-- Register Panel -->
            <div id="registerPanel" class="flex hidden flex-col sm:flex-row">
                <!-- Left Side - Register Form -->
                <div class="w-full sm:w-1/2 p-4 sm:p-6">
                    <h2 class="text-xl font-bold text-center mb-6">Register</h2>

                    <form method="POST" action="{{ route('register.store') }}" class="space-y-4"
                        onsubmit="return validateRegisterForm()" novalidate>
                        @csrf
                        <div class="flex flex-col">
                            <div class="flex border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 p-3 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="registerUsername" name="username" placeholder="Username"
                                    class="flex-1 p-2 outline-none">
                            </div>
                            <span id="registerUsernameError" class="text-red-500 text-sm mt-1 hidden"></span>
                        </div>

                        <div class="flex flex-col">
                            <div class="flex border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 p-3 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input type="text" name="email" placeholder="Email"
                                    class="flex-1 p-2 outline-none">
                            </div>
                            <span id="registerEmailError" class="text-red-500 text-sm mt-1 hidden"></span>
                        </div>

                        <div class="flex flex-col">
                            <div class="flex border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 p-3 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="password" name="password" placeholder="Password"
                                    class="flex-1 p-2 outline-none">
                            </div>
                            <span id="registerPasswordError" class="text-red-500 text-sm mt-1 hidden"></span>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#262626] text-white py-2 rounded-lg hover:bg-opacity-90 transition-all">
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
                <div class="bg-cover bg-center w-full sm:w-1/2 flex items-center justify-center text-white p-4 sm:p-6"
                    style="background-image: url('images/login.png');">
                    <div class="bg-black bg-opacity-40 p-4 rounded">
                        <h3 class="text-xl mb-2">Hello...</h3>
                        <p class="text-sm">Let's start the journey</p>
                        <button onclick="showLogin()"
                            class="mt-4 border border-white text-white px-6 py-2 rounded-full text-sm hover:bg-white hover:text-gray-800 transition-all">
                            Sign in
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <x-footer />

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50 animate-fade-in-out">
            {{ session('error') }}
            <button onclick="this.parentElement.remove()" class="ml-2 font-bold">&times;</button>
        </div>
    @endif
    
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

            window.closeModal = function() {
                document.getElementById('authModal').classList.add('hidden');
                document.getElementById('authModal').classList.remove('flex');
                // Reset all error messages and input values when closing modal
                document.getElementById('loginUsername').value = '';
                document.getElementById('loginPassword').value = '';
                document.getElementById('registerUsername').value = '';
                document.querySelector('#registerPanel input[name="email"]').value = '';
                document.querySelector('#registerPanel input[name="password"]').value = '';
                document.getElementById('loginUsernameError').classList.add('hidden');
                document.getElementById('loginPasswordError').classList.add('hidden');
                document.getElementById('loginError').classList.add('hidden');
                document.getElementById('registerUsernameError').classList.add('hidden');
                document.getElementById('registerEmailError').classList.add('hidden');
                document.getElementById('registerPasswordError').classList.add('hidden');
            };

            window.showLogin = function() {
                document.getElementById('loginPanel').classList.remove('hidden');
                document.getElementById('registerPanel').classList.add('hidden');
                document.getElementById('backButton').classList.add('hidden');
                // Reset login form inputs
                document.getElementById('loginUsername').value = '';
                document.getElementById('loginPassword').value = '';
                document.getElementById('loginUsername').focus();
                // Reset error messages
                document.getElementById('loginUsernameError').classList.add('hidden');
                document.getElementById('loginPasswordError').classList.add('hidden');
                document.getElementById('loginError').classList.add('hidden');
            };

            window.showRegister = function() {
                document.getElementById('loginPanel').classList.add('hidden');
                document.getElementById('registerPanel').classList.remove('hidden');
                document.getElementById('backButton').classList.remove('hidden');
                // Reset register form inputs
                document.getElementById('registerUsername').value = '';
                document.querySelector('#registerPanel input[name="email"]').value = '';
                document.querySelector('#registerPanel input[name="password"]').value = '';
                document.getElementById('registerUsername').focus();
                // Reset error messages
                document.getElementById('registerUsernameError').classList.add('hidden');
                document.getElementById('registerEmailError').classList.add('hidden');
                document.getElementById('registerPasswordError').classList.add('hidden');
            };

            document.getElementById('authModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });

            const userIcon = document.querySelector('.user-menu img');
            const dropdown = document.querySelector('.dropdown-content');

            if (userIcon && dropdown) {
                userIcon.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function() {
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                    }
                });
            }



            function closeClassDetail() {
                document.getElementById('classDetailModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

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

            // Check for any errors and open modal
            @if ($errors->any())
                document.getElementById('authModal').classList.remove('hidden');
                document.getElementById('authModal').classList.add('flex');
                showLogin();

                // Check for login error (wrong credentials)
                @if ($errors->has('login'))
                    document.getElementById('loginError').textContent = '{{ $errors->first('login') }}';
                    document.getElementById('loginError').classList.remove('hidden');
                @endif

                // Check for validation errors (empty fields)
                @if ($errors->has('username'))
                    document.getElementById('loginUsernameError').textContent = '{{ $errors->first('username') }}';
                    document.getElementById('loginUsernameError').classList.remove('hidden');
                @endif

                @if ($errors->has('password'))
                    document.getElementById('loginPasswordError').textContent = '{{ $errors->first('password') }}';
                    document.getElementById('loginPasswordError').classList.remove('hidden');
                @endif
            @endif
        });

        function validateLoginForm() {
            let isValid = true;
            const username = document.getElementById('loginUsername').value.trim();
            const password = document.getElementById('loginPassword').value.trim();
            const usernameError = document.getElementById('loginUsernameError');
            const passwordError = document.getElementById('loginPasswordError');

            // Reset error messages
            usernameError.classList.add('hidden');
            passwordError.classList.add('hidden');
            document.getElementById('loginError').classList.add('hidden');

            // Check for empty fields
            if (!username) {
                usernameError.textContent = 'Username cannot be empty';
                usernameError.classList.remove('hidden');
                isValid = false;
            }
            if (!password) {
                passwordError.textContent = 'Password cannot be empty';
                passwordError.classList.remove('hidden');
                isValid = false;
            }

            return isValid;
        }

        function validateRegisterForm() {
            let isValid = true;
            const username = document.getElementById('registerUsername').value.trim();
            const email = document.querySelector('#registerPanel input[name="email"]').value.trim();
            const password = document.querySelector('#registerPanel input[name="password"]').value.trim();
            const usernameError = document.getElementById('registerUsernameError');
            const emailError = document.getElementById('registerEmailError');
            const passwordError = document.getElementById('registerPasswordError');

            // Reset error messages
            usernameError.classList.add('hidden');
            emailError.classList.add('hidden');
            passwordError.classList.add('hidden');

            // Username validation: 5-15 characters, no spaces, no special characters
            const usernameRegex = /^[a-zA-Z0-9]{5,15}$/;
            if (!username) {
                usernameError.textContent = 'Username cannot be empty';
                usernameError.classList.remove('hidden');
                isValid = false;
            } else if (!usernameRegex.test(username)) {
                usernameError.textContent = 'Username must be 5-15 characters, no spaces or special characters';
                usernameError.classList.remove('hidden');
                isValid = false;
            }

            // Email validation: valid email format, no spaces
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email) {
                emailError.textContent = 'Email cannot be empty';
                emailError.classList.remove('hidden');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                emailError.textContent = 'Please enter a valid email address';
                emailError.classList.remove('hidden');
                isValid = false;
            }

            // Password validation: 8-12 characters, no spaces
            const passwordRegex = /^[^\s]{8,12}$/;
            if (!password) {
                passwordError.textContent = 'Password cannot be empty';
                passwordError.classList.remove('hidden');
                isValid = false;
            } else if (!passwordRegex.test(password)) {
                passwordError.textContent = 'Password must be 8-12 characters long and must not contain spaces';
                passwordError.classList.remove('hidden');
                isValid = false;
            }

            return isValid;
        }

        function showClassDetail(classId) {
            const classData = getClassData(classId);

            if (classData) {
                selectedLangganan = classData;

                const imageElement = document.getElementById('detailClassImage');
                const placeholderElement = document.getElementById('detailClassImagePlaceholder');

                if (classData.gambar_subs) {
                    imageElement.src = `/storage/langganan_images/${classData.gambar_subs}`;
                    imageElement.classList.remove('hidden');
                    placeholderElement.classList.add('hidden');
                } else {
                    imageElement.classList.add('hidden');
                    placeholderElement.classList.remove('hidden');
                }

                document.getElementById('detailClassName').textContent = classData.pilihan_subs;
                document.getElementById('detailClassPrice').textContent =
                    `Rp. ${parseInt(classData.harga_subs).toLocaleString()}`;
                document.getElementById('detailClassDescription').textContent = classData.penjelasan_subs;

                const benefitsList = document.getElementById('detailClassBenefits');
                benefitsList.innerHTML = '';

                try {
                    const benefits = JSON.parse(classData.benefit_subs);
                    benefits.forEach(benefit => {
                        if (benefit && benefit.trim() !== '') {
                            const li = document.createElement('li');
                            li.className = 'flex items-start';
                            li.innerHTML = `
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">${benefit}</span>
                        `;
                            benefitsList.appendChild(li);
                        }
                    });

                    if (benefitsList.children.length === 0) {
                        benefitsList.innerHTML = '<li class="text-gray-500">No benefits listed</li>';
                    }
                } catch (e) {
                    benefitsList.innerHTML = '<li class="text-gray-500">No benefits listed</li>';
                }

                document.getElementById('classDetailModal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeClassDetail() {
            document.getElementById('classDetailModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function getClassData(classId) {
            const classes = @json($langganans);
            return classes.find(c => c.id_langganan == classId);
        }

        document.getElementById('classDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeClassDetail();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('filterButton').addEventListener('click', function(e) {
                e.stopPropagation();
                document.getElementById('filterDropdown').classList.toggle('hidden');
            });

            document.addEventListener('click', function() {
                document.getElementById('filterDropdown').classList.add('hidden');
            });

            document.getElementById('searchInput').addEventListener('input', function() {
                filterClasses();
            });
        });

        function filterClasses() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const classCards = document.querySelectorAll('.class-card');
            let visibleCount = 0;

            classCards.forEach(card => {
                const name = card.dataset.name;
                const description = card.dataset.description;
                const price = card.dataset.price;
                const benefits = card.dataset.benefits;

                const matchesSearch = searchTerm === '' ||
                    name.includes(searchTerm) ||
                    description.includes(searchTerm) ||
                    price.includes(searchTerm) ||
                    benefits.includes(searchTerm);

                if (matchesSearch) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (visibleCount === 0) {
                document.getElementById('emptyState').classList.remove('hidden');
            } else {
                document.getElementById('emptyState').classList.add('hidden');
            }
        }

        function sortClasses(sortType) {
            const container = document.getElementById('classesContainer');
            const classCards = Array.from(document.querySelectorAll('.class-card'));

            classCards.sort((a, b) => {
                switch (sortType) {
                    case 'name_asc':
                        return a.dataset.name.localeCompare(b.dataset.name);
                    case 'name_desc':
                        return b.dataset.name.localeCompare(a.dataset.name);
                    case 'price_asc':
                        return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                    case 'price_desc':
                        return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                    default:
                        return 0;
                }
            });

            classCards.forEach(card => container.appendChild(card));

            document.getElementById('activeFilterIndicator').classList.remove('hidden');
            let filterText = '';

            switch (sortType) {
                case 'name_asc':
                    filterText = 'Sorted by: Name (A-Z)';
                    break;
                case 'name_desc':
                    filterText = 'Sorted by: Name (Z-A)';
                    break;
                case 'price_asc':
                    filterText = 'Sorted by: Price (Low to High)';
                    break;
                case 'price_desc':
                    filterText = 'Sorted by: Price (High to Low)';
                    break;
            }

            document.getElementById('activeFilterText').textContent = filterText;
            document.getElementById('filterDropdown').classList.add('hidden');
        }

        function resetFilters() {
            location.reload();
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('.class-card').forEach(card => {
                card.classList.remove('hidden');
            });
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('activeFilterIndicator').classList.add('hidden');
        }

        function showMemberInfo() {
            document.getElementById('memberInfoModal').classList.remove('hidden');
            document.getElementById('memberInfoModal').classList.add('flex');
        }

        function closeMemberInfo() {
            document.getElementById('memberInfoModal').classList.add('hidden');
            document.getElementById('memberInfoModal').classList.remove('flex');
        }
        document.getElementById('memberInfoModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeMemberInfo();
            }
        });

        function onSubscribeClick() {
            if (!selectedLangganan) {
                alert('Pilih kelas terlebih dahulu lewat tombol DETAIL.');
                return false;
            }

            localStorage.setItem('selectedLangganan', JSON.stringify(selectedLangganan));
            return true;
        }
    </script>
</body>

</html>
