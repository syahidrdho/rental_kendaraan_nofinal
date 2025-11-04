<?php include 'header.php'; ?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Transaksi Baru</h1>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form method="POST">
        <div class="mb-4">
            <label for="id_pelanggan" class="block text-gray-700 text-sm font-bold mb-2">Pelanggan</label>
            <select name="id_pelanggan" id="id_pelanggan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php while($p = $pelanggan->fetch_assoc()): ?>
                    <option value="<?= $p['id_pelanggan'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="id_kendaraan" class="block text-gray-700 text-sm font-bold mb-2">Kendaraan</label>
            <select name="id_kendaraan" id="id_kendaraan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Kendaraan --</option>
                <?php while($k = $kendaraan->fetch_assoc()): ?>
                    <option value="<?= $k['id_kendaraan'] ?>"><?= htmlspecialchars($k['merk']) ?> (<?= htmlspecialchars($k['no_plat']) ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="tgl_sewa" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Sewa</label>
                <input type="date" id="tgl_sewa" name="tgl_sewa" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="tgl_kembali" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Kembali</label>
                <input type="date" id="tgl_kembali" name="tgl_kembali" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
        </div>
        <div class="mb-4">
            <label for="total_biaya" class="block text-gray-700 text-sm font-bold mb-2">Total Biaya (Rp)</label>
            <input type="number" step="1000" id="total_biaya" name="total_biaya" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>