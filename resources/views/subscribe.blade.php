<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Form</title>
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

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
    </style>
    <script>
        function updateSubscriptionDetails() {
            const selectElement = document.getElementById('langganan_id');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const gambar = selectedOption.getAttribute('data-gambar') || '';
            const langgananId = selectedOption.getAttribute('data-id-langganan');
            const harga = selectedOption.getAttribute('data-harga');
            const penjelasan = selectedOption.getAttribute('data-penjelasan');
            const benefits = JSON.parse(selectedOption.getAttribute('data-benefits') || '[]');

            document.getElementById('langganan_id_hidden').value = langgananId;
            document.getElementById('harga_subs').value = harga;
            document.getElementById('harga_display').textContent = 'Rp ' + harga;
            document.getElementById('penjelasan_subs').value = penjelasan;

            const benefitList = document.getElementById('benefitList');
            benefitList.innerHTML = '';

            if (benefits && benefits.length > 0) {
                benefits.forEach(benefit => {
                    if (benefit && benefit.trim() !== '') {
                        const li = document.createElement('li');
                        li.className = 'flex items-start';
                        li.innerHTML = `
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        ${benefit.replace(/["\[\]]/g, '')}
                    `;
                        benefitList.appendChild(li);
                    }
                });
            } else {
                benefitList.innerHTML = '<li class="text-gray-500">No benefits available</li>';
            }
            setSubscriptionImage(gambar);

            updatePrice();
        }

        function updatePrice() {
            const duration = document.getElementById('pilihan_hari').value;
            const selectedOption = document.getElementById('langganan_id').options[document.getElementById('langganan_id')
                .selectedIndex];
            let basePrice = parseFloat(selectedOption.getAttribute('data-harga'));

            let finalPrice = basePrice;

            if (duration === '15') {
                finalPrice = basePrice * 0.9;
            } else if (duration === '5') {
                finalPrice = basePrice * 0.8;
            }

            document.getElementById('harga_display').textContent = `Rp ${finalPrice.toFixed(2)}`;
            document.getElementById('harga_subs').value = finalPrice.toFixed(2);
        }

        function setSubscriptionImage(gambar_subs) {
            const imgElement = document.getElementById('subscriptionImage');
            if (gambar_subs) {
                imgElement.src = `/storage/langganan_images/${gambar_subs}`;
                imgElement.classList.remove('hidden');
            } else {
                imgElement.src = '';
                imgElement.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('langganan_id').addEventListener('change', function() {
        updateSubscriptionDetails();
        updatePilihanHariHidden(); // update juga pilihan hari hidden setiap ganti subscription
    });

    document.getElementById('pilihan_hari').addEventListener('change', function() {
        updatePrice();
        updatePilihanHariHidden(); // update pilihan hari hidden setiap ganti durasi
    });

    // LocalStorage logic
    const storedLangganan = localStorage.getItem('selectedLangganan');
    if (storedLangganan) {
        const langganan = JSON.parse(storedLangganan);

        const select = document.getElementById('langganan_id');
        const options = select.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].getAttribute('data-id-langganan') == langganan.id_langganan) {
                options[i].selected = true;
                break;
            }
        }

        updateSubscriptionDetails();
        updatePilihanHariHidden();

        localStorage.removeItem('selectedLangganan');
    } else {
        updateSubscriptionDetails();
        updatePilihanHariHidden();
    }
});


    function updatePilihanHariHidden() {
    const duration = document.getElementById('pilihan_hari').value;
    document.getElementById('pilihan_hari_hidden').value = duration;
}

    </script>
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

        <div class="hidden lg:block">
            @if (session('user'))
                @php
                    $role = strtolower(session('user')->role ?? '');
                    $canClick = $role === 'member';
                @endphp
                <div class="user-menu-wrapper flex items-center gap-3 order-1 lg:order-2">
                    <span
                        class="role-badge bg-[#212529] bg-opacity-90 shadow-md border-white border-2 text-white px-4 py-1 rounded-full font-bold text-sm {{ $canClick ? 'cursor-pointer' : 'cursor-default' }}"
                        @if ($canClick) onclick="showMemberInfo()" @endif>
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
                            <a href="#"
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
                                            d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 text-sm">
                                    {{ $member->nama_member }}
                                </div>
                            </div>

                            <div class="relative">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <svg class="w-5 w-5" fill="currentColor" viewBox="0 0 20 20">
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
                                    {{ $latestTransaction ? $latestTransaction->nama_kelas : 'No class yet' }}
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

    <!-- Subscription Content -->
    <div class="pt-28 pb-12 px-6 md:px-20 min-h-screen">
        <!-- Back Button -->
        <div class="max-w-4xl mx-auto mb-4">
            <a href="{{ route('class') }}" class="inline-flex items-center text-[#7D3E35] hover:text-[#662f28] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Classes
            </a>
        </div>

        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="md:flex">
                <!-- Subscription Image with Shadow -->
                <div class="md:w-1/3 p-6 flex flex-col items-center">
                    <div class="w-full mb-6">
                        <img id="subscriptionImage" src="" alt="Subscription Image"
                            class="w-full h-48 object-cover rounded-lg hidden md:block transform transition-all duration-300 hover:scale-105"
                            style="box-shadow: 8px 8px 0px rgba(0, 0, 0, 0.3);">
                    </div>
                    
                    <div class="w-full">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Subscription Details</h3>
                        
                        <!-- <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <p id="harga_display" class="text-2xl font-bold text-[#7D3E35]">
                                Rp {{ $selectedLangganan ? number_format($selectedLangganan->harga_subs, 0, ',', '.') : '0' }}
                            </p>
                            <input type="hidden" name="harga_subs" id="harga_subs"
                                value="{{ $selectedLangganan ? $selectedLangganan->harga_subs : '' }}">
                        </div> -->
                        
                        <div class="mb-4">
                            <label for="pilihan_hari" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                            <select id="pilihan_hari" name="pilihan_hari"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7D3E35] focus:border-[#7D3E35]">
                                <option value="30">30 Days</option>
                                <option value="15">15 Days</option>
                                <option value="5">5 Days</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Benefits</label>
                            <ul id="benefitList" class="space-y-2">
                                <li class="text-gray-500">No benefits available</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Subscription Form -->
                <div class="md:w-2/3 p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Subscription Form</h2>
                    
                    <form method="POST" action="{{ route('subscribe.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="email_member" value="{{ $data['email_member'] }}">
                        <input type="hidden" name="id_account" id="id_account" value="{{ $data['id_account'] }}">
                        <input type="hidden" name="pilihan_hari" id="pilihan_hari_hidden" value="30"> <!-- default 30 -->

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_member" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="nama_member" id="nama_member"
                                    value="{{ old('nama_member', $data['nama_member']) }}"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7D3E35] focus:border-[#7D3E35]"
                                    required>
                            </div>
                            
                            <div>
                                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" name="no_telp" id="no_telp"
                                    value="{{ old('no_telp', $data['no_telp']) }}"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7D3E35] focus:border-[#7D3E35]"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label for="alamat_member" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="alamat_member" id="alamat_member"
                                value="{{ old('alamat_member', $data['alamat_member']) }}"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7D3E35] focus:border-[#7D3E35]"
                                required>
                        </div>

                        <div>
                            <label for="langganan_id" class="block text-sm font-medium text-gray-700 mb-1">Subscription Type</label>
                            <select name="pilihan_subs" id="langganan_id"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7D3E35] focus:border-[#7D3E35]"
                                required>
                                <option value="">Select Subscription</option>
                                @foreach ($data['langganans'] as $langganan)
                                    <option value="{{ $langganan->pilihan_subs }}"
                                        data-id-langganan="{{ $langganan->id_langganan }}" 
                                        data-harga="{{ $langganan->harga_subs }}"
                                        data-penjelasan="{{ $langganan->penjelasan_subs }}"
                                        data-benefits="{{ json_encode($langganan->benefit_subs) }}"
                                        data-gambar="{{ $langganan->gambar_subs }}"
                                        {{ isset($selectedLangganan) && $selectedLangganan->id_langganan == $langganan->id_langganan ? 'selected' : '' }}>
                                        {{ $langganan->pilihan_subs }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="langganan_id" id="langganan_id_hidden" value="">
                        </div>

                        <div>
                            <label for="penjelasan_subs" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="penjelasan_subs" id="penjelasan_subs"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-[#7D3E35] focus:border-[#7D3E35] h-32"
                                readonly></textarea>
                        </div>
                          <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <p id="harga_display" class="text-2xl font-bold text-[#7D3E35]">
                                Rp {{ $selectedLangganan ? number_format($selectedLangganan->harga_subs, 0, ',', '.') : '0' }}
                            </p>
                            <input type="hidden" name="harga_subs" id="harga_subs"
                                value="{{ $selectedLangganan ? $selectedLangganan->harga_subs : '' }}">
                        </div>
                        <button type="submit"
                            class="w-full bg-[#7D3E35] text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#662f28] transition-colors duration-200 shadow-md hover:shadow-lg">
                            Subscribe Now
                        </button>
                    </form>
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

                        <div class="text-center">
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-gray-500 hover:text-gray-800 underline transition-all">
                                Forgot Password?
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
    </script>
</body>
</html>