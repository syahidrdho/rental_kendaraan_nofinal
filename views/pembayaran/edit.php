<?php include 'header.php'; ?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Pembayaran</h1>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form method="POST">
        <div class="mb-4">
            <label for="id_sewa" class="block text-gray-700 text-sm font-bold mb-2">Transaksi Sewa</label>
            <select name="id_sewa" id="id_sewa" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Transaksi --</option>
                <?php while($t = $transaksi->fetch_assoc()): ?>
                    <option value="<?= $t['id_sewa'] ?>" <?= $data['id_sewa'] == $t['id_sewa'] ? 'selected' : '' ?>>
                         #<?= htmlspecialchars($t['id_sewa']) ?> - <?= htmlspecialchars($t['nama_pelanggan']) ?> (<?= htmlspecialchars($t['merk_kendaraan']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="tgl_bayar" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Bayar</label>
            <input type="date" id="tgl_bayar" name="tgl_bayar" value="<?= htmlspecialchars($data['tgl_bayar']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="jumlah_bayar" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Bayar</label>
            <input type="number" step="1000" id="jumlah_bayar" name="jumlah_bayar" value="<?= htmlspecialchars($data['jumlah_bayar']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="metode_bayar" class="block text-gray-700 text-sm font-bold mb-2">Metode Bayar</label>
            <select name="metode_bayar" id="metode_bayar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="tunai" <?= $data['metode_bayar'] == 'tunai' ? 'selected' : '' ?>>Tunai</option>
                <option value="kartu" <?= $data['metode_bayar'] == 'kartu' ? 'selected' : '' ?>>Kartu</option>
                <option value="transfer" <?= $data['metode_bayar'] == 'transfer' ? 'selected' : '' ?>>Transfer</option>
            </select>
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>