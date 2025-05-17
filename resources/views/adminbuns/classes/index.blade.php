@extends('layouts.admin')

@section('content')
<div class="p-4">
    <div class="flex justify-center">
        <h2 class="text-4xl font-bold mb-6 text-gray-800">Kelola Kelas</h2>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6 w-full">
        <!-- Tombol Tambah Kelas -->
        <button onclick="openModal('createModal')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow transition-transform duration-200 transform hover:-translate-y-1">
            + Tambah Kelas
        </button>
        <!-- Spacer fleksibel -->
        <div class="flex-1 flex justify-center">
            <form method="GET" action="{{ route('adminbuns.classes.index') }}" class="flex">
                <input type="text" name="search" placeholder="Cari Kelas..." 
                    value="{{ request('search') }}"
                    class="w-96 border p-2 rounded-l focus:outline-none focus:ring-0 focus:ring-gray-300">
                <button type="submit" 
                    class="text-white px-4 py-2 rounded-r flex items-center justify-center bg-gray-800 hover:bg-gray-950">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
        <div style="width: 120px;"></div>
    </div>

    <!-- Tabel -->
    <div class="min-h-[500px] overflow-x-auto bg-white rounded shadow">
        <table class="min-h-[500px] min-w-full text-sm">
            <thead class="text-white text-left" style="background: #343a40">
                <tr>
                    <th class="py-3 px-3 border-b text-center w-[25%]">Kelas</th>
                    <th class="py-3 px-3 border-b text-center w-[75%]">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($langganans as $langganan)
                <tr class="border-t">
                    <td class="py-3 px-7 bg-white hover:bg-gray-50 border-r border-gray-200">
                        <div class="mb-4 w-full h-48 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                            @if($langganan->gambar_subs)
                                <img src="{{ asset('storage/langganan_images/' . $langganan->gambar_subs) }}" 
                                     alt="Gambar Kelas {{ $langganan->pilihan_subs }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="text-gray-400 text-center p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>
                        <strong>Nama Kelas:</strong>
                        <hr class="border-t border-gray-500 my-1">
                        <div class="text-left mb-3 text-amber-950">`<b>{{ $langganan->pilihan_subs }}</b>`</div>
                        <br>
                        <strong>Harga:</strong>
                        <hr class="border-t border-gray-500 my-1">
                        <div class="text-justify mb-3">Rp. {{ number_format($langganan->harga_subs, 0, ',', '.') }}</div>
                        <br>
                        <strong>Aksi:</strong>
                        <hr class="border-t border-gray-500 my-1">
                        <div class="flex items-center gap-2 mt-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('adminbuns.classes.edit', $langganan->id_langganan) }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-transform duration-200 transform hover:-translate-y-1">
                                Edit
                            </a>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('adminbuns.classes.destroy', $langganan->id_langganan) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteConfirmation(this)"
                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-transform duration-200 transform hover:-translate-y-1">
                                    Hapus
                                </button>
                            </form>
                            <!-- Modal Konfirmasi Hapus -->
                            <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                                    <h3 class="text-lg font-semibold mb-4">Hapus Data Kelas</h3>
                                    <p class="mb-6">Apakah Data Kelas ingin dihapus?</p>
                                    <div class="flex justify-end space-x-3">
                                        <button onclick="hideDeleteConfirmation()" class="px-4 py-2 text-white rounded bg-gray-500 hover:bg-gray-600">
                                            Cancel
                                        </button>
                                        <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-7 bg-white hover:bg-gray-50">
                        <strong>Penjelasan:</strong>
                        <hr class="border-t border-gray-500 my-1">
                        <div class="text-justify mb-3">{{ $langganan->penjelasan_subs }}</div>
                        <br>
                        <strong>Benefit:</strong>
                        <hr class="border-t border-gray-500 my-1">
                        <div class="overflow-y-auto h-48">
                            <ul class="list-disc ml-5">
                                @foreach(json_decode($langganan->benefit_subs, true) as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="mt-4">
        {{ $langganans->links() }}
    </div>
</div>

<!-- Modal Tambah -->
<div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-xl relative my-8">
        <!-- Modal Header -->
        <div class="border-b border-gray-200 pb-4 mb-4">
            <h3 class="text-2xl font-semibold text-gray-800 flex justify-center">Tambah Kelas</h3>
        </div>
        
        <div>
            <form action="{{ route('adminbuns.classes.store') }}" method="POST" id="classForm" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4 max-h-[60vh] overflow-y-auto px-2">
                    <!-- Nama Kelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                        <input type="text" name="pilihan_subs" placeholder="Masukkan Nama Kelas" 
                               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">
                        <span class="text-red-500 text-sm error-msg" id="error-pilihan_subs">
                            @if($errors->has('pilihan_subs'))
                                {{ $errors->first('pilihan_subs') }}
                            @endif
                        </span>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input type="number" step="0.01" name="harga_subs" placeholder="Masukkan Harga" 
                               class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">
                        <span class="text-red-500 text-sm error-msg" id="error-harga_subs">
                            @if($errors->has('harga_subs'))
                                {{ $errors->first('harga_subs') }}
                            @endif
                        </span>
                    </div>

                    <!-- Penjelasan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penjelasan</label>
                        <textarea name="penjelasan_subs" placeholder="Masukkan Penjelasan Kelas" 
                                class="w-full h-32 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent"></textarea>
                        <span class="text-red-500 text-sm error-msg" id="error-penjelasan_subs">
                            @if($errors->has('penjelasan_subs'))
                                {{ $errors->first('penjelasan_subs') }}
                            @endif
                        </span>
                    </div>

                    <!-- Gambar Kelas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Kelas</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center">
                            <div id="uploadArea" class="flex flex-col items-center justify-center space-y-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="uploadIcon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <label for="gambar_subs" class="cursor-pointer mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out" id="uploadButton">
                                    Pilih Gambar
                                    <input type="file" id="gambar_subs" name="gambar_subs" class="hidden" accept="image/*">
                                </label>
                            </div>
                            <span class="text-red-500 text-sm error-msg" id="error-gambar_subs">
                                @if($errors->has('gambar_subs'))
                                    {{ $errors->first('gambar_subs') }}
                                @endif
                            </span>

                            <div id="imagePreviewContainer" class="hidden mt-2">
                                <img id="imagePreview" class="max-h-40 mx-auto rounded" alt="Preview">
                            </div>

                            <div id="fileInfoArea" class="hidden">
                                <p id="file-name" class="text-sm text-gray-700 mt-2"></p> <br>
                                <button type="button" onclick="removeImage()" class="mt-1 text-red-500 hover:text-red-700 text-sm flex items-center justify-center mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Gambar
                                </button>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                    </div>

                    <!-- Benefit Section -->
                    <div class="mb-4">                      
                        <label class="block text-sm font-medium text-gray-700 mb-2">Benefit</label>
                        <div id="benefitList" class="overflow-y-auto rounded-md p-2">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="text" name="benefit_subs[]" placeholder="Masukkan Benefit"
                                       class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent benefit-input">
                                <button type="button" onclick="removeBenefit(this)" class="text-gray-500 hover:text-red-500 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <span class="text-red-500 text-sm error-msg" id="error-benefit_subs">
                            @if($errors->has('benefit_subs'))
                                {{ $errors->first('benefit_subs') }}
                            @endif
                        </span>
                        <button type="button" onclick="addBenefit()" class="mt-2 flex items-center text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Benefit
                        </button>
                    </div>
                </div>

                <!-- Modal Footer - Sticky di bagian bawah -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Tutup
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Benefit Management
function addBenefit() {
    const container = document.getElementById('benefitList');
    const div = document.createElement('div');
    div.classList.add('flex', 'items-center', 'gap-2', 'mb-2');
    div.innerHTML = `
        <input type="text" name="benefit_subs[]" placeholder="Masukkan Benefit"
               class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent benefit-input">
        <button type="button" onclick="removeBenefit(this)" class="text-gray-500 hover:text-red-500 p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function removeBenefit(button) {
    const container = document.getElementById('benefitList');
    const benefitItems = container.querySelectorAll('div.flex.items-center');
    
    // Don't allow removal if it's the last item
    if (benefitItems.length > 1) {
        button.parentNode.remove();
    }
}

// Form validation with AJAX support
document.getElementById('classForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Reset error messages
    document.querySelectorAll('.error-msg').forEach(function(el) {
        el.textContent = '';
    });
    
    // Create form data for submission
    const formData = new FormData(this);
    const modalId = 'createModal'; // Modal ID hardcoded to ensure it matches
    const form = this;
    
    // Process benefit inputs
    const benefitInputs = document.querySelectorAll('.benefit-input');
    let benefits = [];
    
    benefitInputs.forEach(input => {
        if (input.value.trim() !== '') {
            benefits.push(input.value.trim());
        }
    });
    
    // Add benefits to formData
    benefits.forEach((benefit, index) => {
        formData.append(`benefit_subs[${index}]`, benefit);
    });
    
    // Disable submit button to prevent double submission
    const submitButton = form.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerText = 'Menyimpan...';
    }
    
    // Send AJAX request
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        // Check if it's JSON response
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json().then(data => {
                // JSON response handling
                if (data.errors) {
                    // Re-enable submit button
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerText = 'Simpan';
                    }
                    
                    // Display validation errors
                    Object.keys(data.errors).forEach(field => {
                        const errorElement = document.getElementById('error-' + field);
                        if (errorElement) {
                            errorElement.textContent = data.errors[field][0];
                        }
                    });
                } else if (data.success) {
                    // Success - Close modal then reload page
                    closeModal(modalId);
                    window.location.reload();
                
                } else {
                    // Fallback for other JSON responses - assume success and reload
                    closeModal(modalId);
                    window.location.reload();
                }
            });
        } else {
            // Non-JSON response (e.g. HTML redirect) - assume success
            closeModal(modalId);
            window.location.reload();
            return null;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Re-enable submit button on error
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.innerText = 'Simpan';
        }
        
        // Even on error, we'll close the modal as the server might have processed the data
        closeModal(modalId);
        window.location.reload();
    });
});

// Client-side form validation
function validateForm() {
    // For backward compatibility
    return true;
}

// Modal functions
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    // Reset the form
    document.getElementById('classForm').reset();
    
    // Clear all error messages
    document.querySelectorAll('.error-msg').forEach(function(el) {
        el.textContent = '';
    });
    
    // Reset benefit inputs to just one
    const container = document.getElementById('benefitList');
    container.innerHTML = `
        <div class="flex items-center gap-2 mb-2">
            <input type="text" name="benefit_subs[]" placeholder="Masukkan Benefit"
                    class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent benefit-input">
            <button type="button" onclick="removeBenefit(this)" class="text-gray-500 hover:text-red-500 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    
    // Reset image upload
    removeImage();
}

// Form Delete 
let currentForm = null;

function showDeleteConfirmation(button) {
    currentForm = button.closest('form');
    document.getElementById('deleteModal').classList.remove('hidden');
}

function hideDeleteConfirmation() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (currentForm) {
        currentForm.submit();
    }
});

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Preview gambar dan tampilkan nama file
document.getElementById('gambar_subs').addEventListener('change', function(e) {
    const fileInput = e.target;
    const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
    
    // Update file name display
    document.getElementById('file-name').textContent = fileName;
    
    // Hide upload elements and show file info
    document.getElementById('uploadArea').classList.add('hidden');
    document.getElementById('fileInfoArea').classList.remove('hidden');
    
    // Preview gambar
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
        }
        
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        document.getElementById('imagePreviewContainer').classList.add('hidden');
    }
});

// Fungsi untuk menghapus gambar
function removeImage() {
    document.getElementById('gambar_subs').value = '';
    document.getElementById('file-name').textContent = 'No file chosen';
    document.getElementById('imagePreviewContainer').classList.add('hidden');
    document.getElementById('imagePreview').src = '';
    
    // Show upload elements and hide file info
    document.getElementById('uploadArea').classList.remove('hidden');
    document.getElementById('fileInfoArea').classList.add('hidden');
}

</script>
@endsection
