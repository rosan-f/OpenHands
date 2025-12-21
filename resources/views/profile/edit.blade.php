@extends('layouts.app')
@section('title', 'Edit Profil')
@section('content')



    <div class="max-w-2xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4 mb-2">
                <a href="{{ route('profile.index') }}"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Profil</h1>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Perbarui informasi profil Anda</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                <div class="flex items-center">
                    <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 mr-3"></i>
                    <p class="text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Avatar Upload -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">
                    Foto Profil
                </label>
                <div class="flex items-center space-x-6">
                    <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar"
                        class="w-24 h-24 rounded-full ring-4 ring-gray-200 dark:ring-gray-700">
                    <div>
                        <label for="avatar"
                            class="cursor-pointer px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-semibold rounded-lg transition-colors inline-block">
                            <i class="fa-solid fa-camera mr-2"></i> Pilih Foto
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">JPG, PNG atau GIF. Max 2MB</p>
                    </div>
                </div>
                @error('avatar')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Nama Lengkap
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-800 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label for="bio" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Bio
                </label>
                <textarea id="bio" name="bio" rows="3"
                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-800 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all resize-none"
                    placeholder="Ceritakan tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maksimal 500 karakter</p>
                @error('bio')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-800 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-6">
                <label for="phone" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Nomor Telepon
                </label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-800 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                    placeholder="+62...">
                @error('phone')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div class="mb-8">
                <label for="location" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Lokasi
                </label>
                <input type="text" id="location" name="location" value="{{ old('location', $user->location) }}"
                    class="w-full px-4 py-3 bg-gray-100 dark:bg-gray-800 border-0 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-cyan-500 transition-all"
                    placeholder="Kota, Negara">
                @error('location')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex space-x-4">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold rounded-xl transition-colors">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('profile.index') }}"
                    class="px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>


    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
