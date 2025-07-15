<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard - Edit Panduan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="bg-white shadow-md p-4 mb-6">
                <h2 class="text-xl font-semibold">Edit Panduan</h2>
            </header>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Edit Panduan') }}
                    </h2>

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('panduans.update', $panduan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Jenis Field -->
                        <div class="mb-4">
                            <label for="jenis" class="block text-gray-700 text-sm font-bold mb-2">Jenis:</label>
                            <select name="jenis" id="jenis" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jenis') border-red-500 @enderror" required>
                                <option value="" disabled>Pilih jenis sampah</option>
                                <option value="Organik" {{ $panduan->jenis == 'Organik' ? 'selected' : '' }}>Organik</option>
                                <option value="Anorganik" {{ $panduan->jenis == 'Anorganik' ? 'selected' : '' }}>Anorganik</option>
                                <option value="B3" {{ $panduan->jenis == 'B3' ? 'selected' : '' }}>B3 (Bahan Berbahaya dan Beracun)</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cara Field -->
                        <div class="mb-4">
                            <label for="cara" class="block text-gray-700 text-sm font-bold mb-2">Cara:</label>
                            <textarea name="cara" id="cara" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cara') border-red-500 @enderror" required>{{ old('cara', $panduan->cara) }}</textarea>
                            @error('cara')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Field -->
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Gambar:</label>
                            @if($panduan->image)
                                <p class="mb-2">Current image: <a href="{{ Storage::url($panduan->image) }}" target="_blank" class="text-blue-600 hover:text-blue-800">View</a></p>
                            @endif
                            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('image') border-red-500 @enderror" accept="image/*">
                            <p class="text-sm text-gray-600 mt-1">Leave empty to keep the current image</p>
                            @error('image')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Panduan
                            </button>
                            <a href="{{ route('panduans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
