<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HISTORY</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⏳</text></svg>">
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

        .history {
            font-family: 'Itim', cursive, sans-serif;
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

        .font-playfair {
            font-family: 'Playfair Display', serif;
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
                class="font-bold text-lg text-white relative hover:after:content-[''] hover:after:absolute hover:after:-bottom-1 hover:after:left-0 hover:after:w-full hover:after:h-0.5 hover:after:bg-[#7D3E35]">Class</a>
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
            <a href="{{ route('class') }}"
                class="nav-item font-bold text-xl text-white py-2 border-b border-gray-700">CLASS</a>
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

    <!-- History Content -->
    <section class="pt-32 pb-16 px-6 md:px-20">
        <div class="container mx-auto">
            <div class="relative flex justify-center items-center mb-8">
                <a href="{{ route('index') }}"
                    class="absolute left-0 text-[#592727] hover:text-[#7D3E35] p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="history text-3xl md:text-4xl font-bold text-center text-[#262626]">History</h1>
            </div>

            @if (!$member)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg mb-4">You don't have any transaction history yet</p>
                        <a href="{{ route('class') }}"
                            class="bg-[#592727] hover:bg-[#7D3E35] text-white font-bold py-2 px-6 rounded-lg inline-flex items-center transition-colors">
                            Upgrade to Member
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#262626]">
                                <tr class="history">
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Class
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Completion
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Invoice
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $transaction->nama_kelas }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                {{ $transaction->tanggal_transaksi->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">
                                                @if ($transaction->ended_date)
                                                    {{ $transaction->ended_date->format('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="showInvoiceModal('{{ $transaction->order_id }}')"
                                                class="bg-[#592727] hover:bg-[#7D3E35] text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Invoice
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-8 flex justify-center">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Invoice Modal -->
    <div id="invoiceModal"
        class="fixed hidden inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <button onclick="closeInvoiceModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition-colors rounded-full w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-100 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="p-6 md:p-8">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Invoice Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Order Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Order ID</p>
                                <p id="invoiceOrderId" class="font-medium text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Class Name</p>
                                <p id="invoiceClassName" class="font-medium text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Order Date</p>
                                <p id="invoiceOrderDate" class="font-medium text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Completion Date</p>
                                <p id="invoiceCompletionDate" class="font-medium text-gray-900"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Payment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-500">Payment Method</p>
                                <p id="invoicePaymentMethod" class="font-medium text-gray-900"></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Amount</p>
                                <p id="invoiceAmount" class="font-medium text-gray-900"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="flex justify-between items-center">
                        <button onclick="printInvoice()"
                            class="bg-[#592727] hover:bg-[#7D3E35] text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zM5 14H4v-2h1v2zm1 0v2h6v-2H6zm9 0v-2h1v2h-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Print
                        </button>
                        <button onclick="closeInvoiceModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                            Close
                        </button>
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
    <x-footer />

    <script>
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

        function showInvoiceModal(orderId) {
            const modal = document.getElementById('invoiceModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            document.getElementById('invoiceOrderId').textContent = 'Loading...';
            document.getElementById('invoiceClassName').textContent = 'Loading...';
            document.getElementById('invoiceOrderDate').textContent = 'Loading...';
            document.getElementById('invoicePaymentMethod').textContent = 'Loading...';
            document.getElementById('invoiceAmount').textContent = 'Loading...';
            document.getElementById('invoiceCompletionDate').textContent = 'Loading...';

            fetch(`/transaction/${orderId}/invoice`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('invoiceOrderId').textContent = data.data.order_id;
                        document.getElementById('invoiceClassName').textContent = data.data.nama_kelas;
                        document.getElementById('invoiceOrderDate').textContent = data.data.tanggal_transaksi;
                        document.getElementById('invoicePaymentMethod').textContent = data.data.payment_method;
                        document.getElementById('invoiceAmount').textContent = data.data.total_transaksi;
                        document.getElementById('invoiceCompletionDate').textContent = data.data.ended_date;
                    } else {
                        alert('Failed to load invoice data');
                        closeInvoiceModal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while loading data');
                    closeInvoiceModal();
                });
        }

        function closeInvoiceModal() {
            document.getElementById('invoiceModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function printInvoice() {
            const printContent = `
            <div style="padding: 20px; font-family: Arial, sans-serif;">
                <h1 style="text-align: center; margin-bottom: 30px;">Buns Ceramics Invoice</h1>
                <div style="margin-bottom: 20px;">
                    <p><strong>Order ID:</strong> ${document.getElementById('invoiceOrderId').textContent}</p>
                    <p><strong>Order Date:</strong> ${document.getElementById('invoiceOrderDate').textContent}</p>
                    <p><strong>Completion Date:</strong> ${document.getElementById('invoiceCompletionDate').textContent}</p>
                </div>
                <h2 style="border-bottom: 1px solid #ddd; padding-bottom: 5px;">Order Details</h2>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                    <tr><td style="padding: 8px 0;"><strong>Class:</strong></td><td style="padding: 8px 0;">${document.getElementById('invoiceClassName').textContent}</td></tr>
                    <tr><td style="padding: 8px 0;"><strong>Payment Method:</strong></td><td style="padding: 8px 0;">${document.getElementById('invoicePaymentMethod').textContent}</td></tr>
                    <tr><td style="padding: 8px 0;"><strong>Total:</strong></td><td style="padding: 8px 0;">${document.getElementById('invoiceAmount').textContent}</td></tr>
                </table>
                <div style="margin-top: 40px; text-align: center; font-size: 12px; color: #777;"><p>Thank you for choosing Buns Ceramics</p></div>
            </div>
        `;

            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write(`
            <html>
                <head>
                    <title>Invoice</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                        h1 { color: #592727; }
                        table { width: 100%; border-collapse: collapse; }
                        td { padding: 8px 0; }
                    </style>
                </head>
                <body>${printContent}</body>
            </html>
        `);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>
</body>

</html>
