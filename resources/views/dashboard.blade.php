<!-- FILEPATH: /d:/Kuliah Online/New folder/wastify/resources/views/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->  
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <header class="bg-white shadow-md p-4 mb-6 rounded-lg">
                <h2 class="text-xl font-semibold">Dashboard</h2>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
                <!-- Total Waste Entries Card -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-trash fa-2x text-blue-500"></i>
                        <h3 class="text-lg font-semibold ml-4">Total Penjaga Parkir</h3>
                    </div>
                    <p class="text-3xl font-bold" id="totalWasteEntries">
                        {{ number_format($totalWasteEntries) }}
                    </p>
                </div>

                <!-- Registered Users Card -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-users fa-2x text-purple-500"></i>
                        <h3 class="text-lg font-semibold ml-4">Total pengguna</h3>
                    </div>
                    <p class="text-3xl font-bold" id="registeredUsersCount">
                        {{ number_format($registeredUsersCount) }}
                    </p>
                </div>
            </div>


            <!-- About Wastify Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">About Teman Parkirku</h2>
                <p class="mb-2">Teman Parkirku is an innovative platform dedicated to revolutionizing waste management and promoting sustainable practices in communities. Our mission is to empower individuals, businesses, and organizations to reduce waste, recycle effectively, and contribute to a cleaner, greener planet.</p>
                <p class="mb-2">At Teman Parkirku, we envision a world where waste is minimized, resources are conserved, and communities thrive in harmony with the environment. We believe that through education, technology, and community engagement, we can create a sustainable future for generations to come.</p>
                <p class="mb-2">We provide comprehensive waste collection services, promote recycling initiatives, and foster community engagement through various programs. Our platform also offers valuable data and analytics to help users track their waste generation and recycling efforts.</p>
                <p class="mb-2">Join us in making a difference in waste management and contributing to a sustainable future. Together, we can create a cleaner, greener world.</p>
            </div>
        </main>
    </div>

    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; 2025 Teman Parkirku. All rights reserved.</p>
    </footer>

    <script>
function updateDashboardData() {
    $.ajax({
        url: '{{ route("dashboard-data") }}',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('#totalWasteEntries').text(response.totalWasteEntries.toLocaleString());
            // ... (kode lainnya tetap sama)
        },
        error: function(xhr, status, error) {
            console.error("Error updating dashboard data:", error);
        }
    });

            $.ajax({
                url: '{{ route("registered-users-count") }}',
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#registeredUsersCount').text(response.count);
                },
                error: function(xhr, status, error) {
                    console.error("Error updating registered users count:", error);
                }
            });
        }

        // Update dashboard data every 30 seconds
        setInterval(updateDashboardData, 30000);

        // Initial update
        updateDashboardData();
    </script>
</body>
</html>
