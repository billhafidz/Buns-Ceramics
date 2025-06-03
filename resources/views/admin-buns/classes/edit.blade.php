@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="pb-2 mb-4 flex justify-center">
            <h2 class="text-3xl font-bold text-gray-800">Edit Class</h2>
        </div>

        <form action="{{ route('admin-buns.classes.update', $langganan->id_langganan) }}" method="POST" id="editClassForm"
            enctype="multipart/form-data" novalidate>
            @csrf

            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-1">
                <!-- Table Layout -->
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th colspan="2" class="text-left p-4 font-semibold">Class Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Nama Kelas -->
                        <tr class="border-b border-gray-200">
                            <td class="p-4 bg-gray-50 w-1/4 font-medium">Class Name</td>
                            <td class="p-4">
                                <input type="text" name="pilihan_subs" value="{{ $langganan->pilihan_subs }}" required
                                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">
                                <div class="text-red-500 text-sm mt-1 error-msg" id="error-pilihan_subs"></div>
                            </td>
                        </tr>

                        <!-- Harga -->
                        <tr class="border-b border-gray-200">
                            <td class="p-4 bg-gray-50 font-medium">Price</td>
                            <td class="p-4">
                                <input type="number" step="0.01" name="harga_subs" value="{{ $langganan->harga_subs }}"
                                    required
                                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">
                                <div class="text-red-500 text-sm mt-1 error-msg" id="error-harga_subs"></div>
                            </td>
                        </tr>

                        <!-- Penjelasan -->
                        <tr class="border-b border-gray-200">
                            <td class="p-4 bg-gray-50 font-medium">Explanation</td>
                            <td class="p-4 max-h-[100px]">
                                <textarea name="penjelasan_subs" required
                                    class="w-full h-32 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">{{ $langganan->penjelasan_subs }}</textarea>
                                <div class="text-red-500 text-sm mt-1 error-msg" id="error-penjelasan_subs"></div>
                            </td>
                        </tr>
                        <!-- Gambar Kelas -->
                        <tr class="border-b border-gray-200">
                            <td class="p-4 bg-gray-50 font-medium">Class Image</td>
                            <td class="p-4">
                                <div class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center">
                                    <!-- Current Image Display -->
                                    <div id="currentImageContainer"
                                        class="{{ $langganan->gambar_subs ? '' : 'hidden' }} mb-3">
                                        <img id="currentImage"
                                            src="{{ asset('storage/langganan_images/' . $langganan->gambar_subs) }}"
                                            class="max-h-40 mx-auto rounded" alt="">
                                        <p id="current-file-name" class="text-sm text-gray-700 mt-2">
                                            {{ $langganan->gambar_subs }}</p>
                                    </div>
                                    <!-- Upload Area -->
                                    <div id="uploadArea"
                                        class="{{ $langganan->gambar_subs ? 'hidden' : 'flex flex-col items-center justify-center space-y-2' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg> <br>
                                        <label for="gambar_subs"
                                            class="cursor-pointer mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                                            id="uploadButton">
                                            Select Image
                                            <input type="file" id="gambar_subs" name="gambar_subs" class="hidden"
                                                accept="image/*">
                                        </label>
                                    </div>

                                    <!-- New Image Preview (Initially Hidden) -->
                                    <div id="imagePreviewContainer" class="hidden mt-2">
                                        <img id="imagePreview" class="max-h-40 mx-auto rounded" alt="Preview">
                                        <p id="new-file-name" class="text-sm text-gray-700 mt-2"></p>
                                        <button type="button" onclick="removeImage()"
                                            class="mt-1 text-red-500 hover:text-red-700 text-sm flex items-center justify-center mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete Image
                                        </button>
                                    </div>

                                    <!-- Hapus Gambar Button -->
                                    <div id="changeImageButtonContainer"
                                        class="{{ $langganan->gambar_subs ? '' : 'hidden' }} mt-3">
                                        <button type="button" onclick="removeCurrentImage()"
                                            class="mt-1 text-red-500 hover:text-red-700 text-sm flex items-center justify-center mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete Image
                                        </button>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                                <div class="text-red-500 text-sm mt-1 error-msg" id="error-gambar_subs"></div>
                            </td>
                        </tr>

                        <!-- Benefit -->
                        <tr class="border-b border-gray-200">
                            <td class="p-4 bg-gray-50 font-medium align-top">Benefit</td>
                            <td class="p-4">
                                <div id="benefitListEdit" class="max-h-[150px] overflow-y-auto space-y-2 rounded-md p-2">
                                    @foreach (json_decode($langganan->benefit_subs, true) as $benefit)
                                        <div class="flex items-center gap-2 mb-2">
                                            <input type="text" name="benefit_subs[]" value="{{ $benefit }}"
                                                required
                                                class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent benefit-input">
                                            <button type="button" onclick="removeBenefitEdit(this)"
                                                class="text-gray-500 hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" onclick="addBenefitEdit()"
                                    class="mt-2 flex items-center text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Benefit
                                </button>
                                {{-- <div class="text-red-500 text-sm mt-1 error-msg" id="error-benefit_subs"></div> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Hidden input untuk menandai gambar yang dihapus -->
            <input type="hidden" name="remove_image" id="remove_image" value="0">

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('admin-buns.classes.index') }}"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-0 transition-transform duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-0 focus:ring-offset-2 transition-transform duration-200">
                    Update
                </button>
            </div>
        </form>
    </div>

    <script>
        // Benefit Management for Edit Form
        function addBenefitEdit() {
            const container = document.getElementById('benefitListEdit');
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'gap-2', 'mb-2');
            div.innerHTML = `
        <input type="text" name="benefit_subs[]" placeholder="Masukkan Benefit" required
               class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent benefit-input">
        <button type="button" onclick="removeBenefitEdit(this)" class="text-gray-500 hover:text-red-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
            container.appendChild(div);
        }

        function removeBenefitEdit(button) {
            const container = document.getElementById('benefitListEdit');
            const benefitItems = container.querySelectorAll('div.flex.items-center');

            // Don't allow removal if it's the last item
            if (benefitItems.length > 1) {
                button.parentNode.remove();
            }

            // Ensure at least one benefit is required
            const firstInput = container.querySelector('.benefit-input');
            if (firstInput) {
                firstInput.required = true;
            }
        }

        // Form validation dengan AJAX support
        document.getElementById('editClassForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset error messages
            document.querySelectorAll('.error-msg').forEach(function(el) {
                el.textContent = '';
            });

            // Create form data for submission
            const formData = new FormData(this);
            const form = this;

            // Process benefit inputs
            const benefitInputs = document.querySelectorAll('.benefit-input');
            let hasEmptyBenefit = false;

            benefitInputs.forEach(input => {
                if (input.value.trim() === '') {
                    hasEmptyBenefit = true;
                }
            });

            // if (hasEmptyBenefit) {
            //     document.getElementById('error-benefit_subs').textContent = 'Kolom benefit harus diisi.';
            //     return;
            // }

            // Disable submit button to prevent double submission
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerText = 'Renew...';
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
                                    submitButton.innerText = 'Perbarui';
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
                                // Success - redirect to index page
                                window.location.href = "{{ route('admin-buns.classes.index') }}";
                            } else {
                                // Fallback for other JSON responses - assume success
                                window.location.href = "{{ route('admin-buns.classes.index') }}";
                            }
                        });
                    } else {
                        // Non-JSON response (e.g. HTML redirect) - assume success
                        window.location.href = "{{ route('admin-buns.classes.index') }}";
                        return null;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Re-enable submit button on error
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerText = 'Perbarui';
                    }
                });
        });

        // Image handling functions
        function showUploadArea() {
            // Hide current image and change button
            document.getElementById('currentImageContainer').classList.add('hidden');
            document.getElementById('changeImageButtonContainer').classList.add('hidden');

            // Show upload area
            document.getElementById('uploadArea').classList.remove('hidden');
        }

        // Preview gambar yang baru dipilih
        document.getElementById('gambar_subs').addEventListener('change', function(e) {
            const fileInput = e.target;
            const fileName = fileInput.files[0] ? fileInput.files[0].name : '';

            // Hide current image and upload area
            document.getElementById('currentImageContainer').classList.add('hidden');
            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('changeImageButtonContainer').classList.add('hidden');

            // Reset remove_image field as we're adding a new image
            document.getElementById('remove_image').value = '0';

            // Preview gambar baru
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    document.getElementById('new-file-name').textContent = fileName;
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                }

                reader.readAsDataURL(fileInput.files[0]);
            }
        });

        // Fungsi untuk menghapus gambar baru yang dipilih
        function removeImage() {
            // Reset file input
            document.getElementById('gambar_subs').value = '';

            // Hide preview and show upload area
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');
        }

        // Fungsi untuk menghapus gambar yang sudah ada
        function removeCurrentImage() {
            // Hide current image and show upload area
            document.getElementById('currentImageContainer').classList.add('hidden');
            document.getElementById('changeImageButtonContainer').classList.add('hidden');
            document.getElementById('uploadArea').classList.remove('hidden');

            // Set hidden input to mark image for deletion
            document.getElementById('remove_image').value = '1';
        }
    </script>
@endsection
