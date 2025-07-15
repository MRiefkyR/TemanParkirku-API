<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard - Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex h-screen">

@include('partials.sidebar')

<main class="flex-1 p-8 overflow-y-auto">
    <!-- Header -->
    <header class="bg-white shadow-md p-6 rounded mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Edit Data User</h2>
    </header>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Form Edit User</h2>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $user->nama) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password (Opsional)</label>
                    <input type="password" name="password" id="password" placeholder="Biarkan kosong jika tidak ingin mengganti" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring">
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Role</label>
                    <select name="role" id="role" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="pengguna" {{ old('role', $user->role) == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                        <option value="penjaga" {{ old('role', $user->role) == 'penjaga' ? 'selected' : '' }}>Penjaga</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded">
                        Perbarui
                    </button>
                    <a href="{{ route('user.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded">
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
