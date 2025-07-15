<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard - Manajemen Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="bg-white shadow-md p-4 mb-6">
                <h2 class="text-xl font-semibold">Manajemen Pengguna</h2>
            </header>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Daftar Pengguna</h3>
                        <a href="{{ route('pengguna.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150">Tambah Pengguna</a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="my-4 overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300 rounded-lg">
                            <thead class="bg-gradient-to-r from-gray-100 to-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Jenis Kelamin</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Alamat</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">No HP</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Metode Pembayaran Terakhir</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($semuaPengguna ?? [] as $pengguna)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-300">
                                            {{ $pengguna->user->nama ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-300">{{ $pengguna->jenis_kelamin }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-300">{{ $pengguna->alamat }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-300">{{ $pengguna->no_hp }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-300">{{ $pengguna->last_payment_method ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center border-b border-gray-300">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('pengguna.edit', $pengguna->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">Edit</a>
                                                <form action="{{ route('pengguna.destroy', $pengguna->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data pengguna.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; 2025 Teman Parkirku. All rights reserved.</p>
    </footer>
</body>
</html>
