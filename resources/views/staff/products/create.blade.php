@extends('layouts.staff')

@section('title', 'Tambah Produk - Ephemeralbook')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-12">
        <h2 class="text-4xl font-semibold text-center mb-16">Tambah Produk</h2>
<form action="{{ route('staff.products.store') }}" method="POST" enctype="multipart/form-data">
        <div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Upload Foto -->
            <div class="flex flex-col items-center">
                <label for="image-upload" 
                    class="w-full max-w-xs aspect-[4/5] bg-[#8B5A3C] rounded-3xl border-4 border-white/30 flex flex-col items-center justify-center cursor-pointer hover:border-white/50 transition overflow-hidden">
                    
                    <input type="file" id="image-upload" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                    
                    <div id="preview-container" class="hidden w-full h-full">
                        <img id="image-preview" class="w-full h-full object-cover">
                    </div>

                    <div id="upload-placeholder" class="flex flex-col items-center">
                        <div class="text-7xl text-white/80 mb-4">+</div>
                        <p class="text-white/90 text-center text-lg font-medium px-8">
                            Tambahkan foto produk
                        </p>
                    </div>
                </label>
                <p class="text-gray-400 text-sm mt-4">Klik kotak untuk upload foto</p>
            </div>

            <!-- Form -->
            <div class="space-y-6">
                
                    @csrf

                    <div class="space-y-6">
                        <!-- NAMA -->
                        <div>
                            <input type="text" name="name" 
                                class="w-full bg-gray-800 border border-gray-600 rounded-3xl px-7 py-4 text-lg focus:outline-none focus:border-emerald-500"
                                placeholder="NAMA" required>
                        </div>

                        <!-- JENIS -->
                        <div>
                            <select name="jenis" 
                                    class="w-full bg-gray-800 border border-gray-600 rounded-3xl px-7 py-4 text-lg focus:outline-none focus:border-emerald-500" required>
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
                                class="w-full bg-gray-800 border border-gray-600 rounded-3xl px-7 py-4 text-lg focus:outline-none focus:border-emerald-500"
                                placeholder="HARGA" required>
                        </div>

                        <!-- JUMLAH -->
                        <div>
                            <input type="number" name="stock" 
                                class="w-full bg-gray-800 border border-gray-600 rounded-3xl px-7 py-4 text-lg focus:outline-none focus:border-emerald-500"
                                placeholder="JUMLAH" required>
                        </div>

                        <!-- DESKRIPSI -->
                        <div>
                            <textarea name="description" rows="6"
                                    class="w-full bg-gray-800 border border-gray-600 rounded-3xl px-7 py-4 text-lg focus:outline-none focus:border-emerald-500 resize-none"
                                    placeholder="DESKRIPSI BUKU"></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 mt-12">
                        <a href="{{ route('staff.products.index') }}"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white text-center py-4 rounded-3xl font-semibold text-lg transition">
                            BATAL
                        </a>
                        <button type="submit"
                                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-4 rounded-3xl font-semibold text-lg transition">
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