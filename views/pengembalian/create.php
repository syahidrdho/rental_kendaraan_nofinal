<?php include 'header.php'; ?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Data Pengembalian</h1>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form method="POST">
        <div class="mb-4">
            <label for="id_sewa" class="block text-gray-700 text-sm font-bold mb-2">Transaksi Sewa</label>
            <select name="id_sewa" id="id_sewa" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Transaksi --</option>
                <?php while($t = $transaksi->fetch_assoc()): ?>
                    <option value="<?= $t['id_sewa'] ?>">
                        #<?= htmlspecialchars($t['id_sewa']) ?> - <?= htmlspecialchars($t['nama_pelanggan']) ?> (<?= htmlspecialchars($t['merk_kendaraan']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="tgl_dikembalikan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Dikembalikan</label>
            <input type="date" id="tgl_dikembalikan" name="tgl_dikembalikan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="denda" class="block text-gray-700 text-sm font-bold mb-2">Denda (Rp)</label>
            <input type="number" step="1000" id="denda" name="denda" value="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan
            </button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>