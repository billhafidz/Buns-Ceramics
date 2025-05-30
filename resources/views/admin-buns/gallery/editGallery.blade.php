@extends('layouts.admin')

@section('content')
<section id="edit-gallery" class="bg-light py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="font-size: 1.8rem; color: #333; font-weight: 600;">Edit Gallery</h2>
        </div>

        <form method="POST" action="{{ route('admin-buns.gallery.update', $gallery->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="modal-header" style="background-color: #333; color: white; border-radius: 10px 10px 0 0; padding: 20px 30px;">
                <h5 class="modal-title">Edit Gallery: {{ $gallery->nama }}</h5>
            </div>

            <div class="modal-body" style="background-color: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);">


                <!-- Input Nama (Display member name as static text) -->
                <div class="mb-3">
                    <label for="nama" class="form-label" style="font-weight: bold; color: #333;">Nama Member: {{ $gallery->nama }}</label>



                    <input type="hidden" name="nama" value="{{ $gallery->nama }}">
                </div>


                <!-- Input Jenis -->
                <div class="mb-3">
                    <label for="jenis" class="form-label" style="font-weight: bold; color: #333;">Jenis</label>
                    <select class="form-select" id="jenis" name="jenis" required style="border: 1px solid #ccc; border-radius: 10px; width: 574px; padding: 12px 16px; font-size: 1rem; transition: all 0.3s ease; background-color: #ffffff; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);">
                        <option value="gelas" {{ $gallery->jenis == 'gelas' ? 'selected' : '' }}>Gelas</option>
                        <option value="mangkuk" {{ $gallery->jenis == 'mangkuk' ? 'selected' : '' }}>Mangkuk</option>
                        <option value="piring" {{ $gallery->jenis == 'piring' ? 'selected' : '' }}>Piring</option>
                    </select>
                </div>

                <!-- Input Gambar -->
                <div class="mb-3">
                    <div class="image-upload-wrapper" style="display: flex; flex-direction: column; gap: 15px; background-color: #ffffff; padding: 20px; border-radius: 12px; border: 1px dashed rgba(0, 0, 0, 0.15); transition: all 0.3s ease;">
                        <div class="image-preview" id="editImagePreview" style="width: 100%; padding: 15px; background-color: rgba(0, 123, 255, 0.03); border-radius: 10px; text-align: center; min-height: 120px; display: flex; align-items: center; justify-content: center;">
                            @if($gallery->gambar)
                            <img src="{{ asset('storage/' . $gallery->gambar) }}" alt="Preview" id="editPreviewImg" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                            @else
                            <div class="placeholder" style="display: flex; flex-direction: column; align-items: center; color: #6c757d;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #007bff; margin-bottom: 10px; opacity: 0.7;"></i>
                                <p style="margin: 5px 0; font-weight: 600; font-size: 1rem;">Pilih gambar baru</p>
                            </div>
                            @endif
                        </div>
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewEditImage(this)" style="border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 12px 16px; font-size: 1rem; transition: all 0.3s ease;">
                    </div>
                </div>


                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="keep_image" name="keep_image" checked style="width: 18px; height: 18px;">
                    <label class="form-check-label" for="keep_image" style="font-size: 1rem; color: #333; margin-left: 8px;">
                        Tetap gunakan gambar yang ada jika tidak memilih gambar baru
                    </label>
                </div>
            </div>

            <div class="modal-footer" style="border-top: none; justify-content: space-between; padding: 20px 30px; background-color: #f8f9fa;">
                <a href="{{ route('admin-buns.gallery') }}" class="btn btn-danger" style="background-color: #dc3545; color: white; border: none; padding: 12px 24px; font-size: 1rem; font-weight: 600; letter-spacing: 0.01em; border-radius: 10px; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-times me-2"></i> Batal
                </a>
                <button type="submit" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 10px 20px; margin-left: 15px;font-size: 1rem; font-weight: 600; letter-spacing: 0.01em; border-radius: 10px; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-save me-2"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</section>


<!-- Script for image preview -->
<script>
    function previewEditImage(input) {
        const previewImg = document.getElementById('editPreviewImg');
        const placeholder = document.querySelector('.placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                if (previewImg) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                } else {

                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.id = 'editPreviewImg';
                    newImg.style.maxWidth = '100%';
                    newImg.style.maxHeight = '200px';
                    newImg.style.objectFit = 'contain';
                    newImg.style.borderRadius = '8px';
                    newImg.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)';


                    const imagePreview = document.getElementById('editImagePreview');
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                    imagePreview.appendChild(newImg);
                }


                if (placeholder) {
                    placeholder.style.display = 'none';
                }


                if (previewImg) {
                    previewImg.style.opacity = '0';
                    setTimeout(() => {
                        previewImg.style.opacity = '1';
                    }, 50);
                }
            }

            reader.readAsDataURL(input.files[0]);


            document.getElementById('keep_image').checked = false;
        }
    }




    // Add hover effect to buttons
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn');

        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.1)';
            });

            btn.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(1px)';
                this.style.boxShadow = '0 2px 3px rgba(0, 0, 0, 0.1)';
            });

            btn.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
            });
        });
    });
</script>
@endsection