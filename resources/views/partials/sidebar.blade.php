<aside class="w-64 bg-gray-800 text-white flex flex-col shadow-lg">
    <div class="flex items-center justify-between p-6">
        <h1 class="text-3xl font-bold text-center text-indigo-400">Teman Parkirku</h1>
    </div>
    <nav>
        <ul>
            <li class="mb-4">
                <a href="{{ route('dashboard') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path d="M10.707 1.707a1 1 0 00-1.414 0l-8 8A1 1 0 002 11h2v6a1 1 0 001 1h4a1 1 0 001-1v-4h2v4a1 1 0 001 1h4a1 1 0 001-1v-6h2a1 1 0 00.707-1.707l-8-8z" />
                    </svg>
                    Home
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('user.index') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zm0 2c-2.67 0-8 1.34-8 4v2a1 1 0 001 1h14a1 1 0 001-1v-2c0-2.66-5.33-4-8-4zm5-4a2 2 0 11-4 0 2 2 0 014 0zm-9 0a2 2 0 11-4 0 2 2 0 014 0zm1 4c-1.74 0-4.68.88-5.5 2.31a.999.999 0 00.09 1.04c.18.24.46.39.74.39h10.34c.28 0 .56-.15.74-.39a.999.999 0 00.09-1.04C15.68 10.88 12.74 10 11 10H7z" />
                    </svg>
                    Data User
                </a>
            </li>
            <li class="mb-4">
                <a href="{{ route('pengguna.index') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zm0 2c-2.67 0-8 1.34-8 4v2a1 1 0 001 1h14a1 1 0 001-1v-2c0-2.66-5.33-4-8-4zm5-4a2 2 0 11-4 0 2 2 0 014 0zm-9 0a2 2 0 11-4 0 2 2 0 014 0zm1 4c-1.74 0-4.68.88-5.5 2.31a.999.999 0 00.09 1.04c.18.24.46.39.74.39h10.34c.28 0 .56-.15.74-.39a.999.999 0 00.09-1.04C15.68 10.88 12.74 10 11 10H7z" />
                    </svg>
                    Pengguna
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('penjaga.index') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path d="M6 2a1 1 0 011-1h6a1 1 0 011 1h3a1 1 0 110 2h-1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V4H2a1 1 0 110-2h3zM7 6a1 1 0 10-2 0v8a1 1 0 102 0V6zm6 0a1 1 0 10-2 0v8a1 1 0 102 0V6zm-4 0a1 1 0 10-2 0v8a1 1 0 102 0V6z" />
                    </svg>
                    Penjaga
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('riwayatPembayaran.index') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path d="M6 2a1 1 0 011-1h6a1 1 0 011 1h3a1 1 0 110 2h-1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V4H2a1 1 0 110-2h3zM7 6a1 1 0 10-2 0v8a1 1 0 102 0V6zm6 0a1 1 0 10-2 0v8a1 1 0 102 0V6zm-4 0a1 1 0 10-2 0v8a1 1 0 102 0V6z" />
                    </svg>
                    Riwayat Pembayaran
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('parkir.index') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path d="M6 2a1 1 0 000 2H7v1a1 1 0 102 0V4h2v1a1 1 0 102 0V4h1a1 1 0 100-2H6zM3 6a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V6zm2 0v10h10V6H5z" />
                    </svg>
                    Parkir
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('profile.show') }}" class="flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5 mr-3">
                        <path fill-rule="evenodd" d="M10 2a5 5 0 100 10 5 5 0 000-10zm-7 15a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Profile
                </a>
            </li>

            <li class="mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center hover:bg-gray-700 px-4 py-2 rounded transition duration-200 ease-in text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 19l-7-7 7-7"/>
                            <path d="M5 12h14"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>
