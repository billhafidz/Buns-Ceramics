<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROFILE</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🧑‍🎨</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .bg-custom {
            background-color: #262626;
        }

        .profile-image-container:hover .profile-image-overlay {
            opacity: 1;
        }

        .profile-image-overlay {
            transition: opacity 0.3s ease;
        }

        .input-focus:focus {
            border-color: #4a5568;
            box-shadow: 0 0 0 3px rgba(74, 85, 104, 0.1);
        }
    </style>
</head>

<body class="bg-custom min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-black px-6 py-6">
                <h1 class="text-2xl font-bold text-white text-center">Edit Profile</h1>
            </div>

            <!-- Success message -->
            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mx-6 mt-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 text-green-500">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- <!-- Error messages -->
            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mx-6 mt-4 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-red-500">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-700">Terdapat {{ $errors->count() }} kesalahan dalam pengisian form:</h3>
                        <ul class="mt-2 text-sm text-red-600 list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif --}}

            <!-- Form -->
            <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="p-8 space-y-8">
                @csrf
                <input type="hidden" name="delete_image" value="0">

                <div class="flex flex-col md:flex-row gap-10">
                    <!-- Profile picture section -->
                    <div class="w-full md:w-1/3 flex flex-col items-center">
                        <div class="relative mb-6 profile-image-container">
                            <img src="{{ isset($member) && $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}"
                                alt="Foto Profil"
                                class="profile-image w-44 h-44 object-cover rounded-full border-4 border-gray-200 shadow-xl">

                          @if (isset($member) && $member->foto_profil)
                                <div
                                    class="profile-image-overlay absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0">
                                    <button type="button"
                                        class="delete-image-btn bg-red-500 hover:bg-red-600 text-white rounded-full p-3 shadow-lg transition-colors">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <label
                            class="relative cursor-pointer bg-black hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                            <span class="flex items-center gap-2">
                                <i class="fas fa-camera"></i>
                                Ubah Foto
                            </span>
                            <input type="file" name="foto_profil" accept="image/*" class="hidden">
                        </label>
                        <p class="mt-3 text-sm text-gray-500 text-center">Format: JPG, PNG (Max 10MB)</p>
                    </div>

                    <!-- Form fields -->
                    <div class="w-full md:w-2/3 space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="nama_member" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="nama_member" name="nama_member"
                                    value="{{ old('nama_member', $member->nama_member ?? '') }}"
                                    class="input-focus block w-full rounded-xl border-2 border-gray-200 shadow-sm px-4 py-3 transition duration-200 ease-in-out bg-gray-50 focus:bg-white">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </div>
                            @error('nama_member')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="alamat_member" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="alamat_member" name="alamat_member"
                                    value="{{ old('alamat_member', $member->alamat_member ?? '') }}"
                                    class="input-focus block w-full rounded-xl border-2 border-gray-200 shadow-sm px-4 py-3 transition duration-200 ease-in-out bg-gray-50 focus:bg-white">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                </div>
                            </div>
                            @error('alamat_member')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="no_telp" name="no_telp"
                                    value="{{ old('no_telp', $member->no_telp ?? '') }}"
                                    class="input-focus block w-full rounded-xl border-2 border-gray-200 shadow-sm px-4 py-3 transition duration-200 ease-in-out bg-gray-50 focus:bg-white">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                            </div>
                            @error('no_telp')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subscription Days -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sisa Hari Berlangganan
                            </label>
                            <div class="relative">
                                <input type="text" value="{{ $member->day ?? 'Belum berlangganan' }}"
                                    class="block w-full rounded-xl bg-gray-100 border-2 border-gray-200 shadow-sm px-4 py-3 cursor-not-allowed text-gray-600"
                                    readonly>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-day text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-between pt-6 border-t-2 border-gray-100">
                    <a href="{{ url('/') }}"
                        class="flex items-center justify-center bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-8 rounded-xl shadow-lg border-2 border-gray-200 transition-all duration-300 hover:shadow-xl">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                    <button type="submit"
                        class="flex items-center justify-center bg-black hover:bg-gray-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview image before upload
            const profileImageInput = document.querySelector('input[name="foto_profil"]');
            const profileImage = document.querySelector('.profile-image');

            if (profileImageInput) {
                profileImageInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            profileImage.src = event.target.result;
                            // Show delete button if image is uploaded
                            const overlay = document.querySelector('.profile-image-overlay');
                            if (!overlay) {
                                const container = document.querySelector('.profile-image-container');
                                const newOverlay = document.createElement('div');
                                newOverlay.className =
                                    'profile-image-overlay absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0';
                                newOverlay.innerHTML = `
                                    <button type="button" class="delete-image-btn bg-red-500 hover:bg-red-600 text-white rounded-full p-3 shadow-lg transition-colors">
                                        <i class="fas fa-trash-alt text-lg"></i>
                                    </button>
                                `;
                                container.appendChild(newOverlay);
                                setupDeleteButton(newOverlay.querySelector('.delete-image-btn'));
                            }
                        };
                        reader.readAsDataURL(e.target.files[0]);
                    }
                });
            }

            function setupDeleteButton(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('input[name="delete_image"]').value = '1';
                    profileImage.src = "{{ asset('images/user-icon.png') }}";
                    profileImageInput.value = '';

                    const overlay = document.querySelector('.profile-image-overlay');
                    if (overlay) {
                        overlay.remove();
                    }
                });
            }

            const deleteImageBtn = document.querySelector('.delete-image-btn');
            if (deleteImageBtn) {
                setupDeleteButton(deleteImageBtn);
            }
        });
    </script>
</body>

</html>
