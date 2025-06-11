@extends('layouts.admin')

@section('content')
    <section id="edit-gallery" class="bg-light py-5">
        <div class="container">
            <div class="pb-2 mb-4 d-flex justify-content-center">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Edit Gallery</h2>
            </div>

            <form method="POST" action="{{ route('admin-buns.gallery.update', $gallery->id) }}" enctype="multipart/form-data"
                id="editGalleryForm" novalidate>
                @csrf
                @method('PUT')

                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-1">
                    <!-- Responsive Table Layout -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-800 text-white">
                                    <th colspan="2" class="text-left p-3 md:p-4 font-semibold">Information Gallery</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Nama Member row -->
                                <tr class="border-b border-gray-200">
                                    <td class="p-3 md:p-4 bg-gray-50 w-1/4 font-medium">Nama Member</td>
                                    <td class="p-3 md:p-4">
                                        <div class="font-normal text-gray-700">{{ $gallery->nama }}</div>
                                        <input type="hidden" name="nama" value="{{ $gallery->nama }}">
                                    </td>
                                </tr>

                                <!-- Jenis row -->
                                <tr class="border-b border-gray-200">
                                    <td class="p-3 md:p-4 bg-gray-50 font-medium">Jenis</td>
                                    <td class="p-3 md:p-4">
                                        <select
                                            class="w-full p-2 md:p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent"
                                            id="jenis" name="jenis" required>
                                            <option value="gelas" {{ $gallery->jenis == 'gelas' ? 'selected' : '' }}>Gelas
                                            </option>
                                            <option value="mangkuk" {{ $gallery->jenis == 'mangkuk' ? 'selected' : '' }}>
                                                Mangkuk
                                            </option>
                                            <option value="piring" {{ $gallery->jenis == 'piring' ? 'selected' : '' }}>
                                                Piring
                                            </option>
                                        </select>
                                        <div class="text-red-500 text-xs md:text-sm mt-1 error-msg" id="error-jenis"></div>
                                    </td>
                                </tr>

                                <!-- Gambar row -->
                                <tr class="border-b border-gray-200">
                                    <td class="p-3 md:p-4 bg-gray-50 font-medium">Gambar Gallery</td>
                                    <td class="p-3 md:p-4">
                                        <div
                                            class="border-2 border-dashed border-gray-300 rounded-md p-3 md:p-4 text-center">
                                            <!-- Current Image Display -->
                                            <div id="currentImageContainer"
                                                class="{{ $gallery->gambar ? '' : 'hidden' }} mb-3">
                                                <img id="currentImage" src="{{ asset('storage/' . $gallery->gambar) }}"
                                                    class="max-h-32 md:max-h-40 mx-auto rounded" alt="">
                                                <p id="current-file-name"
                                                    class="text-xs md:text-sm text-gray-700 mt-2 truncate">
                                                    {{ $gallery->gambar }}</p>
                                            </div>

                                            <!-- Upload Area -->
                                            <div id="uploadArea"
                                                class="{{ $gallery->gambar ? 'hidden' : 'flex flex-col items-center justify-center space-y-2' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-10 md:h-12 w-10 md:w-12 text-gray-400 mx-auto" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg> <br>
                                                <label for="gambar" required
                                                    class="cursor-pointer mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-3 md:px-4 rounded-md text-xs md:text-sm font-medium transition duration-150 ease-in-out"
                                                    id="uploadButton">
                                                    Pilih Gambar
                                                    <input type="file" id="gambar" name="gambar" class="hidden"
                                                        accept="image/*">
                                                </label>
                                            </div>

                                            <!-- New Image Preview (Initially Hidden) -->
                                            <div id="imagePreviewContainer" class="hidden mt-2">
                                                <img id="imagePreview" class="max-h-32 md:max-h-40 mx-auto rounded"
                                                    alt="Preview">
                                                <p id="new-file-name"
                                                    class="text-xs md:text-sm text-gray-700 mt-2 truncate"></p>
                                                <button type="button" onclick="removeImage()"
                                                    class="mt-1 text-red-500 hover:text-red-700 text-xs md:text-sm flex items-center justify-center mx-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-3 md:h-4 w-3 md:w-4 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus Gambar
                                                </button>
                                            </div>

                                            <!-- Hapus Gambar Button -->
                                            <div id="changeImageButtonContainer"
                                                class="{{ $gallery->gambar ? '' : 'hidden' }} mt-3">
                                                <button type="button" onclick="removeCurrentImage()"
                                                    class="mt-1 text-red-500 hover:text-red-700 text-xs md:text-sm flex items-center justify-center mx-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-3 md:h-4 w-3 md:w-4 mr-1" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus Gambar
                                                </button>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 10MB.</p>
                                        <div class="text-red-500 text-xs md:text-sm mt-1 error-msg" id="error-gambar"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Hidden input untuk menandai gambar yang dihapus -->
                <input type="hidden" name="remove_image" id="remove_image" value="0">

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-center pt-4 gap-2 sm:gap-0">
                    <a href="{{ route('admin-buns.gallery') }}"
                        class="px-3 py-2 sm:px-4 sm:py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-0 transition-transform duration-200 w-full sm:w-auto text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 md:h-5 w-4 md:w-5 inline mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>
                    <button type="submit"
                        class="px-3 py-2 sm:px-4 sm:py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-0 focus:ring-offset-2 transition-transform duration-200 w-full sm:w-auto text-center">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Script for image preview and validation -->
    <script>
        // Script for image preview and validation with success popup
        document.getElementById('editGalleryForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset error messages
            document.querySelectorAll('.error-msg').forEach(function(el) {
                el.textContent = '';
            });

            // Validasi gambar
            if (!validateImage()) {
                return; // Stop submission jika validasi gagal
            }

            // Create form data for submission
            const formData = new FormData(this);
            const form = this;

            // Disable submit button to prevent double submission
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerText = 'Memperbarui...';
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
                                    submitButton.innerText = 'Update';
                                }

                                // Display validation errors
                                Object.keys(data.errors).forEach(field => {
                                    const errorElement = document.getElementById('error-' +
                                        field);
                                    if (errorElement) {
                                        errorElement.textContent = data.errors[field][0];
                                    }
                                });
                            } else if (data.success) {
                                // SUCCESS CASE - Show success popup
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message || 'Data kelas berhasil diperbarui.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK',
                                    backdrop: 'rgba(0,0,0,0.7)',
                                    background: '#ffffff',
                                    customClass: {
                                        popup: 'success-popup'
                                    }
                                }).then(() => {
                                    window.location.href = "{{ route('admin-buns.gallery') }}";
                                });
                            } else {
                                // Fallback success case
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data kelas berhasil diperbarui.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK',
                                    backdrop: 'rgba(0,0,0,0.7)'
                                }).then(() => {
                                    window.location.href = "{{ route('admin-buns.gallery') }}";
                                });
                            }
                        });
                    } else {
                        // Non-JSON response - show success popup
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data kelas berhasil diperbarui.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                            backdrop: 'rgba(0,0,0,0.7)'
                        }).then(() => {
                            window.location.href = "{{ route('admin-buns.gallery') }}";
                        });
                        return null;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Re-enable submit button on error
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerText = 'Update';
                    }

                    // Show error message
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        backdrop: 'rgba(0,0,0,0.7)'
                    });
                });
        });

        // Fungsi validasi gambar
        function validateImage() {
            const removeImage = document.getElementById('remove_image').value;
            const newImageFile = document.getElementById('gambar').files[0];
            const currentImageExists = !document.getElementById('currentImageContainer').classList.contains('hidden');

            // Jika gambar lama dihapus (remove_image = 1) dan tidak ada gambar baru yang dipilih
            if (removeImage === '1' && !newImageFile) {
                document.getElementById('error-gambar').textContent = 'Gambar wajib diisi. Silakan pilih gambar baru.';

                // Scroll ke elemen error
                document.getElementById('error-gambar').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                return false;
            }

            // Jika tidak ada gambar sama sekali (baik lama maupun baru)
            if (!currentImageExists && !newImageFile && removeImage !== '1') {
                document.getElementById('error-gambar').textContent = 'Gambar wajib diisi. Silakan pilih gambar.';

                // Scroll ke elemen error
                document.getElementById('error-gambar').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                return false;
            }

            // Validasi ukuran file jika ada file baru
            if (newImageFile) {
                const maxSize = 10 * 1024 * 1024; // 10MB
                if (newImageFile.size > maxSize) {
                    document.getElementById('error-gambar').textContent = 'Ukuran file tidak boleh lebih dari 10MB.';
                    return false;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(newImageFile.type)) {
                    document.getElementById('error-gambar').textContent = 'Format file harus JPG, PNG, atau JPEG.';
                    return false;
                }
            }

            return true;
        }

        // Fungsi untuk menghapus preview gambar baru
        function removeImage() {
            document.getElementById('imagePreview').src = '';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');
            document.getElementById('gambar').value = '';
            document.getElementById('new-file-name').textContent = '';

            // Clear error message
            document.getElementById('error-gambar').textContent = '';
        }

        // Fungsi untuk menghapus gambar yang sudah ada
        function removeCurrentImage() {
            document.getElementById('currentImageContainer').classList.add('hidden');
            document.getElementById('changeImageButtonContainer').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');
            document.getElementById('remove_image').value = '1'; // Set nilai remove_image ke 1

            // Clear error message
            document.getElementById('error-gambar').textContent = '';

            // Tampilkan pesan info bahwa gambar baru wajib dipilih
            document.getElementById('error-gambar').textContent = 'Gambar lama telah dihapus. Silakan pilih gambar baru.';
            document.getElementById('error-gambar').style.color = '#f59e0b'; // Warning color (amber)
        }

        // Event listener untuk input file gambar
        document.getElementById('gambar').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                // Reset nilai remove_image ke 0 karena user memilih file baru
                document.getElementById('remove_image').value = '0';

                // Clear error message
                document.getElementById('error-gambar').textContent = '';
                document.getElementById('error-gambar').style.color = '#ef4444'; // Reset to red

                const file = this.files[0];

                // Validasi ukuran file
                const maxSize = 10 * 1024 * 1024; // 10MB
                if (file.size > maxSize) {
                    document.getElementById('error-gambar').textContent =
                        'Ukuran file tidak boleh lebih dari 10MB.';
                    this.value = '';
                    return;
                }

                // Validasi tipe file
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    document.getElementById('error-gambar').textContent = 'Format file harus JPG, PNG, atau JPEG.';
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('new-file-name').textContent = document.getElementById('gambar')
                        .files[0].name;
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                    document.getElementById('uploadArea').classList.add('hidden');
                    document.getElementById('currentImageContainer').classList.add('hidden');
                    document.getElementById('changeImageButtonContainer').classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Real-time validation saat user berinteraksi dengan form
        document.getElementById('gambar').addEventListener('change', function() {
            // Clear previous errors when user selects new file
            document.getElementById('error-gambar').textContent = '';
            document.getElementById('error-gambar').style.color = '#ef4444';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Responsive CSS styles -->
    <style>
        .bg-gray-800 {
            background-color: #1f2937;
        }

        .text-white {
            color: #fff;
        }

        .text-left {
            text-align: left;
        }

        .p-3 {
            padding: 0.75rem;
        }

        .md\:p-4 {
            padding: 1rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .w-full {
            width: 100%;
        }

        .border-b {
            border-bottom-width: 1px;
        }

        .border-gray-200 {
            border-color: #e5e7eb;
        }

        .bg-gray-50 {
            background-color: #f9fafb;
        }

        .w-1\/4 {
            width: 25%;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-gray-700 {
            color: #374151;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }

        .focus\:ring-1:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }

        .focus\:ring-gray-300:focus {
            --tw-ring-color: #d1d5db;
        }

        .focus\:border-transparent:focus {
            border-color: transparent;
        }

        .text-red-500 {
            color: #ef4444;
        }

        .text-xs {
            font-size: 0.75rem;
        }

        .md\:text-sm {
            font-size: 0.875rem;
        }

        .mt-1 {
            margin-top: 0.25rem;
        }

        .border-2 {
            border-width: 2px;
        }

        .border-dashed {
            border-style: dashed;
        }

        .border-gray-300 {
            border-color: #d1d5db;
        }

        .hidden {
            display: none;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .max-h-32 {
            max-height: 8rem;
        }

        .md\:max-h-40 {
            max-height: 10rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .rounded {
            border-radius: 0.25rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .space-y-2> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
        }

        .text-gray-400 {
            color: #9ca3af;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .bg-gray-100 {
            background-color: #f3f4f6;
        }

        .hover\:bg-gray-200:hover {
            background-color: #e5e7eb;
        }

        .text-gray-800 {
            color: #1f2937;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .md\:px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .transition {
            transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .duration-150 {
            transition-duration: 150ms;
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover\:text-red-700:hover {
            color: #b91c1c;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .flex-col {
            flex-direction: column;
        }

        .sm\:flex-row {
            flex-direction: row;
        }

        .justify-between {
            justify-content: space-between;
        }

        .pt-4 {
            padding-top: 1rem;
        }

        .bg-gray-500 {
            background-color: #6b7280;
        }

        .hover\:bg-gray-600:hover {
            background-color: #4b5563;
        }

        .focus\:ring-0:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .duration-200 {
            transition-duration: 200ms;
        }

        .inline {
            display: inline;
        }

        .mr-1 {
            margin-right: 0.25rem;
        }

        .bg-blue-600 {
            background-color: #2563eb;
        }

        .hover\:bg-blue-700:hover {
            background-color: #1d4ed8;
        }

        .focus\:ring-offset-2:focus {
            --tw-ring-offset-width: 2px;
        }

        .bg-white {
            background-color: #ffffff;
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .pb-2 {
            padding-bottom: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .justify-content-center {
            justify-content: center;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .md\:text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .sm\:gap-0 {
            gap: 0;
        }

        .w-full {
            width: 100%;
        }

        .sm\:w-auto {
            width: auto;
        }

        .text-center {
            text-align: center;
        }

        .h-4 {
            height: 1rem;
        }

        .w-4 {
            width: 1rem;
        }

        .md\:h-5 {
            height: 1.25rem;
        }

        .md\:w-5 {
            width: 1.25rem;
        }

        .h-10 {
            height: 2.5rem;
        }

        .w-10 {
            width: 2.5rem;
        }

        .md\:h-12 {
            height: 3rem;
        }

        .md\:w-12 {
            width: 3rem;
        }

        .h-3 {
            height: 0.75rem;
        }

        .w-3 {
            width: 0.75rem;
        }

        .md\:h-4 {
            height: 1rem;
        }

        .md\:w-4 {
            width: 1rem;
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .overflow-x-auto {
            overflow-x: auto;
        }
    </style>
@endsection
