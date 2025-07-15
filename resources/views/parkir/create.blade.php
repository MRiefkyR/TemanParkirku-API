<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wastify Dashboard - Create Jadwal Pengambilan Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
        <!-- Include Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-md p-6 rounded mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Jadwal Management</h2>
            </header>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        Jadwal Pengambilan Sampah
                    </h2>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Form to Create Jadwal -->
                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf

                        <!-- Kecamatan and Desa Selection -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <!-- Kecamatan -->
                            <div class="mb-4">
                                <label for="kecamatan" class="block text-gray-700 text-sm font-bold mb-2">Kecamatan:</label>
                                <select name="kecamatan" id="kecamatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('kecamatan') border-red-500 @enderror" required>
                                <option value="" disabled selected>Pilih Kecamatan</option>
                                    <option value="Kecamatan Sleman">Kecamatan Sleman</option>
                                    <option value="Kecamatan Turi">Kecamatan Turi</option>
                                    <option value="Kecamatan Pakem">Kecamatan Pakem</option>
                                    <option value="Kecamatan Tempel">Kecamatan Tempel</option>
                                    <option value="Kecamatan Seyegan">Kecamatan Seyegan</option>
                                    <option value="Kecamatan Prambanan">Kecamatan Prambanan</option>
                                    <option value="Kecamatan Minggir">Kecamatan Minggir</option>
                                    <option value="Kecamatan Ngemplak">Kecamatan Ngemplak</option>
                                    <option value="Kecamatan Mlati">Kecamatan Mlati</option>
                                    <option value="Kecamatan Moyudan">Kecamatan Moyudan</option>
                                    <option value="Kecamatan Ngaglik">Kecamatan Ngaglik</option>
                                    <option value="Kecamatan Cangkringan">Kecamatan Cangkringan</option>
                                    <option value="Kecamatan Kalasan">Kecamatan Kalasan</option>
                                    <option value="Kecamatan Depok">Kecamatan Depok</option>
                                    <option value="Kecamatan Godean">Kecamatan Godean</option>
                                    <option value="Kecamatan Gamping">Kecamatan Gamping</option>
                                    <option value="Kecamatan Berbah">Kecamatan Berbah</option>
                                </select>
                                @error('kecamatan')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Desa -->
                            <div class="mb-4">
                                <label for="desa" class="block text-gray-700 text-sm font-bold mb-2">Desa:</label>
                                <select name="desa" id="desa" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('desa') border-red-500 @enderror" required>
                                    <option value="" disabled selected>Pilih Desa</option>
                                </select>
                                @error('desa')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="hari" class="block text-gray-700 text-sm font-bold mb-2">Hari:</label>
                            <select name="hari" id="hari" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('hari') border-red-500 @enderror" required>
                                <option value="" disabled selected>Pilih Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>

                                <!-- Tambahkan hari lainnya -->
                            </select>
                            @error('hari')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jadwal Selection -->
                        <div class="mb-4">
                            <label for="jadwal" class="block text-gray-700 text-sm font-bold mb-2">Jam:</label>
                            <select name="jadwal" id="jadwal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jadwal') border-red-500 @enderror" required>
                                <option value="" disabled selected>Pilih Jam</option>
                            </select>
                            @error('jadwal')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Tambah Jadwal
                            </button>
                            <a href="{{ route('jadwal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </main>
    </div>

    <!-- JavaScript to Handle Kecamatan and Desa Selection -->
    <script>
    const kecamatanToDesa = {
        "Kecamatan Sleman": ["Tridadi", "Triharjo", "Trimuryo", "Pandowoharjo", "Catuharjo"],
        "Kecamatan Turi": ["Girikerto", "Bangunkerto", "Wonokerto", "Donokerto"],
        "Kecamatan Pakem": ["Purwobinangun", "Candibinangun", "Pakembindangun", "Hargobinangun", "Harjobinangun"],
        "Kecamatan Tempel": ["Banyurejo", "Sumberejo", "Lumbungrejo", "Mororejo", "Tambakrejo", "Pondokrejo", "Merdikorejo"],
        "Kecamatan Seyegan": ["Margoagung", "Magromulyo", "Mrgodadi", "Margoluwih", "Margokaton"],
        "Kecamatan Prambanan": ["Bokoharjo", "Wukirharjo", "Gayamharjo", "Madurejo", "Sumberharjo", "Sambirejo"],
        "Kecamatan Minggir": ["Sendangagung", "Sendangsari", "Sendangarum", "Sendangrejo", "Sendangmulyo"],
        "Kecamatan Ngemplak": ["Widodomartani", "Bimomartani", "Umbulmartani", "Sindumartani", "Wedomartani"],
        "Kecamatan Mlati": ["Tirtoadi", "Sendangadi", "Sinduadi", "Tlogoadi", "Sumberadi"],
        "Kecamatan Moyudan": ["Sumberagung", "Sumberdari", "Sumberarum", "Sumberrahayu"],
        "Kecamatan Ngaglik": ["Donoharjo", "Sukoharjo", "Sardonoharjo", "Minomartani", "Sinduharjo", "Sariharjo"],
        "Kecamatan Cangkringan": ["Argomulyo", "Umbulharjo", "Glagaharjo", "Wukisari", "Kepuharjo"],
        "Kecamatan Kalasan": ["Purwomartani", "Tirtomartani", "Selomartani", "Tamanmartani"],
        "Kecamatan Depok": ["Condongcatur", "Caturtunggal", "Maguwoharjo"],
        "Kecamatan Godean": ["Sidoagung", "Sidorejo", "Sidokarto", "Sidoarum", "Sidomulyo", "Sidomoyo", "Sidoluhur"],
        "Kecamatan Gamping": ["Ambarketawang", "Nogotirto", "Balecatur", "Trihanggo", "Banyuraden"],
        "KecamatanBerbah": ["Tegaltirto", "Jogotirto", "Sendangtirto", "Kalitirto"]
    };

        document.getElementById('kecamatan').addEventListener('change', function() {
            const kecamatan = this.value;
            const desaSelect = document.getElementById('desa');
            desaSelect.innerHTML = '<option value="" disabled selected>Pilih Desa</option>';

            if (kecamatanToDesa[kecamatan]) {
                kecamatanToDesa[kecamatan].forEach(function(desa) {
                    const option = document.createElement('option');
                    option.value = desa;
                    option.textContent = desa;
                    desaSelect.appendChild(option);
                });
            }
        });
    </script>
    <script>
    const hariToJam = {
        "Senin": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"],
        "Selasa": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"],
        "Rabu": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"],
        "Kamis": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"],
        "Jumat": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"],
        "Sabtu": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"],
        "Minggu": ["07:00 - 08:00", "08:00 - 09:00", "09:00 - 10:00","10:00 - 11:00","11:00 - 12:00","12:00 - 13:00","13:00 - 14:00","14:00 - 15:00","15:00 - 16:00","16:00 - 17:00","17:00 - 18:00","18:00 - 19:00"]
    };

    document.getElementById('hari').addEventListener('change', function() {
        const hari = this.value;
        const jadwalSelect = document.getElementById('jadwal');
        jadwalSelect.innerHTML = '<option value="" disabled selected>Pilih Jam</option>';

        if (hariToJam[hari]) {
            hariToJam[hari].forEach(function(jam) {
                const option = document.createElement('option');
                option.value = jam;
                option.textContent = jam;
                jadwalSelect.appendChild(option);
            });
        }
    });
    </script>

</body>
</html>
