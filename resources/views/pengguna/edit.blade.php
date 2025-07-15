<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard - Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="bg-white shadow-md p-4 mb-6">
                <h2 class="text-xl font-semibold">Edit Pengguna</h2>
            </header>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-6">
                            <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $pengguna->user->nama ?? '') }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring" required>
                            @error('nama')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-6">
                            <label for="jenis_kelamin" class="block text-gray-700 font-bold mb-2">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $pengguna->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $pengguna->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-6">
                            <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat:</label>
                            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $pengguna->alamat) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring">
                            @error('alamat')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Plat Nomor -->
                        <div class="mb-6">
                            <label for="plat_no" class="block text-gray-700 font-bold mb-2">Plat Nomor:</label>
                            <input type="text" name="plat_no" id="plat_no" value="{{ old('plat_no', $pengguna->plat_no) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring">
                            @error('plat_no')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor HP -->
                        <div class="mb-6">
                            <label for="no_hp" class="block text-gray-700 font-bold mb-2">Nomor HP:</label>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $pengguna->no_hp) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring">
                            @error('no_hp')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Last Payment Method -->
                        <div class="mb-6">
                            <label for="last_payment_method" class="block text-gray-700 font-bold mb-2">Last Payment Method:</label>
                            <input type="text" name="last_payment_method" id="last_payment_method" value="{{ old('last_payment_method', $pengguna->last_payment_method) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring">
                            @error('last_payment_method')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded">
                                Update Pengguna
                            </button>
                            <a href="{{ route('pengguna.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
