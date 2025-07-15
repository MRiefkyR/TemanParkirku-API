<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - Wastify</title>
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
                <h2 class="text-xl font-semibold">Edit Jadwal</h2>
            </header>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST" x-data="{
                        kecamatanToDesa: {
                            'Sleman': ['Tridadi', 'Triharjo', 'Trimuryo', 'Pandowoharjo', 'Catuharjo'],
                            'Turi': ['Girikerto', 'Bangunkerto', 'Wonokerto', 'Donokerto'],
                            'Pakem': ['Purwobinangun', 'Candibinangun', 'Pakembindangun', 'Hargobinangun', 'Harjobinangun'],
                            'Tempel': ['Banyurejo', 'Sumberejo', 'Lumbungrejo', 'Mororejo', 'Tambakrejo', 'Pondokrejo', 'Merdikorejo'],
                            'Seyegan': ['Margoagung', 'Magromulyo', 'Mrgodadi', 'Margoluwih', 'Margokaton'],
                            'Prambanan': ['Bokoharjo', 'Wukirharjo', 'Gayamharjo', 'Madurejo', 'Sumberharjo', 'Sambirejo'],
                            'Minggir': ['Sendangagung', 'Sendangsari', 'Sendangarum', 'Sendangrejo', 'Sendangmulyo'],
                            'Ngemplak': ['Widodomartani', 'Bimomartani', 'Umbulmartani', 'Sindumartani', 'Wedomartani'],
                            'Mlati': ['Tirtoadi', 'Sendangadi', 'Sinduadi', 'Tlogoadi', 'Sumberadi'],
                            'Moyudan': ['Sumberagung', 'Sumberdari', 'Sumberarum', 'Sumberrahayu'],
                            'Ngaglik': ['Donoharjo', 'Sukoharjo', 'Sardonoharjo', 'Minomartani', 'Sinduharjo', 'Sariharjo'],
                            'Cangkringan': ['Argomulyo', 'Umbulharjo', 'Glagaharjo', 'Wukisari', 'Kepuharjo'],
                            'Kalasan': ['Purwomartani', 'Tirtomartani', 'Selomartani', 'Tamanmartani'],
                            'Depok': ['Condongcatur', 'Caturtunggal', 'Maguwoharjo'],
                            'Godean': ['Sidoagung', 'Sidorejo', 'Sidokarto', 'Sidoarum', 'Sidomulyo', 'Sidomoyo', 'Sidoluhur'],
                            'Gamping': ['Ambarketawang', 'Nogotirto', 'Balecatur', 'Trihanggo', 'Banyuraden'],
                            'Berbah': ['Tegaltirto', 'Jogotirto', 'Sendangtirto', 'Kalitirto']
                        },
                        selectedKecamatan: '',
                        selectedDesa: '',
                        loadingDesa: false
                    }">

                        @csrf
                        @method('PUT')

                        

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <!-- Kecamatan -->
                            <div class="mb-4">
                                <label for="kecamatan" class="block text-gray-700 text-sm font-bold mb-2">Kecamatan:</label>
                                <select name="kecamatan" id="kecamatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('kecamatan') border-red-500 @enderror" required>
                                <option value="" disabled selected>Pilih Kecamatan</option>
                                    <option value="Sleman">Kecamatan Sleman</option>
                                    <option value="Turi">Kecamatan Turi</option>
                                    <option value="Pakem">Kecamatan Pakem</option>
                                    <option value="Tempel">Kecamatan Tempel</option>
                                    <option value="Seyegan">Kecamatan Seyegan</option>
                                    <option value="Prambanan">Kecamatan Prambanan</option>
                                    <option value="Minggir">Kecamatan Minggir</option>
                                    <option value="Ngemplak">Kecamatan Ngemplak</option>
                                    <option value="Mlati">Kecamatan Mlati</option>
                                    <option value="Moyudan">Kecamatan Moyudan</option>
                                    <option value="Ngaglik">Kecamatan Ngaglik</option>
                                    <option value="Cangkringan">Kecamatan Cangkringan</option>
                                    <option value="Kalasan">Kecamatan Kalasan</option>
                                    <option value="Depok">Kecamatan Depok</option>
                                    <option value="Godean">Kecamatan Godean</option>
                                    <option value="Gamping">Kecamatan Gamping</option>
                                    <option value="Berbah">Kecamatan Berbah</option>
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

                        <!-- RT/RW Field -->
                        <div class="mb-4">
                            <label for="rt_rw" class="block text-sm font-medium text-gray-700">RT/RW</label>
                            <input type="text" name="rt_rw" id="rt_rw" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $jadwal->rt_rw }}" required>
                        </div>

                        <!-- Alamat Lengkap Field -->
                        <div class="mb-4">
                            <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>{{ $jadwal->alamat_lengkap }}</textarea>
                        </div>

                        <!-- Jadwal Field -->
                        <div class="mb-4">
                            <label for="jadwal" class="block text-sm font-medium text-gray-700">Jadwal</label>
                            <select name="jadwal" id="jadwal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('jadwal') border-red-500 @enderror" required>
                                <option value="" disabled selected>Pilih Jadwal</option>
                                <option value="Rabu 14.00 - 16.00" {{ old('jadwal', $jadwal->jadwal) == 'Rabu 14.00 - 16.00' ? 'selected' : '' }}>Rabu 14.00 - 16.00</option>
                                <option value="Selasa 16.00 - 18.00" {{ old('jadwal', $jadwal->jadwal) == 'Selasa 16.00 - 18.00' ? 'selected' : '' }}>Selasa 16.00 - 18.00</option>
                                <option value="Kamis 12.00 - 14.00" {{ old('jadwal', $jadwal->jadwal) == 'Kamis 12.00 - 14.00' ? 'selected' : '' }}>Kamis 12.00 - 14.00</option>
                            </select>
                            @error('jadwal')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Jadwal
                            </button>
                            <a href="{{ route('jadwal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

</body>
<script>
    const kecamatanToDesa = {
        "Sleman": ["Tridadi", "Triharjo", "Trimuryo", "Pandowoharjo", "Catuharjo"],
        "Turi": ["Girikerto", "Bangunkerto", "Wonokerto", "Donokerto"],
        "Pakem": ["Purwobinangun", "Candibinangun", "Pakembindangun", "Hargobinangun", "Harjobinangun"],
        "Tempel": ["Banyurejo", "Sumberejo", "Lumbungrejo", "Mororejo", "Tambakrejo", "Pondokrejo", "Merdikorejo"],
        "Seyegan": ["Margoagung", "Magromulyo", "Mrgodadi", "Margoluwih", "Margokaton"],
        "Prambanan": ["Bokoharjo", "Wukirharjo", "Gayamharjo", "Madurejo", "Sumberharjo", "Sambirejo"],
        "Minggir": ["Sendangagung", "Sendangsari", "Sendangarum", "Sendangrejo", "Sendangmulyo"],
        "Ngemplak": ["Widodomartani", "Bimomartani", "Umbulmartani", "Sindumartani", "Wedomartani"],
        "Mlati": ["Tirtoadi", "Sendangadi", "Sinduadi", "Tlogoadi", "Sumberadi"],
        "Moyudan": ["Sumberagung", "Sumberdari", "Sumberarum", "Sumberrahayu"],
        "Ngaglik": ["Donoharjo", "Sukoharjo", "Sardonoharjo", "Minomartani", "Sinduharjo", "Sariharjo"],
        "Cangkringan": ["Argomulyo", "Umbulharjo", "Glagaharjo", "Wukisari", "Kepuharjo"],
        "Kalasan": ["Purwomartani", "Tirtomartani", "Selomartani", "Tamanmartani"],
        "Depok": ["Condongcatur", "Caturtunggal", "Maguwoharjo"],
        "Godean": ["Sidoagung", "Sidorejo", "Sidokarto", "Sidoarum", "Sidomulyo", "Sidomoyo", "Sidoluhur"],
        "Gamping": ["Ambarketawang", "Nogotirto", "Balecatur", "Trihanggo", "Banyuraden"],
        "Berbah": ["Tegaltirto", "Jogotirto", "Sendangtirto", "Kalitirto"]
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
</html>
