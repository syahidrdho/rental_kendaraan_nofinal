<?php include 'header.php'; ?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Kendaraan Baru</h1>

<div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
    <form action="index.php?page=kendaraan&action=create" method="POST">
        <div class="mb-4">
            <label for="jenis" class="block text-gray-700 text-sm font-bold mb-2">Jenis Kendaraan</label>
            <input 
                type="text" 
                id="jenis" 
                name="jenis" 
                class="shadow appearance-none border <?= isset($errors['jenis']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="<?= htmlspecialchars($data['jenis'] ?? '') ?>"
            >
            <?php if (isset($errors['jenis'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['jenis'] ?></p>
            <?php endif; ?>
        </div>
        
        <div class="mb-4">
            <label for="merk" class="block text-gray-700 text-sm font-bold mb-2">Merk</label>
            <input 
                type="text" 
                id="merk" 
                name="merk" 
                class="shadow appearance-none border <?= isset($errors['merk']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="<?= htmlspecialchars($data['merk'] ?? '') ?>"
            >
            <?php if (isset($errors['merk'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['merk'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="no_plat" class="block text-gray-700 text-sm font-bold mb-2">No. Plat</label>
            <input 
                type="text" 
                id="no_plat" 
                name="no_plat" 
                class="shadow appearance-none border <?= isset($errors['no_plat']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="<?= htmlspecialchars($data['no_plat'] ?? '') ?>"
            >
            <?php if (isset($errors['no_plat'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['no_plat'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="tersedia" <?= ($data['status'] ?? 'tersedia') == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="disewa" <?= ($data['status'] ?? '') == 'disewa' ? 'selected' : '' ?>>Disewa</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan
            </button>
            <a href="index.php?page=kendaraan" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Batal
            </a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>