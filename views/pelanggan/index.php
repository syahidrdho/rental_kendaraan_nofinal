<?php
// Helper function to create sorting links
function createSortLink($column, $text, $currentSortBy, $currentSortOrder, $currentSearch) {
    $nextSortOrder = ($currentSortBy == $column && $currentSortOrder == 'ASC') ? 'DESC' : 'ASC';
    $url = "index.php?page=pelanggan&sort_by=$column&sort_order=$nextSortOrder&q=" . urlencode($currentSearch);
    $indicator = '';
    if ($currentSortBy == $column) {
        $indicator = ($currentSortOrder == 'ASC') ? ' &#9650;' : ' &#9660;'; // Up/Down arrows
    }
    return "<a href=\"$url\" class=\"hover:text-gray-300\">$text$indicator</a>";
}
?>

<?php include 'header.php'; ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Manajemen Pelanggan</h1>
    
    <div class="flex space-x-4">
        <a href="index.php?page=pelanggan&action=recycleBin" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
            Recycle Bin
        </a>
        <a href="index.php?page=pelanggan&action=create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
            Tambah Pelanggan
        </a>
    </div>
</div>

<div class="mb-6 bg-white p-4 rounded-lg shadow-md">
    <form action="index.php" method="GET" class="flex items-center space-x-4">
        <input type="hidden" name="page" value="pelanggan">
        <input 
            type="text" 
            name="q" 
            placeholder="Cari nama, alamat, no. hp, atau no. ktp..." 
            class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="<?= isset($search) ? htmlspecialchars($search) : '' ?>"
        >
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
            Cari
        </button>
        <a href="index.php?page=pelanggan" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
            Reset
        </a>
    </form>
</div>

<div class="bg-white rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-gray-800 text-white">
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                    <?= createSortLink('id_pelanggan', 'ID', $sortBy, $sortOrder, $search) ?>
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                    <?= createSortLink('nama', 'Nama', $sortBy, $sortOrder, $search) ?>
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                    <?= createSortLink('alamat', 'Alamat', $sortBy, $sortOrder, $search) ?>
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                    <?= createSortLink('no_hp', 'No. HP', $sortBy, $sortOrder, $search) ?>
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">
                    <?= createSortLink('no_ktp', 'No. KTP', $sortBy, $sortOrder, $search) ?>
                </th>
                <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="hover:bg-gray-100">
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['id_pelanggan']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['alamat']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['no_hp']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm"><?= htmlspecialchars($row['no_ktp']) ?></td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <a href="index.php?page=pelanggan&action=edit&id=<?= $row['id_pelanggan'] ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-xs">Edit</a>
                    <a href="index.php?page=pelanggan&action=delete&id=<?= $row['id_pelanggan'] ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="mt-6 flex justify-center">
    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
        <?php if($totalPages > 1): ?>
            <?php $paginationUrl = "index.php?page=pelanggan&q=" . urlencode($search) . "&sort_by=$sortBy&sort_order=$sortOrder"; ?>
            
            <a href="<?= $paginationUrl ?>&p=<?= $currentPage - 1 ?>" 
               class="<?= $currentPage <= 1 ? 'pointer-events-none text-gray-400' : '' ?> relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                &laquo; Previous
            </a>

            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= $paginationUrl ?>&p=<?= $i ?>" 
                   class="<?= $i == $currentPage ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?> relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <a href="<?= $paginationUrl ?>&p=<?= $currentPage + 1 ?>" 
               class="<?= $currentPage >= $totalPages ? 'pointer-events-none text-gray-400' : '' ?> relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                Next &raquo;
            </a>
        <?php endif; ?>
    </nav>
</div>

<?php include 'footer.php'; ?>