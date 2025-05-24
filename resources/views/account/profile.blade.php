<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Profil</h1>
                <a href="{{ url('/') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded">
                    ⬅ Kembali ke Home
                </a>
            </div>

           
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    
                    <div class="relative">
                        <img src="{{ $member->foto_profil ? asset('storage/' . $member->foto_profil) : asset('images/user-icon.png') }}"
                             alt="Foto Profil"
                             class="w-32 h-32 object-cover rounded-full border-4 border-blue-200 shadow">

                        <label class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-2 py-1 rounded cursor-pointer">
                            Ubah
                            <input type="file" name="foto_profil" accept="image/*" class="hidden">
                        </label>
                    </div>

                    <!-- Form Data -->
                    <div class="w-full">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="nama_member" value="{{ old('nama_member', $member->nama_member) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <input type="text" name="alamat_member" value="{{ old('alamat_member', $member->alamat_member) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', $member->no_telp) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Sisa Hari Berlangganan</label>
                            <input type="text" value="{{ $member->day }} hari" class="mt-1 block w-full bg-gray-100 rounded-md border border-gray-300" readonly>
                        </div>
                    </div>
                </div>

                
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
