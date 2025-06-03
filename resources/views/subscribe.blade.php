<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
<script>
    // Pindahkan fungsi ke global supaya bisa dipanggil dari mana saja
    function updateSubscriptionDetails() {
        const selectElement = document.getElementById('langganan_id');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        
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
            benefitList.innerHTML = '<li class="text-gray-500">Tidak ada benefit tersedia</li>';
        }

        updatePrice();
    }

    function updatePrice() {
        const duration = document.getElementById('pilihan_hari').value;
        const selectedOption = document.getElementById('langganan_id').options[document.getElementById('langganan_id').selectedIndex];
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

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('langganan_id').addEventListener('change', updateSubscriptionDetails);
        document.getElementById('pilihan_hari').addEventListener('change', updatePrice);

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

            localStorage.removeItem('selectedLangganan');
        } else {
            updateSubscriptionDetails();
        }
    });
</script>
</head>
<body class="bg-gray-100 font-sans flex justify-center items-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Subscription Form</h2>

    <form method="POST" action="{{ route('subscribe.store') }}">
    @csrf

    <input type="hidden" name="email_member" value="{{ $data['email_member'] }}">
    <div class="mb-4">
        <label for="nama_member" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" name="nama_member" id="nama_member"
            value="{{ old('nama_member', $data['nama_member']) }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            required>
    </div>

    <div class="mb-4">
        <label for="alamat_member" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" name="alamat_member" id="alamat_member"
            value="{{ old('alamat_member', $data['alamat_member']) }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            required>
    </div>

    <div class="mb-4">
        <label for="no_telp" class="block text-sm font-medium text-gray-700">Phone</label>
        <input type="text" name="no_telp" id="no_telp"
            value="{{ old('no_telp', $data['no_telp']) }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            required>
    </div>
            <div class="mb-4">
                
                <input type="hidden" name="id_account" id="id_account" value="{{ $data['id_account'] }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" >
            </div>

            <div class="mb-4">
                <label for="langganan_id" class="block text-sm font-medium text-gray-700">Subscription Type</label>
                <select name="pilihan_subs" id="langganan_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Select Subscription</option>
                    @foreach($data['langganans'] as $langganan)
                        <option value="{{ $langganan->pilihan_subs }}" 
                                data-id-langganan="{{ $langganan->id_langganan }}"
                                data-harga="{{ $langganan->harga_subs }}"
                                data-penjelasan="{{ $langganan->penjelasan_subs }}"
                                data-benefits="{{ json_encode($langganan->benefit_subs) }}"
                                {{ isset($selectedLangganan) && $selectedLangganan->id_langganan == $langganan->id_langganan ? 'selected' : '' }}>
                            {{ $langganan->pilihan_subs }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="langganan_id" id="langganan_id_hidden" value="">
            </div>

            <div class="mb-4">
                <label for="penjelasan_subs" class="block text-sm font-medium text-gray-700">Subscription Explanation</label>
                <textarea name="penjelasan_subs" id="penjelasan_subs" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" rows="4" readonly></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Subscription Benefits</label>
                <ul id="benefitList" class="mt-2 space-y-2">
                    <li class="text-gray-500">Tidak ada benefit tersedia</li>
                </ul>
            </div>

            <div class="mb-4">
                <label for="pilihan_hari" class="block text-sm font-medium text-gray-700">Duration</label>
                <select id="pilihan_hari" name="pilihan_hari" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="30">30 Days</option>
                    <option value="15">15 Days</option>
                    <option value="5">5 Days</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Price</label>
                <p id="harga_display" class="text-lg font-semibold text-blue-600">Rp {{ $selectedLangganan ? $selectedLangganan->harga_subs : '' }}</p>
                <input type="hidden" name="harga_subs" id="harga_subs" value="{{ $selectedLangganan ? $selectedLangganan->harga_subs : '' }}">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                Subscribe
            </button>
        </form>
    </div>

</body>
</html>