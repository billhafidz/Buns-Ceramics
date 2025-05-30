@extends('layouts.admin')

@section('content')

<section id="gallery" class="bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="font-size: 1.8rem; color: #333; font-weight: 600;">Tambah Gallery</h2>
        </div>
        <!-- Button to trigger modal with JavaScript -->
        <div class="d-flex justify-content-end mb-4">
            <form action="{{ route('admin-buns.gallery') }}" method="GET" style="display: flex;">
                <input type="text" id="searchInput" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari gallery..." style="width: 1320px; margin-right: 5px;" />
                <button type="submit" class="btn btn-primary" style="background: #343a40; color: white;">Cari</button>
            </form>

            <button class="btn btn-primary" id="openModalButton" style="background-color: #007bff;margin-top: 10px; border: none; padding: 10px 20px; font-size: 1rem; color: white; border-radius: 5px;">
                + Tambah Gallery

            </button>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="createGalleryModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #333; color: white; border-radius: 10px 10px 0 0; padding: 20px 30px;">
                    <h5 class="modal-title">Tambah Gallery</h5>
                </div>
                <form method="POST" action="{{ route('admin-buns.gallery.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" style="background-color: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">
                        <div class="mb-3">
                            <label for="nama" class="form-label" style="font-weight: bold; color: #333;">Nama Member</label>
                            <select class="form-select" id="nama" name="nama" required>
                                <option value="" disabled selected>Pilih Nama Member</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->nama_member }}">{{ $member->nama_member }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label" style="font-weight: bold; color: #333;">Jenis</label>
                            <select class="form-select" id="jenis" name="jenis" required style="border: 1px solid #ccc; border-radius: 8px; padding: 10px 12px; width: 574px;">
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="gelas">Gelas</option>
                                <option value="mangkuk">Mangkuk</option>
                                <option value="piring">Piring</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="image-upload-wrapper" style="display: flex; align-items: center;">
                                <div class="image-preview" id="imagePreview" style="flex: 1;">
                                    <div class="placeholder" style="text-align: left; padding: 10px;">
                                        <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #007bff;"></i>
                                        <p style="color: #333; margin-left: 10px;"><b>Pilih gambar</b></p>
                                    </div>
                                    <img src="" alt="Preview" id="previewImg" style="display: none; max-width: 100%; height: auto; object-fit: cover;">
                                </div>
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(this)" style="border: 1px solid #ccc; border-radius: 8px; padding: 10px 12px;">
                            </div>
                        </div>
                    </div>
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
                            <div class="action-buttons">
                                <a href="{{ route('admin-buns.gallery.edit', $item->id) }}" class="btn-action edit-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin-buns.gallery.delete', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete-btn">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">
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
    </div>
</section>

@endsection



<script src="https://cdn.tailwindcss.com"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // JavaScript untuk men-trigger modal dengan tombol
    document.getElementById('openModalButton').addEventListener('click', function() {
        var modal = document.getElementById('createGalleryModal');
        modal.style.display = 'block'; // Menampilkan modal
    });

    // JavaScript untuk menutup modal
    document.getElementById('closeModalButton').addEventListener('click', function() {
        var modal = document.getElementById('createGalleryModal');
        modal.style.display = 'none'; // Menutup modal
    });
</script>

<script>
    function previewImage(input) {
        const file = input.files[0];
        const previewImg = document.getElementById('previewImg');
        const placeholder = document.querySelector('.placeholder');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            previewImg.style.display = 'none';
            placeholder.style.display = 'block';
        }
    }
</script>

<style>
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


    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-dialog {
        animation: modalFadeIn 0.4s forwards;
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


    .badge-jenis {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        color: white;
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


    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-action {
        padding: 6px 10px;
        border-radius: 5px;
        font-size: 0.8rem;
        cursor: pointer;
        border: none;
        transition: all 0.3s;
    }

    .edit-btn {
        background-color: #007bff;
        color: white;
        font-size: 1rem;

        padding: 20px 20px 10px 20px;


    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
        font-size: 1rem;

        padding: 10px 20px 10px 20px;
        margin-top: 10px;

    }

    .btn-action:hover {
        transform: translateY(-3px);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('createGalleryModal');
        const openModalBtn = document.getElementById('openModalButton');
        const closeModalBtn = document.getElementById('closeModalButton');


        openModalBtn.addEventListener('click', function() {
            console.log('Modal button clicked');
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        });


        // Pastikan modal hanya ditutup ketika tombol Close yang diklik
        closeModalBtn.addEventListener('click', function() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
        });

        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModalBtn.click();
            }
        });
    });
</script>

<script>
    // Image preview enhancement
    const fileInput = document.getElementById('gambar');
    const previewImg = document.getElementById('previewImg');
    const placeholder = document.querySelector('.placeholder');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                placeholder.style.display = 'none';

                // Add subtle animation
                previewImg.style.opacity = '0';
                setTimeout(() => {
                    previewImg.style.opacity = '1';
                }, 50);
            }
            reader.readAsDataURL(file);
        } else {
            previewImg.style.display = 'none';
            placeholder.style.display = 'block';
        }
    });

    // Form field animations
    const formInputs = document.querySelectorAll('.form-control, .form-select');

    formInputs.forEach(input => {
        // Add focus effect
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('is-focused');
        });

        // Remove focus effect
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('is-focused');
        });
    });
</script>