<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard - Riwayat Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    @include('partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">
        <header class="bg-white shadow-md p-4 mb-6">
            <h2 class="text-xl font-semibold">Riwayat Pembayaran</h2>
        </header>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Daftar Riwayat</h3>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Nominal</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $item->tanggal ?? $item->created_at->format('d-m-Y') }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">{{ $item->order_id }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800">Rp{{ number_format($item->nominal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800 flex items-center gap-2">
                                        @if($item->metode_icon)
                                            <img src="{{ asset('storage/metode_icons/' . $item->metode_icon) }}" class="w-5 h-5" alt="{{ $item->metode }}">
                                        @endif
                                        {{ ucfirst($item->metode) }}
                                    </td>
                                    <td class="px-6 py-4 border-b text-sm text-gray-800 capitalize">{{ $item->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat pembayaran.</td>
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
