<?php include 'header.php'; ?>

<h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Data Pelanggan</h1>

<div class="bg-white p-8 rounded-lg shadow-md">
    <form method="POST">
        <div class="mb-4">
            <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
        <div class="mb-4">
            <label for="no_hp" class="block text-gray-700 text-sm font-bold mb-2">No. Handphone</label>
            <input type="text" id="no_hp" name="no_hp" value="<?= htmlspecialchars($data['no_hp']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="no_ktp" class="block text-gray-700 text-sm font-bold mb-2">No. KTP</label>
            <input type="text" id="no_ktp" name="no_ktp" value="<?= htmlspecialchars($data['no_ktp']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="flex items-center justify-start">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update
            </button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>