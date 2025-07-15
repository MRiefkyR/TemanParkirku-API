<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Profile') }} - Wastify</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="bg-white shadow-md p-4 mb-6">
                <h2 class="text-xl font-semibold">{{ __('Profile') }}</h2>
            </header>

            @if(session('status'))
                <div id="alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <!-- Profile Content -->
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold text-indigo-600 mb-6">{{ __('Personal Information') }}</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->name }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->email }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Date of Birth') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->tanggal_lahir ? $user->tanggal_lahir->format('F d, Y') : 'Not provided' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Religion') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->agama ?? 'Not provided' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->nomor_telepon ?? 'Not provided' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->alamat ?? 'Not provided' }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">{{ __('Joined') }}</label>
                        <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $user->created_at->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Edit Profile') }}
                        </a>
                    </div>
                </div>
            </div>



            <!-- Password Update Form -->
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-bold text-indigo-600 mb-6">{{ __('Update Password') }}</h3>
                    
                    @if ($errors->has('current_password'))
                        <div id="current-password-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ $errors->first('current_password') }}</span>
                        </div>
                    @endif

                    @if ($errors->has('password'))
                        <div id="password-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ $errors->first('password') }}</span>
                        </div>
                    @endif

                    @if(session('password_success'))
                        <div id="password-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('password_success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">
                                    {{ __('Current Password') }}
                                </label>
                                <div class="mt-1">
                                    <input id="current_password" name="current_password" type="password" 
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    {{ __('New Password') }}
                                </label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" 
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    {{ __('Confirm New Password') }}
                                </label>
                                <div class="mt-1">
                                    <input id="password_confirmation" name="password_confirmation" type="password" 
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Update Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; 2024 Wastify. All rights reserved.</p>
    </footer>
</body>
<script>
    // Function to hide alerts after a specified duration
    function hideAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (alert) {
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    }

    // Call the function for each alert
    hideAlert('current-password-error');
    hideAlert('password-error');
    hideAlert('password-success');
    hideAlert('alert');
</script>

</html>