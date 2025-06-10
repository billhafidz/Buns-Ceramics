<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUNS CERAMICS</title>
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

        .auth-panel {
            transition: transform 0.5s ease;
        }

        .modal-box.shifted .left-panel {
            transform: translateX(100%);
        }

        .modal-box.shifted .right-panel {
            transform: translateX(-100%);
        }

        .hero-banner {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 650px;
            justify-content: center;
            background-image: url('images/banner.png');
            background-size: cover;
            background-position: center;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
        }

        .hero-content {
            font-family: 'Itim', cursive, sans-serif;
            letter-spacing: 10px;
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            width: 100%;
        }

        .buns-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 4.5rem;
            line-height: 1;
        }

        .hero-banner:hover .buns-text {
            opacity: 1;
        }

        .hero-banner:hover::before {
            background-color: rgba(0, 0, 0, 0.6);
        }

        #mobileMenu {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            transition: transform 0.3s ease-in-out, backdrop-filter 0.3s ease-in-out;
        }

        #menuToggle {
            z-index: 60;
        }

        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.4s ease-out;
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

        @media print {

            /* Hapus semua elemen selain kartu */
            body * {
                visibility: hidden !important;
            }

            #memberCardArea,
            #memberCardArea * {
                visibility: visible !important;
            }

            #memberCardArea {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            @page {
                margin: 0;
                size: auto;
            }

            .no-print {
                display: none !important;
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

        <!-- Hamburger Menu -->
        <button id="hamburgerBtn" class="hamburger lg:hidden text-white z-60">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <!-- Desktop Navigation -->
        <nav class="nav-center hidden lg:flex items-center gap-10">
            <a href="{{ route('index') }}"
                class="font-bold text-lg text-white relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-full after:h-0.5 after:bg-[#7D3E35]">Home</a>
            <a href="{{ route('class') }}"
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Class</a>
            <a href="{{ route('gallery') }}"
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Gallery</a>
            <a href="{{ route('contact') }}"
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Contact</a>
        </nav>

        <div class="hidden lg:block">
            @if (session('user'))
            @php
            $role = strtolower(session('user')->role ?? '');
            $canClick = $role === 'member';
            @endphp
            <div class="user-menu-wrapper flex items-center gap-3 order-1 lg:order-2">
                <span
                    class="role-badge bg-[#212529] bg-opacity-90 shadow-md border-white border-2 text-white px-4 py-1 rounded-full font-bold text-sm {{ $canClick ? 'cursor-pointer' : 'cursor-default' }}"
                    @if ($canClick)
                    onclick="showMemberInfo()"
                    @endif>
                    {{ strtoupper(session('user')->role ?? '') }}
                </span>
                <div class="user-menu group relative">
                    <img src="{{ $member && $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}"
                        alt="User Icon"
                        class="w-10 h-10 rounded-full cursor-pointer border-2 border-white object-cover transition duration-300 transform group-hover:scale-110">
                    <div
                        class="dropdown-content hidden absolute top-12 right-0 bg-white rounded-lg py-3 px-4 min-w-[220px] shadow-lg group-hover:block">
                        <a href="{{ route('account.profile') }}"
                            class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                        <a href="{{ route('account.history') }}"
                            class="flex items-center gap-2 py-2 px-2 text-black hover:bg-[#662f28] hover:text-white hover:rounded transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
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
            </div>
            @else
            <button onclick="openModal()"
                class="order-1 lg:order-2 bg-[#262626] bg-opacity-90 shadow-md border-white border-2 text-white px-6 md:px-8 py-2 md:py-3 rounded-full font-bold hover:scale-105 transition-transform duration-200">
                LOGIN
            </button>
            @endif
        </div>
    </header>
    
    <!-- Member Info Modal -->
    @if (session('user') && $member)
    <div id="memberInfoModal"
        class="fixed hidden inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm items-center justify-center p-2 sm:p-4">

        <div class="relative w-full max-w-sm sm:max-w-2xl bg-white rounded-xl sm:rounded-2xl shadow-2xl overflow-hidden">
            <div class="flex flex-col sm:flex-row">

                <!-- Left Image Panel -->
                <div class="w-full sm:w-1/2 bg-cover bg-center h-32 sm:h-auto sm:min-h-[300px] relative"
                    style="background-image: url('{{ asset('images/login.png') }}');">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-center">
                        <h3 class="font-playfair text-3xl font-semibold mb-2 text-white tracking-wide drop-shadow-lg">Buns</h3>
                        <h3 class="font-playfair text-3xl font-light text-white tracking-widest drop-shadow-lg">Ceramics</h3>
                    </div>
                </div>

                <!-- Right Member Card Panel -->
                <div class="w-full sm:w-1/2 p-6" id="memberCardArea">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Member Card</h2>

                    <div class="text-center mb-4">
                        <img src="{{ $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}"
                            alt="Profile Picture"
                            class="w-20 h-20 rounded-full mx-auto object-cover shadow-lg">
                    </div>

                    <div class="space-y-4">
                        <!-- Nama Member -->
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                {{ $member->nama_member }}
                            </div>
                        </div>

                        <!-- Email Member -->
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                            <div class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                {{ $member->email_member }}
                            </div>
                        </div>

                        <!-- Kelas Terakhir -->
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.75 2.524 9.026 9.026 0 00-.3.04z"></path>
                                </svg>
                            </div>
                            <div class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                @php
                                $latestTransaction = $member->transactions()->latest('created_at')->first();
                                @endphp
                                {{ $latestTransaction ? $latestTransaction->nama_kelas : 'Belum ada kelas' }}
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Print -->
                    <div class="mt-6 flex justify-end no-print">
                        <button
                            type="button"
                            onclick="printMemberCard()"
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v4h12V4a2 2 0 00-2-2H6zM4 10v6a2 2 0 002 2h8a2 2 0 002-2v-6H4zm2 2h8v2H6v-2z" clip-rule="evenodd" />
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
        class="fixed top-0 left-0 w-full h-screen bg-[#262626] z-40 transform -translate-x-full pt-24 px-6 md:px-8">
        <nav class="flex flex-col space-y-4 md:space-y-6">
            <a href="{{ route('index') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">HOME</a>
            <a href="{{ route('class') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CLASS</a>
            <a href="{{ route('gallery') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">GALLERY</a>
            <a href="{{ route('contact') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CONTACT</a>

            @if (!session('user'))
            <button onclick="openModal(); toggleMobileMenu();"
                class="mt-4 bg-[#262626] bg-opacity-90 shadow-md border-white border-2 text-white px-6 py-2 rounded-full font-bold hover:bg-gradient-to-r hover:from-[#212529] hover:to-[#3a4148] transition-all duration-300">
                LOGIN
            </button>
            @endif
        </nav>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden backdrop-blur-sm" id="mobileMenuOverlay"></div>

    <!-- Banner -->
    <div class="hero-banner">
        <div class="hero-content">
            <h1 class="font-black buns-text text-4xl md:text-5xl lg:text-6xl">Buns Ceramics</h1>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-6 md:px-20 py-12 md:py-16">

        <!-- About -->
        <div class="mb-16 md:mb-24 text-center" id="about">
            <h2 class="text-3xl md:text-4xl font-bold mb-6 md:mb-8">WHAT IS BUNS CERAMICS?</h2>
            <p class="text-lg md:text-xl max-w-4xl mx-auto">
                Buns Ceramics adalah salah satu tempat kerajinan tanah liat di Bandung yang menyediakan layanan seperti
                wheel throwing, handbuilding, dan painting.
            </p>
        </div>

        <!-- Class Section -->
        <div class="mb-16 md:mb-24">
            <h2 class="text-3xl md:text-4xl font-bold mb-8 md:mb-12 text-center" id="class">RECOMMENDED CLASS</h2>

            <!-- Rekomendasi Class -->
            @foreach ($langganans as $index => $langganan)
            <div
                class="flex flex-wrap {{ $index % 2 == 1 ? 'md:flex-row-reverse' : '' }} items-center mb-12 md:mb-16">
                <div class="w-full md:w-1/2 mb-6 md:mb-0">
                    <img src="{{ asset('storage/langganan_images/' . $langganan->gambar_subs) }}"
                        alt="{{ $langganan->pilihan_subs }}" class="rounded-lg shadow-lg mx-auto" 
                        style="width: 100%; height: 400px; object-fit: cover;"/>
                </div>
                <div class="w-full md:w-1/2 px-4 md:px-6">
                    <h3 class="text-2xl md:text-3xl font-bold mb-3 md:mb-4">{{ $langganan->pilihan_subs }}</h3>
                    <p class="text-base md:text-lg mb-4 md:mb-6">{{ $langganan->penjelasan_subs }}</p>
                    <button class="bg-[#592727] text-white px-6 md:px-8 py-2 md:py-3 rounded-lg font-bold inline-block hover:bg-[#662f28] transition-all"
                        data-langganan='@json($langganan)' onclick="showClassDetail({{ $langganan->id_langganan }})">
                        DETAIL
                    </button>
                </div>
            </div>
            @endforeach

            <!-- Detail Modal -->
            <div id="classDetailModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-2xl w-full max-w-4xl mx-4" style="max-height: 90vh;">

                    <!-- Close Button -->
                    <button onclick="closeClassDetail()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors rounded-full w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Modal Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 h-full max-h-[90vh] overflow-y-auto scrollbar-hide">
                        <div class="h-64 lg:h-auto bg-gray-100 flex items-center justify-center relative overflow-hidden rounded-l-lg">
                            <img id="detailClassImage" src="" alt="Class Image" class="hidden absolute inset-0 w-full h-full object-cover">
                            <svg id="detailClassImagePlaceholder" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
                                    @if(session('user'))
                                    <a href="{{ route('subscribe') }}"
                                        onclick="return onSubscribeClick()"
                                        class="w-full md:w-auto px-8 py-3 bg-[#592727] text-white rounded-lg font-bold hover:bg-[#662f28] transition-colors text-center">
                                        Subscribe Now
                                    </a>

                                    @else
                                    <button onclick="openModal(); closeClassDetail();" class="w-full md:w-auto px-8 py-3 bg-[#592727] text-white rounded-lg font-bold hover:bg-[#662f28] transition-colors">
                                        Subscribe Now
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Master Keramik Section -->
            <div class="relative mb-12 md:mb-16">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="relative z-20 w-full md:w-2/5 mb-6 md:mb-0 md:mr-[-30px]">
                        <div class="bg-[#592727] text-white p-6 md:p-8 shadow-lg"
                            style="box-shadow: 8px 8px 0px rgba(0, 0, 0, 0.3);">
                            <h3 class="text-xl md:text-2xl font-bold mb-3">Dibimbing Master Keramik Gokil!</h3>
                            <p class="mb-2 text-sm md:text-base">Belajar dari suhu yang seru dan asik!</p>
                            <p class="mb-2 text-sm md:text-base">Mereka siap membongkar rahasia teknik keramik dan
                                memberikan trik jitu.</p>
                            <p class="text-sm md:text-base">Semua pertanyaan diterima, yang ada hanya semangat membara!
                            </p>
                        </div>
                    </div>

                    <div class="w-full md:w-3/5 relative z-10">
                        <img src="{{ asset('images/content1.jpg') }}" alt="Pottery Class"
                            class="w-full h-auto max-h-[430px] object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                </div>
            </div>

            <!-- Transformasi Kilat Section -->
            <div class="relative mb-12 md:mb-16">
                <div class="flex flex-col-reverse md:flex-row items-center">
                    <div class="w-full md:w-3/5 relative z-10">
                        <img src="{{ asset('images/content2.jpg') }}" alt="Hands with Clay"
                            class="w-full h-auto max-h-[400px] object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>

                    <div class="relative z-20 w-full md:w-2/5 mb-6 md:mb-0 md:ml-[-30px]">
                        <div class="bg-[#592727] text-white p-6 md:p-8 shadow-lg"
                            style="box-shadow: 8px 8px 0px rgba(0, 0, 0, 0.3);">
                            <h3 class="text-xl md:text-2xl font-bold mb-3">Transformasi Kilat Jadi Seniman Keramik!
                            </h3>
                            <p class="mb-2 text-sm md:text-base">Nggak perlu bertahun-tahun untuk jadi ahli!</p>
                            <p class="mb-2 text-sm md:text-base">Di bootcamp ini, kamu akan belajar teknik penting
                                dengan
                                cepat dan efektif.</p>
                            <p class="text-sm md:text-base">Siap-siap takjub dengan perkembangan diri dan karya-karya
                                keren
                                yang akan kamu ciptakan!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gabung Geng Kreatif Section -->
            <div class="relative mb-12 md:mb-16">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="relative z-20 w-full md:w-2/5 mb-6 md:mb-0 md:mr-[-30px]">
                        <div class="bg-[#592727] text-white p-6 md:p-8 shadow-lg"
                            style="box-shadow: 8px 8px 0px rgba(0, 0, 0, 0.3);">
                            <h3 class="text-xl md:text-2xl font-bold mb-3">Gabung Geng Kreatif Penuh Inspirasi!</h3>
                            <p class="mb-2 text-sm md:text-base">Bukan cuma belajar, tapi juga dapat teman
                                seperjuangan!
                            </p>
                            <p class="mb-2 text-sm md:text-base">Di sini, kamu bisa kolaborasi, tukar ide gila, daan
                                saling
                                dukung buat jadi yang terbaik.</p>
                            <p class="text-sm md:text-base">Siap-siap terinspirasi dan termotivasi setiap hari!</p>
                        </div>
                    </div>

                    <div class="w-full md:w-3/5 relative z-10">
                        <img src="{{ asset('images/content3.jpg') }}" alt="Creative Group"
                            class="w-full h-auto max-h-[430px] object-cover" />
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                </div>
            </div>

    </main>

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

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="loginUsername" name="username" placeholder="Username"
                                class="flex-1 p-2 outline-none" required>
                        </div>

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
                                class="flex-1 p-2 outline-none" required>
                        </div>

                        <button type="submit"
                            class="w-full bg-[#262626] text-white py-2 rounded-lg hover:bg-opacity-90 transition-all">
                            Login
                        </button>

                        {{-- Link lupa password --}}
                        <div class="text-center">
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-gray-500 hover:text-gray-800 underline transition-all">
                                Lupa Password?
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

                    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                        @csrf
                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="registerUsername" name="username" placeholder="Username"
                                class="flex-1 p-2 outline-none" required>
                        </div>

                        <div class="flex border rounded-lg overflow-hidden">
                            <div class="bg-gray-100 p-3 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input type="email" name="email" placeholder="Email" class="flex-1 p-2 outline-none"
                                required>
                        </div>

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
                                class="flex-1 p-2 outline-none" required>
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
    <footer class="bg-[#262626] text-white py-16">
        <div class="container mx-auto px-4 md:px-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

                <div>
                    <a href="#about" class="block mb-4 hover:text-red-400">About us</a>
                    {{-- <a href="{{ route('class') }}" class="block mb-4 hover:text-red-400">Class</a> --}}
                    {{-- <a href="#class" class="block mb-4 hover:text-red-400">Recommended Class</a> --}}
                    {{-- <a href="#" class="block mb-4 hover:text-red-400">Testimoni</a> --}}
                </div>

                <div>
                    <a href="{{ route('index') }}" class="block mb-4 hover:text-red-400">Home</a>
                    <a href="{{ route('class') }}" class="block mb-4 hover:text-red-400">Class</a>
                    <a href="#" class="block mb-4 hover:text-red-400">Gallery</a>
                    <a href="{{ route('contact') }}" class="block mb-4 hover:text-red-400">Contact</a>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex-shrink-0 w-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                </rect>
                                <circle cx="12" cy="12" r="4"></circle>
                            </svg>
                        </div>
                        <span class="text-lg">buns.ceramics</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-6 pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="text-base">Gg. Babakan Asih Dalam, Babakan Asih, Kec. Bojongloa Kaler, Kota
                            Bandung, Jawa Barat</div>
                    </div>
                </div>
            </div>

            <div class="text-center border-t border-gray-700 pt-8">
                <p>Copyright © 2025 Buns ceramics. All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <script>
        let selectedLangganan = null;

        document.addEventListener('DOMContentLoaded', function() {
            window.openModal = function() {
                document.getElementById('authModal').classList.remove('hidden');
                document.getElementById('authModal').classList.add('flex');
                showLogin();
                document.getElementById('loginUsername').focus();
            };

            window.closeModal = function() {
                document.getElementById('authModal').classList.add('hidden');
                document.getElementById('authModal').classList.remove('flex');
            };

            window.showLogin = function() {
                document.getElementById('loginPanel').classList.remove('hidden');
                document.getElementById('registerPanel').classList.add('hidden');
                document.getElementById('backButton').classList.add('hidden');
                document.getElementById('loginUsername').focus();
            };

            window.showRegister = function() {
                document.getElementById('loginPanel').classList.add('hidden');
                document.getElementById('registerPanel').classList.remove('hidden');
                document.getElementById('backButton').classList.remove('hidden');
                document.getElementById('registerUsername').focus();
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
                document.getElementById('detailClassPrice').textContent = `Rp. ${parseInt(classData.harga_subs).toLocaleString()}`;
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


        function printMemberCard() {
            const memberCardContent = document.getElementById('memberCardArea').innerHTML;

            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write(`
        <html>
            <head>
                <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
                <style>
                    body {
                        font-family: sans-serif;
                        padding: 20px;
                    }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                ${memberCardContent}
            </body>
        </html>
    `);
            printWindow.document.close();
        }
    </script>

</body>

</html>