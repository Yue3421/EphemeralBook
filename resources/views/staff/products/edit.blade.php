@extends('layouts.staff')

@section('title', 'Edit Produk - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-10 text-[#DCD7D1]">Edit Produk</h2>

        <form action="{{ route('staff.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            @csrf
            @method('PUT')
            
            <!-- === BAGIAN UPLOAD FOTO (INI YANG HILANG) === -->
            <div class="flex flex-col items-center">
                <label for="image-upload" 
                       class="w-full max-w-sm aspect-[4/5] bg-[#8B7B7B] rounded-2xl border border-white/30 flex flex-col items-center justify-center cursor-pointer hover:border-white/50 transition overflow-hidden">
                    
                    <input type="file" id="image-upload" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                    
                    <div id="preview-container" class="{{ $product->image ? '' : 'hidden' }} w-full h-full">
                        <img id="image-preview" 
                             src="{{ $product->image ? Storage::url($product->image) : '' }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <div id="upload-placeholder" class="{{ $product->image ? 'hidden' : '' }} flex flex-col items-center">
                        <div class="text-6xl text-white/80 mb-4">+</div>
                        <p class="text-white/90 text-center text-base font-medium px-8">
                            Ganti foto produk
                        </p>
                    </div>
                </label>
                <p class="text-[#C9C3BA] text-xs mt-4">Klik kotak untuk ganti foto</p>
            </div>

            <!-- Form -->
            <div class="space-y-6">
                    <div class="space-y-4">
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                               class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                               placeholder="NAMA" required>

                        <select name="jenis" class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white" required>
                            <option value="">JENIS</option>
                            <option value="Novel" {{ old('jenis', $product->jenis) == 'Novel' ? 'selected' : '' }}>Novel</option>
                            <option value="Komik" {{ old('jenis', $product->jenis) == 'Komik' ? 'selected' : '' }}>Komik</option>
                            <option value="Non-Fiksi" {{ old('jenis', $product->jenis) == 'Non-Fiksi' ? 'selected' : '' }}>Non-Fiksi</option>
                            <option value="Pelajaran" {{ old('jenis', $product->jenis) == 'Pelajaran' ? 'selected' : '' }}>Pelajaran</option>
                            <option value="Biografi" {{ old('jenis', $product->jenis) == 'Biografi' ? 'selected' : '' }}>Biografi</option>
                            <option value="Lainnya" {{ old('jenis', $product->jenis) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>

                        <input type="number" name="price" value="{{ old('price', $product->price) }}"
                               class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                               placeholder="HARGA" required>

                        <input type="text" name="author" value="{{ old('author', $product->author) }}"
                               class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                               placeholder="AUTHOR">

                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                               class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                               placeholder="JUMLAH" required>

                        <textarea name="description" rows="6"
                                  class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-white resize-none"
                                  placeholder="DESKRIPSI BUKU">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <a href="{{ route('staff.products.index') }}" 
                           class="bg-red-600 hover:bg-red-700 text-white text-center px-8 py-2 rounded-full font-semibold text-xs transition">
                            BATAL
                        </a>
                        <button type="submit"
                                class="bg-[#8B7B7B] hover:bg-[#7A6A6A] text-white px-8 py-2 rounded-full font-semibold text-xs transition">
                            Update Produk
                        </button>
                    </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
