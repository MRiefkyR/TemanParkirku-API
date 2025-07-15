<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Edit Profile') }} - Wastify</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="bg-white shadow-md p-4 mb-6">
                <h2 class="text-xl font-semibold">{{ __('Edit Profile') }}</h2>
            </header>
  
            <!-- Edit Profile Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Name') }}:</label>
                            <input type="text" name="name" id="name" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Email Address') }}:</label>
                            <input type="email" name="email" id="email" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" value="{{ old('email', $user->email) }}" required autocomplete="email">
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="tanggal_lahir" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Date of Birth') }}:</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tanggal_lahir') border-red-500 @enderror" value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}">
                            @error('tanggal_lahir')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="agama" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Religion') }}:</label>
                            <input type="text" name="agama" id="agama" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('agama') border-red-500 @enderror" value="{{ old('agama', $user->agama) }}">
                            @error('agama')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="nomor_telepon" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone Number') }}:</label>
                            <input type="text" name="nomor_telepon" id="nomor_telepon" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('nomor_telepon') border-red-500 @enderror" value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
                            @error('nomor_telepon')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Address') }}:</label>
                            <textarea name="alamat" id="alamat" rows="3" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('alamat') border-red-500 @enderror">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Profile
                            </button>
                            <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; 2025 Teman Parkirku. All rights reserved.</p>
    </footer>
</body>
</html>
