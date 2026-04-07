@extends('layouts.staff')

@section('title', 'Tambah Produk - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h2 class="text-2xl md:text-3xl font-semibold text-center mb-10 text-[#DCD7D1]">Tambah Produk</h2>
<form action="{{ route('staff.products.store') }}" method="POST" enctype="multipart/form-data">
        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            
            <!-- Upload Foto -->
            <div class="flex flex-col items-center">
                <label for="image-upload" 
                    class="w-full max-w-sm aspect-[4/5] bg-[#8B7B7B] rounded-2xl border border-white/30 flex flex-col items-center justify-center cursor-pointer hover:border-white/50 transition overflow-hidden">
                    
                    <input type="file" id="image-upload" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                    
                    <div id="preview-container" class="hidden w-full h-full">
                        <img id="image-preview" class="w-full h-full object-cover">
                    </div>

                    <div id="upload-placeholder" class="flex flex-col items-center">
                        <div class="text-6xl text-white/80 mb-4">+</div>
                        <p class="text-white/90 text-center text-base font-medium px-8">
                            Tambahkan foto produk
                        </p>
                    </div>
                </label>
                <p class="text-[#C9C3BA] text-xs mt-4">Klik kotak untuk upload foto</p>
            </div>

            <!-- Form -->
            <div class="space-y-6">
                
                    @csrf

                    <div class="space-y-4">
                        <!-- NAMA -->
                        <div>
                            <input type="text" name="name" 
                                class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                                placeholder="NAMA" required>
                        </div>

                        <!-- JENIS -->
                        <div>
                            <select name="jenis" 
                                    class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white" required>
                                <option value="">JENIS</option>
                                <option value="Novel">Novel</option>
                                <option value="Komik">Komik</option>
                                <option value="Non-Fiksi">Non-Fiksi</option>
                                <option value="Pelajaran">Pelajaran</option>
                                <option value="Biografi">Biografi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <!-- HARGA -->
                        <div>
                            <input type="number" name="price" 
                                class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                                placeholder="HARGA" required>
                        </div>

                        <!-- AUTHOR -->
                        <div>
                            <input type="text" name="author" 
                                class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                                placeholder="AUTHOR">
                        </div>

                        <!-- JUMLAH -->
                        <div>
                            <input type="number" name="stock" 
                                class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-full px-6 py-3 text-sm focus:outline-none focus:border-white"
                                placeholder="JUMLAH" required>
                        </div>

                        <!-- DESKRIPSI -->
                        <div>
                            <textarea name="description" rows="6"
                                    class="w-full bg-[#4A4754] border border-[#7A6A6A] rounded-2xl px-6 py-3 text-sm focus:outline-none focus:border-white resize-none"
                                    placeholder="DESKRIPSI BUKU"></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between mt-8">
                        <a href="{{ route('staff.products.index') }}"
                        class="bg-red-600 hover:bg-red-700 text-white text-center px-8 py-2 rounded-full font-semibold text-xs transition">
                            BATAL
                        </a>
                        <button type="submit"
                                class="bg-[#8B7B7B] hover:bg-[#7A6A6A] text-white px-8 py-2 rounded-full font-semibold text-xs transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
