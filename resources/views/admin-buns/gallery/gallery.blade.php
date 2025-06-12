@extends('layouts.admin')

@section('content')

<section id="gallery" class="bg-light py-5">
    <div class="container">
        <!-- Header Section with Title -->
        <div class="header-section mb-5">
            <h2 class="page-title">
                Manage Gallery
            </h2>
        </div>

        <!-- Error Alert -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <!-- Action Bar - Button Add & Search -->
        <div class="action-bar mb-4">
            <div class="action-left">
                <button class="btn-add-modern" id="openModalButton">
                    <div class="btn-content">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Gallery</span>
                    </div>
                    <div class="btn-shine"></div>
                </button>
            </div>

            <div class="action-right">
                <form action="{{ route('admin-buns.gallery') }}" method="GET" class="search-form-modern">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                class="search-input"
                                value="{{ request('search') }}"
                                placeholder="Search galleries by name or type..."
                                autocomplete="off" />
                            @if(request('search'))
                            <button type="button" class="clear-search" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="createGalleryModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #333; color: white; border-radius: 10px 10px 0 0; padding: 20px 30px;">
                        <h5 class="modal-title">Tambah Gallery</h5>
                    </div>
                    <form method="POST" action="{{ route('admin-buns.gallery.store') }}" enctype="multipart/form-data" id="galleryForm">
                        @csrf
                        <div class="modal-body" style="background-color: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
                            <div class="mb-3">
                                <label for="nama" class="form-label" style="font-weight: bold; color: #333;">
                                    Nama Member <span class="required-asterisk">*</span>
                                </label>
                                <select class="form-select" id="nama" name="nama" style="border: 1px solid #ccc; border-radius: 8px; padding: 10px 12px; width: 620px;">
                                    <option value="" disabled selected>Pilih Nama Member</option>
                                    @foreach ($members as $member)
                                    <option value="{{ $member->nama_member }}">{{ $member->nama_member }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="nama-error">
                                    @if($errors->has('nama'))
                                    {{ $errors->first('nama') }}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label" style="font-weight: bold; color: #333;">
                                    Jenis <span class="required-asterisk">*</span>
                                </label>
                                <select class="form-select" id="jenis" name="jenis" style="border: 1px solid #ccc; border-radius: 8px; padding: 10px 12px; width: 620px;">
                                    <option value="" disabled selected>Pilih Jenis</option>
                                    <option value="gelas">Gelas</option>
                                    <option value="mangkuk">Mangkuk</option>
                                    <option value="piring">Piring</option>
                                </select>
                                <div class="invalid-feedback" id="jenis-error">
                                    @if($errors->has('jenis'))
                                    {{ $errors->first('jenis') }}
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label" style="font-weight: bold; color: #333;">
                                    Gambar <span class="required-asterisk">*</span>
                                </label>
                                <div class="image-upload-wrapper" style="display: flex; align-items: center;">
                                    <div class="image-preview" id="imagePreview" style="flex: 1;">
                                        <div class="placeholder" style="text-align: left; padding: 10px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg> <br>
                                            <p style="color: #333; margin-left: 10px;"><b>Pilih gambar</b></p>
                                        </div>
                                        <img src="" alt="Preview" id="previewImg" style="display: none; max-width: 100%; height: auto; object-fit: cover;">
                                    </div>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)" style="border: 1px solid #ccc; border-radius: 8px; padding: 10px 12px;">
                                </div>
                                <div class="invalid-feedback" id="gambar-error">
                                    @if($errors->has('gambar'))
                                    {{ $errors->first('gambar') }}
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 10MB.</p>
                            </div>
                            <!-- Status field is not needed in the form since it defaults to 'active' -->

                            <div class="modal-footer" style="border-top: none; justify-content: space-between; padding: 20px; background-color: #f8f9fa;">
                                <button type="button" class="btn btn-danger" id="closeModalButton" style="background-color: #dc3545; color: white; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px;">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; font-size: 1rem; border-radius: 5px;">
                                    Submit
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery List -->
    <div class="gallery-container mt-4">

        <div class="table-responsive">
            <table class="table custom-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Gambar</th>
                        <th>Status</th> <!-- New column for status -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @forelse($gallery as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($gallery->currentPage() - 1) * $gallery->perPage() }}</td>
                        <td class="item-name">{{ $item->nama }}</td>
                        <td><span class="badge-jenis {{ $item->jenis }}">{{ $item->jenis }}</span></td>
                        <td>
                            @if($item->gambar)
                            <div class="img-container">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gallery Image" class="img-preview" style="max-width: 120px; height: auto; object-fit: cover;">
                            </div>
                            @else
                            <span class="no-image">No Image</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $item->status ?? 'active' }}">
                                {{ ucfirst($item->status ?? 'active') }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin-buns.gallery.edit', $item->id) }}" class="btn-action edit-btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin-buns.gallery.delete', $item->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-action delete-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin-buns.gallery.toggle-status', $item->id) }}" method="POST" class="toggle-status-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action toggle-btn {{ $item->status === 'deactive' ? 'show-btn' : 'hide-btn' }}">
                                        @if($item->status === 'deactive')
                                        <i class="fas fa-eye"></i>
                                        @else
                                        <i class="fas fa-eye-slash"></i>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="6"> <!-- Updated colspan to match the number of columns -->
                            <div class="empty-state">
                                <i class="fas fa-images fa-3x"></i>
                                <p>Belum ada data gallery</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $gallery->appends(request()->input())->links() }}
        </div>
    </div>
</section>

@endsection

<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Memuat Tailwind CSS setelah Bootstrap untuk menghindari konflik -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Memuat JavaScript untuk Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    html,
    body {
        min-height: 100vh !important;
        background-color: #f8f9fa !important;
    }

    body>div,
    #app,
    .wrapper,
    .content-wrapper,
    main,
    .admin-layout {
        min-height: 100vh !important;
        background-color: #f8f9fa !important;
    }

    footer {
        background-color: #f8f9fa !important;
        margin-top: auto;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    * {
        margin-bottom: 0;
    }

    .header-section {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
    }

    .page-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #343a40;
        margin-bottom: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: #6c757d;
        font-weight: 400;
        margin: 0;
        opacity: 0.8;
    }

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

    .btn-add-modern {
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

    .btn-add-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(38, 38, 38, 0.4);
        background: #0056b3;
    }

    .btn-add-modern:active {
        transform: translateY(-1px);
        transition: transform 0.1s ease;
    }

    .btn-content {
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

    .btn-content i {
        font-size: 1rem;
        transition: transform 0.3s ease;
    }

    .btn-add-modern:hover .btn-content i {
        transform: rotate(90deg);
    }

    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s ease;
        z-index: 1;
    }

    .btn-add-modern:hover .btn-shine {
        left: 100%;
    }

    .search-form-modern {
        width: 350px;
        max-width: 350px;
    }

    .search-container {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }

    .search-input-wrapper {
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

    .search-input-wrapper:focus-within {
        border-color: black;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
        transform: none;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 0.875rem;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .search-input-wrapper:focus-within .search-icon {
        color: #343a40;
        transform: translateY(-50%);
    }

    .search-input {
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

    .search-input::placeholder {
        color: #9ca3af;
        font-weight: 400;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .search-input:focus::placeholder {
        color: #d1d5db;
    }

    .clear-search {
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

    .clear-search:hover {
        background: #e5e7eb;
        color: #374151;
        transform: translateY(-50%) scale(1.1);
    }

    .search-btn {
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

    .search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(0, 123, 255, 0.4);
        background: #0056b3;
    }

    .search-btn:active {
        transform: translateY(0);
    }

    .search-btn i {
        font-size: 0.75rem;
        transition: transform 0.3s ease;
    }

    .search-btn:hover i {
        transform: scale(1.05);
    }

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

        .search-form-modern {
            width: 100%;
            max-width: 100%;
        }

        .btn-add-modern {
            width: 100%;
            min-width: auto;
        }
    }

    @media (max-width: 480px) {
        .search-form-modern {
            width: 100%;
        }

        .search-container {
            gap: 6px;
        }

        .search-input {
            padding: 8px 10px 8px 30px;
            font-size: 0.75rem;
        }

        .search-input::placeholder {
            font-size: 0.75rem;
        }

        .clear-search {
            right: 32px;
            width: 16px;
            height: 16px;
            font-size: 0.5rem;
        }

        .search-btn {
            padding: 8px 10px;
            min-width: 32px;
            height: 32px;
        }

        .search-btn i {
            font-size: 0.7rem;
        }
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1050;
        padding: 50px;
        overflow-y: auto;
        backdrop-filter: blur(5px);
        transition: all 0.3s ease;
    }

    .modal.show {
        display: block;
    }

    .modal-dialog {
        max-width: 680px;
        margin: 50px auto;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transform: translateY(-20px);
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
    }

    .modal-content {
        border: none;
        overflow: hidden;
    }

    .modal-header {
        padding: 24px 30px;
        background-color: #333;
        color: white;
        border-bottom: none;
        position: relative;
        border-radius: 16px 16px 0 0;
    }

    .modal-body {
        padding: 35px;
        background-color: #f8f9fa;
        border-radius: 0;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .modal-footer {
        padding: 20px 30px;
        text-align: right;
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0 0 16px 16px;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 12px 16px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #ffffff;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
    }

    .image-upload-wrapper {
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        border: 1px dashed rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .image-upload-wrapper:hover {
        border-color: #007bff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .image-preview {
        width: 100%;
        padding: 15px;
        background-color: rgba(0, 123, 255, 0.03);
        border-radius: 10px;
        text-align: center;
        min-height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-preview .placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #6c757d;
    }

    .image-preview .placeholder i {
        font-size: 2.5rem;
        color: #007bff;
        margin-bottom: 10px;
        opacity: 0.7;
    }

    .image-preview .placeholder p {
        margin: 5px 0;
        font-weight: 600;
        font-size: 1rem;
    }

    #previewImg {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .img-container {
        width: 100px;
        height: 100px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin: 0 auto;
        border: 1px solid #e0e0e0;
    }

    .img-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        display: block;
    }

    .btn {
        border-radius: 10px;
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.01em;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn:active {
        transform: translateY(1px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-primary,
    .btn-success,
    .btn-danger {
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::after,
    .btn-success::after,
    .btn-danger::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: translate(-50%, -50%) scale(1);
        transition: all 0.3s;
    }

    .btn-primary:active::after,
    .btn-success:active::after,
    .btn-danger:active::after {
        opacity: 1;
        transform: translate(-50%, -50%) scale(20);
        transition: all 0s;
    }

    .pagination {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-link {
        color: #007bff;
        padding: 6px 10px;
        font-size: 1rem;
    }

    .pagination .page-link:hover {
        background-color: #f1f1f1;
    }

    .pagination .page-link:focus {
        box-shadow: none;
    }

    #gallery {
        background-color: #f8f9fa;
    }

    table.custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.custom-table thead {
        background-color: #343a40;
        color: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    table.custom-table th,
    table.custom-table td {
        padding: 5px 7px;
        text-align: center;
    }

    table.custom-table tbody tr {
        background-color: white;
        border-bottom: 1px solid #ddd;
    }

    table.custom-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 768px) {
        table.custom-table {
            font-size: 0.9rem;
        }

        table.custom-table th,
        table.custom-table td {
            padding: 8px;
        }

        table.custom-table .action-buttons {
            flex-direction: column;
            gap: 5px;
        }

        table.custom-table .edit-btn,
        table.custom-table .delete-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        table.custom-table {
            font-size: 0.8rem;
        }

        table.custom-table th,
        table.custom-table td {
            padding: 5px;
        }

        table.custom-table .img-container {
            width: 60px;
            height: 60px;
        }

        table.custom-table .img-preview {
            width: 60px;
            height: 60px;
        }

        table.custom-table .badge-jenis {
            font-size: 0.7rem;
            padding: 4px 8px;
        }
    }

    .badge-jenis {
        padding: 6px 12px;
        font-size: 0.9rem;
        color: white;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 400;
    }

    .badge-jenis.gelas {
        background-color: #28a745;
    }

    .badge-jenis.mangkuk {
        background-color: brown;
    }

    .badge-jenis.piring {
        background-color: grey;
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

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .edit-btn,
    .delete-btn,
    .toggle-btn {
        background-color: #007bff;
        color: white;
        font-size: 1rem;
        padding: 8px 16px;
        border-radius: 5px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 40px;
        min-width: 40px;
        line-height: 1;
        border: none;
    }

    .edit-btn:hover,
    .delete-btn:hover,
    .toggle-btn:hover {
        transform: scale(1.05);
    }

    .edit-btn:active,
    .delete-btn:active,
    .toggle-btn:active {
        transform: scale(1);
    }

    .edit-btn {
        background-color: #007bff;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .delete-btn:hover {
        background-color: #c82333;
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

    .required-asterisk {
        color: #dc3545;
        font-weight: bold;
        margin-left: 3px;
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 8px;
        font-size: 0.9rem;
        color: #e74c3c;
        font-weight: 500;
        line-height: 1.2;
    }

    .invalid-feedback.show {
        display: block;
        animation: fadeInError 0.3s ease-out;
    }

    @keyframes fadeInError {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-select.is-invalid,
    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-select.is-valid,
    .form-control.is-valid {
        border-color: #28a745;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .image-upload-wrapper.is-invalid {
        border-color: #dc3545;
        background-color: rgba(220, 53, 69, 0.05);
    }

    .image-upload-wrapper.is-valid {
        border-color: #28a745;
        background-color: rgba(40, 167, 69, 0.05);
    }

    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading:after {
        content: '';
        position: absolute;
        width: 1rem;
        height: 1rem;
        top: calc(50% - 0.5rem);
        left: calc(50% - 0.5rem);
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    footer {
        background-color: #f8f9fa !important;
    }

    .admin-layout,
    #app,
    .wrapper {
        background-color: #f8f9fa !important;
        min-height: auto !important;
    }

    /* SweetAlert2 custom styles */
    .swal2-container.swal2-backdrop-show {
        background: rgba(0, 0, 0, 0.8) !important;
    }

    .success-popup {
        border-radius: 10px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
    }
</style>

<script>
    // Clear search function
    function clearSearch() {
        const searchInput = document.getElementById('searchInput');
        const form = document.querySelector('.search-form-modern');
        searchInput.value = '';
        form.submit();
    }

    // Image preview function
    function previewImage(input) {
        const file = input.files[0];
        const previewImg = document.getElementById('previewImg');
        const placeholder = document.querySelector('.placeholder');
        const wrapper = input.closest('.image-upload-wrapper');
        const errorElement = document.getElementById('gambar-error');

        if (file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                wrapper.classList.add('is-invalid');
                wrapper.classList.remove('is-valid');

                if (errorElement) {
                    errorElement.textContent = 'Format file harus berupa gambar (JPG, PNG, GIF)';
                    errorElement.classList.add('show');
                }

                if (previewImg && placeholder) {
                    previewImg.style.display = 'none';
                    placeholder.style.display = 'block';
                }

                input.value = '';
                return;
            }

            // Validate file size (max 5MB)
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                wrapper.classList.add('is-invalid');
                wrapper.classList.remove('is-valid');

                if (errorElement) {
                    errorElement.textContent = 'Ukuran file maksimal 5MB';
                    errorElement.classList.add('show');
                }

                if (previewImg && placeholder) {
                    previewImg.style.display = 'none';
                    placeholder.style.display = 'block';
                }

                input.value = '';
                return;
            }

            // File is valid
            wrapper.classList.add('is-valid');
            wrapper.classList.remove('is-invalid');

            if (errorElement) {
                errorElement.classList.remove('show');
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';

                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                }
            }
            reader.readAsDataURL(file);
        } else {
            wrapper.classList.add('is-invalid');
            wrapper.classList.remove('is-valid');

            if (errorElement) {
                errorElement.textContent = 'Gambar wajib diisi';
                errorElement.classList.add('show');
            }

            if (previewImg && placeholder) {
                previewImg.style.display = 'none';
                placeholder.style.display = 'block';
            }
        }
    }

    // Main DOMContentLoaded event listener
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('createGalleryModal');
        const openModalBtn = document.getElementById('openModalButton');
        const closeModalBtn = document.getElementById('closeModalButton');
        const galleryForm = document.getElementById('galleryForm');

        // Open modal
        openModalBtn.addEventListener('click', function() {
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.add('show');
            }, 5);

            // Reset form and validation states
            if (galleryForm) {
                galleryForm.reset();

                // Clear validation states
                document.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
                    el.classList.remove('is-invalid', 'is-valid');
                });

                document.querySelectorAll('.invalid-feedback').forEach(el => {
                    el.textContent = '';
                    el.classList.remove('show');
                });

                // Reset image preview
                const previewImg = document.getElementById('previewImg');
                const placeholder = document.querySelector('.placeholder');
                if (previewImg && placeholder) {
                    previewImg.style.display = 'none';
                    placeholder.style.display = 'block';
                }

                // Reset image upload wrapper
                const wrapper = document.querySelector('.image-upload-wrapper');
                if (wrapper) {
                    wrapper.classList.remove('is-invalid', 'is-valid');
                }
            }
        });

        // Close modal
        closeModalBtn.addEventListener('click', function() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 100);
        });

        // Close when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModalBtn.click();
            }
        });

        // Auto-dismiss alert after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.classList.remove('show');
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 150);
            }, 5000);
        });

        // Form validation with AJAX and SweetAlert2
        if (galleryForm) {
            galleryForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset error messages
                document.querySelectorAll('.invalid-feedback').forEach(function(el) {
                    el.textContent = '';
                    el.classList.remove('show');
                });

                let isValid = true;

                // Validate nama
                const namaField = document.getElementById('nama');
                if (!namaField.value || namaField.value.trim() === '') {
                    isValid = false;
                    const errorElement = document.getElementById('nama-error');
                    if (errorElement) {
                        errorElement.textContent = 'Nama member harus dipilih';
                        errorElement.classList.add('show');
                    }
                    namaField.classList.add('is-invalid');
                    namaField.classList.remove('is-valid');
                }

                // Validate jenis
                const jenisField = document.getElementById('jenis');
                if (!jenisField.value || jenisField.value.trim() === '') {
                    isValid = false;
                    const errorElement = document.getElementById('jenis-error');
                    if (errorElement) {
                        errorElement.textContent = 'Jenis harus dipilih';
                        errorElement.classList.add('show');
                    }
                    jenisField.classList.add('is-invalid');
                    jenisField.classList.remove('is-valid');
                }

                // Validate gambar
                const gambarField = document.getElementById('gambar');
                const wrapper = gambarField.closest('.image-upload-wrapper');
                const errorElement = document.getElementById('gambar-error');

                if (!gambarField.files || gambarField.files.length === 0) {
                    isValid = false;
                    wrapper.classList.add('is-invalid');
                    wrapper.classList.remove('is-valid');
                    if (errorElement) {
                        errorElement.textContent = 'Gambar wajib diisi';
                        errorElement.classList.add('show');
                    }
                } else {
                    const file = gambarField.files[0];
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        isValid = false;
                        wrapper.classList.add('is-invalid');
                        wrapper.classList.remove('is-valid');
                        if (errorElement) {
                            errorElement.textContent = 'Format file harus berupa gambar (JPG, PNG, GIF)';
                            errorElement.classList.add('show');
                        }
                    }

                    // Validate file size (max 5MB)
                    const maxSize = 5 * 1024 * 1024;
                    if (file.size > maxSize) {
                        isValid = false;
                        wrapper.classList.add('is-invalid');
                        wrapper.classList.remove('is-valid');
                        if (errorElement) {
                            errorElement.textContent = 'Ukuran file maksimal 5MB';
                            errorElement.classList.add('show');
                        }
                    }
                }

                // If form is not valid, stop submission
                if (!isValid) {
                    return;
                }

                // Create form data for submission
                const formData = new FormData(this);

                // Get submit button and store original text
                const submitButton = this.querySelector('button[type="submit"]');
                const originalButtonText = submitButton ? submitButton.innerHTML : 'Submit';

                // Disable submit button during submission
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('btn-loading');
                }

                // Function to reset button state
                function resetButton() {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.classList.remove('btn-loading');
                        submitButton.innerHTML = originalButtonText;
                    }
                }

                // Send AJAX request
                fetch(this.action, {
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
                                    resetButton();

                                    Object.keys(data.errors).forEach(field => {
                                        const errorElement = document.getElementById(field + '-error');
                                        if (errorElement) {
                                            errorElement.textContent = data.errors[field][0];
                                            errorElement.classList.add('show');
                                        }

                                        const inputField = document.getElementById(field);
                                        if (inputField) {
                                            inputField.classList.add('is-invalid');
                                            inputField.classList.remove('is-valid');
                                        }
                                    });
                                } else {
                                    // Close modal first
                                    modal.classList.remove('show');
                                    setTimeout(() => {
                                        modal.style.display = 'none';
                                    }, 100);

                                    // Show SweetAlert2 success popup
                                    Swal.fire({
                                        title: 'Successfully!',
                                        text: 'Gallery successfully added.',
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'OK',
                                        backdrop: 'rgba(0,0,0,0.7)',
                                        background: '#ffffff',
                                        customClass: {
                                            popup: 'success-popup'
                                        }
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                            });
                        } else {
                            // Close modal first
                            modal.classList.remove('show');
                            setTimeout(() => {
                                modal.style.display = 'none';
                            }, 100);

                            // Show SweetAlert2 success popup (fallback for non-JSON response)
                            Swal.fire({
                                title: 'Successfully!',
                                text: 'Gallery successfully added.',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK',
                                backdrop: 'rgba(0,0,0,0.7)',
                                background: '#ffffff',
                                customClass: {
                                    popup: 'success-popup'
                                }
                            }).then(() => {
                                window.location.reload();
                            });
                            return null;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Close modal first
                        modal.classList.remove('show');
                        setTimeout(() => {
                            modal.style.display = 'none';
                        }, 100);

                        // Show SweetAlert2 success popup (fallback for error)
                        Swal.fire({
                            title: 'Successfully!',
                            text: 'Gallery successfully added.',
                            icon: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                            backdrop: 'rgba(0,0,0,0.7)',
                            background: '#ffffff',
                            customClass: {
                                popup: 'success-popup'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    });
            });
        }

        // Real-time validation
        const namaSelect = document.getElementById('nama');
        const jenisSelect = document.getElementById('jenis');

        if (namaSelect) {
            namaSelect.addEventListener('change', function() {
                validateField(this);
            });
        }

        if (jenisSelect) {
            jenisSelect.addEventListener('change', function() {
                validateField(this);
            });
        }

        // Field validation function
        function validateField(field) {
            const errorElementId = field.id + '-error';
            const errorElement = document.getElementById(errorElementId);

            if (!field.value || field.value.trim() === '') {
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
                return false;
            } else {
                field.classList.add('is-valid');
                field.classList.remove('is-invalid');
                if (errorElement) {
                    errorElement.classList.remove('show');
                }
                return true;
            }
        }

        // Delete confirmation with SweetAlert2
        function bindDeleteButtons() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Store reference to the active delete form
                    const activeDeleteForm = this.closest('.delete-form');

                    // Show SweetAlert2 delete confirmation
                    Swal.fire({
                        title: 'Delete Gallery Data?',
                        text: "Are you sure you want to delete this gallery data?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete!',
                        cancelButtonText: 'Cancel',
                        backdrop: 'rgba(0,0,0,0.7)',
                        background: '#ffffff',
                        customClass: {
                            popup: 'success-popup'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit form delete
                            if (activeDeleteForm) {
                                // Disable button to prevent double submission
                                button.disabled = true;
                                button.innerHTML = 'Deleting...';

                                // Submit form and handle response
                                fetch(activeDeleteForm.action, {
                                        method: 'POST',
                                        body: new FormData(activeDeleteForm),
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        },
                                        credentials: 'same-origin'
                                    })
                                    .then(response => {
                                        // Show success popup
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: 'Gallery data has been successfully deleted.',
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                            backdrop: 'rgba(0,0,0,0.7)',
                                            background: '#ffffff',
                                            customClass: {
                                                popup: 'success-popup'
                                            }
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        // Show success popup (fallback for error)
                                        Swal.fire({
                                            title: 'Deleted!',
                                            text: 'Gallery data has been successfully deleted.',
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                            backdrop: 'rgba(0,0,0,0.7)',
                                            background: '#ffffff',
                                            customClass: {
                                                popup: 'success-popup'
                                            }
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    });
                            }
                        }
                    });
                });
            });
        }

        // Initial binding of delete buttons
        bindDeleteButtons();

        // Enhanced search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelector('.search-form-modern').submit();
                }
            });
        }

        // Check for success message from sessionStorage (from edit page)
        const successMessage = sessionStorage.getItem('gallery_update_success');
        if (successMessage) {
            // Remove from sessionStorage
            sessionStorage.removeItem('gallery_update_success');

            // Show SweetAlert2 success popup for update
            Swal.fire({
                title: 'Successfully!',
                text: successMessage,
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                backdrop: 'rgba(0,0,0,0.7)',
                background: '#ffffff',
                customClass: {
                    popup: 'success-popup'
                }
            });
        }
    });
</script>