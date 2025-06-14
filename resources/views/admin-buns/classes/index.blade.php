@extends('layouts.admin')

@section('content')
    <div class="pt-2">
        <div class="flex justify-center">
            <h2 class="text-4xl font-bold mb-6 text-gray-800">Manage Class</h2>
        </div>

        {{-- @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Action Bar - Button Add & Search -->
        <div class="action-bar mb-4">
            <div class="action-left">
                <button class="btn-add-class" onclick="openModal('createModal')">
                    <div class="btn-class-content">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Class</span>
                    </div>
                    <div class="btn-class-shine"></div>
                </button>
            </div>

            <div class="action-right">
                <form method="GET" action="{{ route('admin-buns.classes.index') }}" class="search-class-form">
                    <div class="search-class-container">
                        <div class="search-class-input-wrapper">
                            <i class="fas fa-search search-class-icon"></i>
                            <input type="text" name="search" class="search-class-input" value="{{ request('search') }}"
                                placeholder="Search classes..." autocomplete="off" />
                            @if (request('search'))
                                <button type="button" class="clear-class-search" onclick="clearClassSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                        <button type="submit" class="search-class-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow mt-1">
        <table class="min-w-full text-sm">
            <thead class="text-white text-left" style="background: #343a40">
                <tr>
                    <th class="py-3 px-3 border-b text-center w-[5%]">#</th>
                    <th class="py-3 px-3 border-b text-center w-[15%]">Class Image</th>
                    <th class="py-3 px-3 border-b text-center w-[20%]">Class Name</th>
                    <th class="py-3 px-3 border-b text-center w-[15%]">Price</th>
                    <th class="py-3 px-3 border-b text-center w-[10%]">Status</th>
                    <th class="py-3 px-3 border-b text-center w-[10%]">Detail</th>
                    <th class="py-3 px-3 border-b text-center w-[15%]">Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($langganans->count() > 0)
                    @foreach ($langganans as $langganan)
                        <tr class="border-t">
                            <td class="py-3 px-4 text-center bg-white hover:bg-gray-50 border-r border-gray-200">
                                {{ $loop->iteration }}</td>
                            <td class="py-3 px-4 bg-white hover:bg-gray-50 border-r border-gray-200">
                                <div
                                    class="w-20 h-20 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center mx-auto">
                                    @if ($langganan->gambar_subs)
                                        <img src="{{ asset('storage/langganan_images/' . $langganan->gambar_subs) }}"
                                            alt="Class Image {{ $langganan->pilihan_subs }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="flex flex-col items-center justify-center text-gray-400 text-center p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-1 text-xs">No Image</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 bg-white hover:bg-gray-50 border-r border-gray-200">
                                {{ $langganan->pilihan_subs }}</td>
                            <td class="py-3 px-4 bg-white hover:bg-gray-50 border-r border-gray-200">Rp.
                                {{ number_format($langganan->harga_subs, 0, ',', '.') }}</td>
                            <td
                                class="py-3 px-4 bg-white hover:bg-gray-50 border-r border-gray-200 text-center align-middle">
                                <span class="badge-status {{ $langganan->status ?? 'active' }}">
                                    {{ ucfirst($langganan->status ?? 'active') }}
                                </span>
                            </td>
                            <td
                                class="py-3 px-4 bg-white hover:bg-gray-50 border-r border-gray-200 text-center align-middle">
                                <button onclick="openModalDetail('detailModal_{{ $langganan->id_langganan }}')"
                                    class="px-4 py-2 bg-sky-500 text-white rounded hover:bg-sky-600 transition-colors">
                                    View
                                </button>
                            </td>
                            <td class="py-3 px-4 bg-white hover:bg-gray-50 text-center align-middle">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin-buns.classes.edit', $langganan->id_langganan) }}"
                                        class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin-buns.classes.destroy', $langganan->id_langganan) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="showDeleteConfirmation(this)"
                                            class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <form
                                        action="{{ route('admin-buns.classes.toggle-status', $langganan->id_langganan) }}"
                                        method="POST" class="toggle-status-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="px-3 py-2 btn-action rounded text-white toggle-btn {{ $langganan->status === 'deactive' ? 'show-btn' : 'hide-btn' }}">
                                            @if ($langganan->status === 'deactive')
                                                <i class="fas fa-eye"></i>
                                            @else
                                                <i class="fas fa-eye-slash"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="py-12">
                            <div id="emptyState" class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No classes found</h3>
                                <p class="mt-1 text-gray-500">Try customizing your search or filters to find what you're
                                    looking for.</p>
                                <button onclick="resetSearch()"
                                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-950 focus:outline-none">
                                    Reset
                                </button>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($langganans->count() > 0)
        <div class="mt-4">
            {{ $langganans->links() }}
        </div>
    @endif
    </div>

    <!-- Modal Tambah -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white w-full max-w-3xl p-6 rounded-lg shadow-xl relative my-8">
            <!-- Modal Header -->
            <div class="border-b border-gray-200 pb-4 mb-4">
                <h3 class="text-2xl font-semibold text-gray-800 flex justify-center">Add Class</h3>
            </div>

            <div>
                <form action="{{ route('admin-buns.classes.store') }}" method="POST" id="classForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4 max-h-[60vh] overflow-y-auto px-2">
                        <!-- Nama Kelas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class Name</label>
                            <input type="text" name="pilihan_subs" placeholder="Masukkan Nama Kelas"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">
                            <span class="text-red-500 text-sm error-msg" id="error-pilihan_subs">
                                @if ($errors->has('pilihan_subs'))
                                    {{ $errors->first('pilihan_subs') }}
                                @endif
                            </span>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input type="number" step="0.01" name="harga_subs" placeholder="Masukkan Harga"
                                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent">
                            <span class="text-red-500 text-sm error-msg" id="error-harga_subs">
                                @if ($errors->has('harga_subs'))
                                    {{ $errors->first('harga_subs') }}
                                @endif
                            </span>
                        </div>

                        <!-- Penjelasan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Explanation</label>
                            <textarea name="penjelasan_subs" placeholder="Masukkan Penjelasan Kelas"
                                class="w-full h-32 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent"></textarea>
                            <span class="text-red-500 text-sm error-msg" id="error-penjelasan_subs">
                                @if ($errors->has('penjelasan_subs'))
                                    {{ $errors->first('penjelasan_subs') }}
                                @endif
                            </span>
                        </div>

                        <!-- Gambar Kelas -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Class Image</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center">
                                <div id="uploadArea" class="flex flex-col items-center justify-center space-y-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" id="uploadIcon">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <label for="gambar_subs"
                                        class="cursor-pointer mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 py-2 px-4 rounded-md text-sm font-medium transition duration-150 ease-in-out"
                                        id="uploadButton">
                                        Select Image
                                        <input type="file" id="gambar_subs" name="gambar_subs" class="hidden"
                                            accept="image/*">
                                    </label>
                                </div>

                                <div id="imagePreviewContainer" class="hidden mt-2">
                                    <img id="imagePreview" class="max-h-40 mx-auto rounded" alt="Preview">
                                </div>

                                <div id="fileInfoArea" class="hidden">
                                    <p id="file-name" class="text-sm text-gray-700 mt-2"></p> <br>
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
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 10MB.</p>
                            <span class="text-red-500 text-sm error-msg block mt-1" id="error-gambar_subs">
                                @if ($errors->has('gambar_subs'))
                                    {{ $errors->first('gambar_subs') }}
                                @endif
                            </span>
                        </div>

                        <!-- Benefit Section -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Benefit</label>
                            <div id="benefitList" class="overflow-y-auto rounded-md p-2">
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="text" name="benefit_subs[]" placeholder="Masukkan Benefit"
                                        class="flex-1 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 focus:border-transparent benefit-input">
                                    <button type="button" onclick="removeBenefit(this)"
                                        class="text-gray-500 hover:text-red-500 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <span class="text-red-500 text-sm error-msg block mt-1" id="error-benefit_subs">
                                @if ($errors->has('benefit_subs'))
                                    {{ $errors->first('benefit_subs') }}
                                @endif
                            </span>
                            <button type="button" onclick="addBenefit()"
                                class="mt-2 flex items-center text-blue-600 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Benefit
                            </button>
                        </div>
                    </div>

                    <!-- Modal Footer - Sticky di bagian bawah -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeModal('createModal')"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                            Close
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    @foreach ($langganans as $langganan)
        <div id="detailModal_{{ $langganan->id_langganan }}"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white w-full max-w-4xl p-6 rounded-lg shadow-2xl relative">
                <div class="border-b border-gray-200 pb-4 mb-4 flex justify-between items-center">
                    <h3 class="text-2xl font-semibold text-gray-800">Class Details</h3>
                    <button onclick="closeModal('detailModal_{{ $langganan->id_langganan }}')"
                        class="text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-h-[70vh] overflow-y-auto px-2">
                    <div class="col-span-2">
                        <table class="w-full">
                            <tr>
                                <td class="w-1/2 pr-4 align-top">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Class Image</label>
                                    <div
                                        class="w-84 h-64 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center mx-auto">
                                        @if ($langganan->gambar_subs)
                                            <img src="{{ asset('storage/langganan_images/' . $langganan->gambar_subs) }}"
                                                alt="Class Image {{ $langganan->pilihan_subs }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="text-gray-400 text-center p-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="mt-2 text-sm">No Image</p>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="w-1/2 pl-4 align-top">
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                class="border-b border-gray-200 justify-between items-center block text-sm font-medium text-gray-700 mb-2">Class
                                                Name</label>
                                            <p class="p-3 bg-white rounded-md text-lg font-semibold text-gray-900">
                                                {{ $langganan->pilihan_subs }}</p>
                                        </div>
                                        <div>
                                            <label
                                                class="border-b border-gray-200 justify-between items-center block text-sm font-medium text-gray-700 mb-2">Price</label>
                                            <p class="p-3 bg-white rounded-md text-lg font-semibold text-gray-900">Rp.
                                                {{ number_format($langganan->harga_subs, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <label
                                                class="border-b border-gray-200 justify-between items-center block text-sm font-medium text-gray-700 mb-2">Status</label><br>
                                            <span class="badge-status {{ $langganan->status ?? 'active' }}">
                                                {{ ucfirst($langganan->status ?? 'active') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Explanation -->
                    <div class="col-span-2">
                        <label
                            class="border-b border-gray-200 pb-4 justify-between items-center block text-sm font-medium text-gray-700 mb-2">Explanation</label>
                        <p class="p-3 bg-white rounded-md text-gray-700 text-justify">{{ $langganan->penjelasan_subs }}
                        </p>
                    </div>

                    <!-- Benefit -->
                    <div class="col-span-2">
                        <label
                            class="border-b border-gray-200 pb-4 justify-between items-center block text-sm font-medium text-gray-700 mb-2">Benefit</label>
                        <div class="p-3 bg-white rounded-md text-gray-700">
                            <ul class="list-disc pl-5 space-y-2">
                                @foreach (json_decode($langganan->benefit_subs, true) as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button onclick="closeModal('detailModal_{{ $langganan->id_langganan }}')"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Close
                    </button>
                    <a href="{{ route('admin-buns.classes.edit', $langganan->id_langganan) }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('admin-buns.classes.destroy', $langganan->id_langganan) }}" method="POST"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showDeleteConfirmation(this)"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        /* Action Bar Styles */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .action-left {
            display: flex;
            align-items: center;
            flex: 0 0 auto;
        }

        .action-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
            flex: 0 0 auto;
            max-width: 400px;
            margin-left: auto;
        }

        /* Add Class Button */
        .btn-add-class {
            position: relative;
            background: #007bff;
            border: none;
            border-radius: 8px;
            padding: 0;
            cursor: pointer;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(38, 38, 38, 0.3);
            min-width: 150px;
            height: 38px;
        }

        .btn-add-class:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(38, 38, 38, 0.4);
            background: #0056b3;
        }

        .btn-add-class:active {
            transform: translateY(-1px);
            transition: transform 0.1s ease;
        }

        .btn-class-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            height: 100%;
        }

        .btn-class-content i {
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .btn-add-class:hover .btn-class-content i {
            transform: rotate(90deg);
        }

        .btn-class-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
            z-index: 1;
        }

        .btn-add-class:hover .btn-class-shine {
            left: 100%;
        }

        /* Class Search Form */
        .search-class-form {
            width: 350px;
            max-width: 350px;
        }

        .search-class-container {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .search-class-input-wrapper {
            position: relative;
            flex: 1;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 36px;
        }

        .search-class-input-wrapper:focus-within {
            border-color: black;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
            transform: none;
        }

        .search-class-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 0.875rem;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .search-class-input-wrapper:focus-within .search-class-icon {
            color: #343a40;
            transform: translateY(-50%);
        }

        .search-class-input {
            width: 100%;
            border: none;
            outline: none;
            padding: 8px 12px 8px 32px;
            font-size: 0.8rem;
            background: transparent;
            color: #343a40;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .search-class-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .search-class-input:focus::placeholder {
            color: #d1d5db;
        }

        .clear-class-search {
            position: absolute;
            right: 36px;
            top: 50%;
            transform: translateY(-50%);
            background: #f3f4f6;
            border: none;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6b7280;
            font-size: 0.6rem;
        }

        .clear-class-search:hover {
            background: #e5e7eb;
            color: #374151;
            transform: translateY(-50%) scale(1.1);
        }

        .search-class-btn {
            background: #343a40;
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
        }

        .search-class-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.4);
            background: #0056b3;
        }

        .search-class-btn:active {
            transform: translateY(0);
        }

        .search-class-btn i {
            font-size: 0.75rem;
            transition: transform 0.3s ease;
        }

        .search-class-btn:hover i {
            transform: scale(1.05);
        }

        /* Badge status styling */
        .badge-status {
            padding: 6px 12px;
            font-size: 0.9rem;
            color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 400;
        }

        .badge-status.active {
            background-color: #28a745;
        }

        .badge-status.deactive {
            background-color: #dc3545;
        }

        /* Toggle button styling */
        .toggle-btn.hide-btn {
            background-color: #ffc107;
        }

        .toggle-btn.show-btn {
            background-color: #17a2b8;
        }

        .toggle-btn.hide-btn:hover {
            background-color: #e0a800;
        }

        .toggle-btn.show-btn:hover {
            background-color: #138496;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        /* Detail Modal Styles */
        [id^="detailModal_"] .bg-white {
            background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
        }

        [id^="detailModal_"] .shadow-2xl {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        [id^="detailModal_"] .grid-cols-2 {
            grid-template-columns: 1fr;
        }

        [id^="detailModal_"] .bg-gray-50 {
            background-color: #f8fafc;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        [id^="detailModal_"] .bg-gray-50:hover {
            background-color: #eef2f6;
        }

        [id^="detailModal_"] .rounded-lg {
            border-radius: 12px;
        }

        [id^="detailModal_"] .transition-all {
            transition: all 0.3s ease-in-out;
        }

        [id^="detailModal_"] .hover:scale-100 {
            transform: scale(1);
        }

        [id^="detailModal_"] .transform,
        [id^="detailModal_"] .scale-95,
        [id^="detailModal_"] .hover:scale-100,
        [id^="detailModal_"] .transition-all,
        [id^="detailModal_"] .duration-300,
        [id^="detailModal_"] .ease-in-out {
            all: unset;
        }

        [id^="detailModal_"] label {
            color: #4a5568;
        }

        [id^="detailModal_"] .text-justify {
            text-align: justify;
        }

        @media (min-width: 768px) {
            [id^="detailModal_"] .grid-cols-2 {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            [id^="detailModal_"] {
                margin: 1rem;
            }

            [id^="detailModal_"] .max-w-4xl {
                max-width: 100%;
            }

            [id^="detailModal_"] .w-64 {
                width: 100%;
            }

            [id^="detailModal_"] .h-64 {
                height: 200px;
            }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .action-bar {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .action-left,
            .action-right {
                width: 100%;
                max-width: none;
                margin-left: 0;
                justify-content: center;
            }

            .search-class-form {
                width: 100%;
                max-width: 100%;
            }

            .btn-add-class {
                width: 100%;
                min-width: auto;
            }
        }

        @media (max-width: 480px) {
            .search-class-form {
                width: 100%;
            }

            .search-class-container {
                gap: 6px;
            }

            .search-class-input {
                padding: 8px 10px 8px 30px;
                font-size: 0.75rem;
            }

            .search-class-input::placeholder {
                font-size: 0.75rem;
            }

            .clear-class-search {
                right: 32px;
                width: 16px;
                height: 16px;
                font-size: 0.5rem;
            }

            .search-class-btn {
                padding: 8px 10px;
                min-width: 32px;
                height: 32px;
            }

            .search-class-btn i {
                font-size: 0.7rem;
            }
        }
    </style>

    <script>
        // Reset filters function
        function resetSearch() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.value = '';
            }
            window.location.href = '{{ route('admin-buns.classes.index') }}';
        }

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

            if (benefitItems.length > 1) {
                button.parentNode.remove();
            }
        }

        // Form validation with AJAX support dan SweetAlert2 popup
        document.getElementById('classForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Reset error messages
            document.querySelectorAll('.error-msg').forEach(function(el) {
                el.textContent = '';
            });

            // Create form data for submission
            const formData = new FormData(this);
            const modalId = 'createModal';
            const form = this;

            // Collect benefit values - fixed logic
            const benefitInputs = document.querySelectorAll('.benefit-input');
            let benefits = [];

            // Clear existing benefit_subs entries in formData
            formData.delete('benefit_subs[]');

            benefitInputs.forEach((input, index) => {
                if (input.value.trim() !== '') {
                    benefits.push(input.value.trim());
                    formData.append('benefit_subs[]', input.value.trim());
                }
            });

            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerText = 'Saving...';
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
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => {
                            if (data.errors) {
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    submitButton.innerText = 'Save';
                                }

                                // Enhanced error handling
                                Object.keys(data.errors).forEach(field => {
                                    const errorElement = document.getElementById('error-' +
                                        field);
                                    if (errorElement) {
                                        errorElement.textContent = data.errors[field][0];

                                        // Special handling for benefit_subs error display
                                        if (field === 'benefit_subs') {
                                            errorElement.style.display = 'block';
                                        }
                                    }
                                });

                                // Show validation errors in console for debugging
                                console.log('Validation errors:', data.errors);
                            } else if (data.success) {
                                closeModal(modalId);
                                Swal.fire({
                                    title: 'Successfully!',
                                    text: 'Class successfully added.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                closeModal(modalId);
                                Swal.fire({
                                    title: 'Successfully!',
                                    text: 'Class successfully added.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        });
                    } else {
                        closeModal(modalId);
                        Swal.fire({
                            title: 'Successfully!',
                            text: 'Class successfully added.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                        return null;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerText = 'Save';
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                });
        });

        function validateForm() {
            return true;
        }

        // Modal functions
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Reset the form
            document.getElementById('classForm').reset();

            // Menghapus semua pesan error
            document.querySelectorAll('.error-msg').forEach(function(el) {
                el.textContent = '';
                el.style.display = '';
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

            removeImage();
        }

        function openModalDetail(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Form Delete dengan SweetAlert2
        let currentForm = null;

        function showDeleteConfirmation(button) {
            currentForm = button.closest('form');

            Swal.fire({
                title: 'Delete Class Data?',
                text: "Are you sure you want to delete this class data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form delete
                    if (currentForm) {
                        // Disable button to prevent double submission
                        button.disabled = true;
                        button.innerHTML = 'Deleting...';

                        // Submit form dan handle response
                        fetch(currentForm.action, {
                                method: 'POST',
                                body: new FormData(currentForm),
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                credentials: 'same-origin'
                            })
                            .then(response => {
                                // Pop-up berhasil menghapus kelas
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Class data has been successfully deleted.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                // Pop-up berhasil menghapus kelas (fallback untuk error)
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Class data has been successfully deleted.',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            });
                    }
                }
            });
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Preview gambar dan tampilkan nama file
        document.getElementById('gambar_subs').addEventListener('change', function(e) {
            const fileInput = e.target;
            const fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';

            document.getElementById('file-name').textContent = fileName;

            document.getElementById('uploadArea').classList.add('hidden');
            document.getElementById('fileInfoArea').classList.remove('hidden');

            // Clear any existing error message for image
            document.getElementById('error-gambar_subs').textContent = '';

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

        function removeImage() {
            document.getElementById('gambar_subs').value = '';
            document.getElementById('file-name').textContent = 'No file chosen';
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('imagePreview').src = '';

            document.getElementById('uploadArea').classList.remove('hidden');
            document.getElementById('fileInfoArea').classList.add('hidden');
        }

        function clearClassSearch() {
            document.querySelector('.search-class-input').value = '';
            document.querySelector('.search-class-form').submit();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
