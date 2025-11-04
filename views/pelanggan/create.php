<?php include 'header.php'; ?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Pelanggan Baru</h1>

<div class="bg-white p-8 rounded-lg shadow-md max-w-lg mx-auto">
    <form action="index.php?page=pelanggan&action=create" method="POST">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input 
                type="text" 
                id="nama" 
                name="nama" 
                class="shadow appearance-none border <?= isset($errors['nama']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="<?= htmlspecialchars($data['nama'] ?? '') ?>"
            >
            <?php if (isset($errors['nama'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['nama'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <textarea 
                id="alamat" 
                name="alamat" 
                rows="3" 
                class="shadow appearance-none border <?= isset($errors['alamat']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            ><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>
            <?php if (isset($errors['alamat'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['alamat'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No. Handphone</label>
            <input 
                type="text" 
                id="no_hp" 
                name="no_hp" 
                class="shadow appearance-none border <?= isset($errors['no_hp']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="<?= htmlspecialchars($data['no_hp'] ?? '') ?>"
            >
            <?php if (isset($errors['no_hp'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['no_hp'] ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="no_ktp" class="block text-gray-700 text-sm font-bold mb-2">No. KTP</label>
            <input 
                type="text" 
                id="no_ktp" 
                name="no_ktp" 
                class="shadow appearance-none border <?= isset($errors['no_ktp']) ? 'border-red-500' : '' ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="<?= htmlspecialchars($data['no_ktp'] ?? '') ?>"
            >
            <?php if (isset($errors['no_ktp'])): ?>
                <p class="text-red-500 text-xs italic mt-2"><?= $errors['no_ktp'] ?></p>
            <?php endif; ?>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan
            </button>
            <a href="index.php?page=pelanggan" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Batal
            </a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>