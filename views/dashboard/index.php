<?php include 'header.php'; ?>

<div class="mb-8 text-center">
    <h1 class="text-4xl font-extrabold text-gray-800">Dashboard Ringkasan</h1>
    <p class="text-gray-500 mt-2">Selamat datang! Berikut adalah ringkasan data rental Anda saat ini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
    
    <div class="bg-gradient-to-br from-white to-gray-100 rounded-xl shadow-xl p-6 border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-105">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-20 h-20 flex items-center justify-center rounded-full bg-gradient-to-tr from-blue-500 to-blue-400 text-white shadow-lg">
                <span class="material-symbols-outlined text-4xl">
                 directions_car
                </span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Total Kendaraan</p>
                <p class="text-3xl font-bold text-gray-900"><?= $summary['total_kendaraan'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-white to-gray-100 rounded-xl shadow-xl p-6 border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-105">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-4 rounded-full bg-gradient-to-tr from-green-500 to-green-400 text-white shadow-lg">
                 <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Total Pelanggan</p>
                <p class="text-3xl font-bold text-gray-900"><?= $summary['total_pelanggan'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-white to-gray-100 rounded-xl shadow-xl p-6 border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-105">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-4 rounded-full bg-gradient-to-tr from-yellow-500 to-yellow-400 text-white shadow-lg">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                <p class="text-3xl font-bold text-gray-900"><?= $summary['total_transaksi'] ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-white to-gray-100 rounded-xl shadow-xl p-6 border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-105">
        <div class="flex items-center">
            <div class="flex-shrink-0 p-4 rounded-full bg-gradient-to-tr from-red-500 to-red-400 text-white shadow-lg">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
                <p class="text-3xl font-bold text-gray-900">Rp <?= number_format($summary['total_pendapatan'], 0, ',', '.') ?></p>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
