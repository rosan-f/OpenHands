@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    @include('partials.navbar')

    <div class="container mx-auto px-4 max-w-4xl mt-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                <i class="fas fa-plus-circle text-cyan-500 mr-2"></i>Buat Kampanye Baru
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Mari berbagi kebaikan dan membantu sesama yang membutuhkan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-heading text-cyan-500 mr-2"></i>Judul Kampanye <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title') }}"
                           placeholder="Contoh: Bantu Operasi Jantung untuk Anak Yatim"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-tag text-cyan-500 mr-2"></i>Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id"
                            id="category_id"
                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-align-left text-cyan-500 mr-2"></i>Deskripsi Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description"
                              id="description"
                              rows="8"
                              placeholder="Ceritakan detail tentang kampanye ini. Semakin detail, semakin mudah orang memahami dan membantu. (Minimal 50 karakter)"
                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white resize-none"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i><span id="char-count">0</span> / minimal 50 karakter
                    </p>
                </div>

                <!-- Target Amount -->
                <div>
                    <label for="target_amount" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-bullseye text-cyan-500 mr-2"></i>Target Dana <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                        <input type="number"
                               name="target_amount"
                               id="target_amount"
                               value="{{ old('target_amount') }}"
                               min="100000"
                               step="1000"
                               placeholder="1000000"
                               class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white"
                               required>
                    </div>
                    @error('target_amount')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400"><i class="fas fa-info-circle mr-1"></i>Minimal Rp 100.000</p>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-calendar-alt text-cyan-500 mr-2"></i>Batas Waktu (Opsional)
                    </label>
                    <input type="date"
                           name="deadline"
                           id="deadline"
                           value="{{ old('deadline') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white">
                    @error('deadline')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Multiple Images Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <i class="fas fa-images text-cyan-500 mr-2"></i>Foto Kampanye (Maksimal 5 foto)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6">
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" onchange="previewImages(event)">
                        <label for="images" class="cursor-pointer flex flex-col items-center justify-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span class="font-semibold text-cyan-600 dark:text-cyan-400">Klik untuk upload</span> atau drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP (MAX. 2MB per file)</p>
                        </label>
                    </div>

                    <!-- Preview Container -->
                    <div id="preview-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 mt-4 hidden"></div>

                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                        <i class="fas fa-toggle-on text-cyan-500 mr-2"></i>Status Publikasi <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border-2 border-transparent has-checked:border-cyan-500">
                            <input type="radio" name="status" value="active" class="w-4 h-4 text-cyan-600 focus:ring-cyan-500" {{ old('status', 'active') == 'active' ? 'checked' : '' }} required>
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white"><i class="fas fa-check-circle text-green-500 mr-1"></i>Publikasikan Sekarang</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Kampanye akan langsung terlihat oleh publik</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors border-2 border-transparent has-checked:border-cyan-500">
                            <input type="radio" name="status" value="draft" class="w-4 h-4 text-cyan-600 focus:ring-cyan-500" {{ old('status') == 'draft' ? 'checked' : '' }}>
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white"><i class="fas fa-save text-yellow-500 mr-1"></i>Simpan sebagai Draft</span>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Kampanye tidak akan terlihat, Anda bisa edit nanti</p>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('home') }}" class="px-6 py-3 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>Buat Kampanye
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Character counter
const description = document.getElementById('description');
const charCount = document.getElementById('char-count');

description.addEventListener('input', function() {
    charCount.textContent = this.value.length;
});

// Multiple Images Preview
function previewImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('preview-container');
    previewContainer.innerHTML = '';

    if (files.length > 0) {
        previewContainer.classList.remove('hidden');

        if (files.length > 5) {
            alert('Maksimal 5 foto yang dapat diupload');
            event.target.value = '';
            previewContainer.classList.add('hidden');
            return;
        }

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                    <button type="button" onclick="removePreview(${index})"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        previewContainer.classList.add('hidden');
    }
}

function removePreview(index) {
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    const files = Array.from(input.files);

    files.splice(index, 1);

    files.forEach(file => dt.items.add(file));
    input.files = dt.files;

    previewImages({ target: input });
}
</script>
@endpush
@endsection
