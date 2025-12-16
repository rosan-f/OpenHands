@extends('layouts.app')
@section('title', 'Buat Kampanye')
@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-200">
    <div class="flex">
        <!-- Sidebar Kiri - Desktop Only -->
        <aside class="hidden lg:flex flex-col fixed left-0 top-0 h-screen w-64 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 z-40">
            @include('partials.sidebar-left')
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 pb-16 lg:pb-0">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <!-- Form Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-col lg:flex-row">

                            <!-- Left Column - Form Inputs -->
                            <div class="flex-1 p-6 lg:p-8 space-y-6">

                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        Judul Kampanye
                                    </label>
                                    <input type="text"
                                           name="title"
                                           id="title"
                                           value="{{ old('title') }}"
                                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all"
                                           required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category_id" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        Kategori
                                    </label>
                                    <div class="relative">
                                        <select name="category_id"
                                                id="category_id"
                                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white appearance-none transition-all"
                                                required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                                    </div>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        Deskripsi
                                    </label>
                                    <textarea name="description"
                                              id="description"
                                              rows="6"
                                              class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white resize-none transition-all"
                                              required>{{ old('description') }}</textarea>
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            <span id="char-count">0</span> / minimal 50 karakter
                                        </p>
                                        @error('description')
                                            <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Target Amount & Deadline -->
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <!-- Target Amount -->
                                    <div class="flex-1">
                                        <label for="target_amount" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                            Target Dana
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 font-medium">Rp</span>
                                            <input type="number"
                                                   name="target_amount"
                                                   id="target_amount"
                                                   value="{{ old('target_amount') }}"
                                                   min="100000"
                                                   step="1000"
                                                   placeholder="1.000.000"
                                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all"
                                                   required>
                                        </div>
                                        @error('target_amount')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimal Rp 100.000</p>
                                    </div>

                                    <!-- Deadline -->
                                    <div class="flex-1">
                                        <label for="deadline" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                            Batas Waktu
                                        </label>
                                        <input type="date"
                                               name="deadline"
                                               id="deadline"
                                               value="{{ old('deadline') }}"
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent text-gray-900 dark:text-white transition-all">
                                        @error('deadline')
                                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Opsional</p>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">
                                        Status Publikasi
                                    </label>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <label class="flex-1 relative">
                                            <input type="radio" name="status" value="active" class="peer sr-only" {{ old('status', 'active') == 'active' ? 'checked' : '' }} required>
                                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer transition-all peer-checked:border-cyan-500 peer-checked:bg-cyan-50 dark:peer-checked:bg-cyan-900/20 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900 dark:text-white text-sm">Publikasikan</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Langsung terlihat</p>
                                                </div>
                                            </div>
                                        </label>

                                        <label class="flex-1 relative">
                                            <input type="radio" name="status" value="draft" class="peer sr-only" {{ old('status') == 'draft' ? 'checked' : '' }}>
                                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer transition-all peer-checked:border-cyan-500 peer-checked:bg-cyan-50 dark:peer-checked:bg-cyan-900/20 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <i class="fas fa-save text-yellow-500 text-xl mr-3"></i>
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900 dark:text-white text-sm">Simpan Draft</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">Edit nanti</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <!-- Image Upload -->
                            <div class="lg:w-96 lg:border-l border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-6 lg:p-8">
                                <div class="sticky top-6">
                                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                                        Foto Kampanye
                                    </label>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                                        Upload hingga 5 foto (max 2MB/foto)
                                    </p>

                                    <!-- Upload Area -->
                                    <div class="mb-4">
                                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden" onchange="previewImages(event)">
                                        <label for="images" class="block border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center cursor-pointer hover:border-cyan-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all group">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 dark:text-gray-500 group-hover:text-cyan-500 transition-colors mb-2"></i>
                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                Klik untuk upload
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                PNG, JPG, WEBP
                                            </p>
                                        </label>
                                    </div>

                                    @error('images')
                                        <p class="mb-3 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                    @error('images.*')
                                        <p class="mb-3 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror

                                    <!-- Preview Container -->
                                    <div id="preview-container" class="space-y-3"></div>
                                </div>
                            </div>

                        </div>

                        <!-- Form Actions -->
                        <div class="px-6 lg:px-8 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <a href="{{ route('home') }}" class="px-6 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg transition-colors font-medium flex items-center w-full sm:w-auto justify-center sm:justify-start">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="submit" class="px-8 py-2.5 bg-linear-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center w-full sm:w-auto justify-center">
                                <i class="fas fa-paper-plane mr-2"></i>Buat Kampanye
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </main>
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
            if (files.length > 5) {
                alert('Maksimal 5 foto yang dapat diupload');
                event.target.value = '';
                return;
            }

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group bg-white dark:bg-gray-800 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover">
                        <button type="button" onclick="removePreview(${index})"
                                class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 w-7 h-7 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-lg">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            Foto ${index + 1}
                        </div>
                    `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
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
