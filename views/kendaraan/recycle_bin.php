<h2>Recycle Bin - Data Kendaraan Terhapus</h2>
<a href="index.php?page=kendaraan">Kembali ke Daftar Kendaraan</a>
<br><br>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Merk</th>
            <th>No Plat</th>
            <th>Status</th>
            <th>Tanggal Dihapus</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        // Variabel $result didapat dari KendaraanController, method recycleBin()
        while($row = $result->fetch_assoc()): 
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['jenis']; ?></td>
            <td><?php echo $row['merk']; ?></td>
            <td><?php echo $row['no_plat']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['deleted_at']; ?></td>
            <td>
                <a href="index.php?page=kendaraan&action=restore&id=<?php echo $row['id_kendaraan']; ?>" onclick="return confirm('Anda yakin ingin mengembalikan data ini?')">Restore</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>