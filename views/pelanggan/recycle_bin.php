<?php include 'header.php'; ?>

<h2 class="text-3xl font-bold text-gray-800 mb-6">Recycle Bin - Data Pelanggan Terhapus</h2>
<a href="index.php?page=pelanggan" class="text-blue-500 hover:underline mb-4 inline-block">
    &larr; Kembali ke Daftar Pelanggan
</a>

<div class="bg-white rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-gray-800 text-white">
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Alamat</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">No. HP</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Dihapus</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Variabel $result didapat dari PelangganController, method recycleBin()
            while($row = $result->fetch_assoc()): 
            ?>
            <tr class="hover:bg-gray-100">
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['id_pelanggan']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['alamat']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['no_hp']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['deleted_at']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <a href="index.php?page=pelanggan&action=restore&id=<?= $row['id_pelanggan']; ?>" onclick="return confirm('Anda yakin ingin mengembalikan data ini?')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs">
                        Restore
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>