<?php
class TransaksiSewa {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // FUNGSI BARU: Untuk menghitung total data
    public function countAll($search = '') {
        $sql = "SELECT COUNT(ts.id_sewa) as total
                FROM transaksi_sewa ts
                JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan
                JOIN kendaraan k ON ts.id_kendaraan = k.id_kendaraan";
        
        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " WHERE p.nama LIKE ? OR k.merk LIKE ? OR k.no_plat LIKE ?";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
            $types = 'sss';
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // UBAH FUNGSI INI: Tambahkan parameter paginasi dan sorting
    public function getAll($search = '', $limit = 10, $offset = 0, $sortBy = 'id_sewa', $sortOrder = 'ASC') {
        $allowedSortColumns = ['id_sewa', 'nama_pelanggan', 'merk_kendaraan', 'tgl_sewa', 'tgl_kembali', 'total_biaya'];
        $sortColumnMap = [
            'id_sewa' => 'ts.id_sewa',
            'nama_pelanggan' => 'p.nama',
            'merk_kendaraan' => 'k.merk',
            'tgl_sewa' => 'ts.tgl_sewa',
            'tgl_kembali' => 'ts.tgl_kembali',
            'total_biaya' => 'ts.total_biaya'
        ];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_sewa';
        }
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        $orderByColumn = $sortColumnMap[$sortBy];

        $sql = "SELECT ts.*, p.nama AS nama_pelanggan, k.merk AS merk_kendaraan, k.no_plat
                FROM transaksi_sewa ts
                JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan
                JOIN kendaraan k ON ts.id_kendaraan = k.id_kendaraan";

        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " WHERE p.nama LIKE ? OR k.merk LIKE ? OR k.no_plat LIKE ?";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
            $types = 'sss';
        }

        $sql .= " ORDER BY $orderByColumn $sortOrder LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
             $stmt->bind_param($types, ...$params);
        }
       
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM transaksi_sewa WHERE id_sewa = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($id_pelanggan, $id_kendaraan, $tgl_sewa, $tgl_kembali, $total_biaya) {
        $stmt = $this->conn->prepare("INSERT INTO transaksi_sewa (id_pelanggan, id_kendaraan, tgl_sewa, tgl_kembali, total_biaya) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissd", $id_pelanggan, $id_kendaraan, $tgl_sewa, $tgl_kembali, $total_biaya);
        return $stmt->execute();
    }

    public function update($id, $id_pelanggan, $id_kendaraan, $tgl_sewa, $tgl_kembali, $total_biaya) {
        $stmt = $this->conn->prepare("UPDATE transaksi_sewa SET id_pelanggan=?, id_kendaraan=?, tgl_sewa=?, tgl_kembali=?, total_biaya=? WHERE id_sewa=?");
        $stmt->bind_param("iissdi", $id_pelanggan, $id_kendaraan, $tgl_sewa, $tgl_kembali, $total_biaya, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM transaksi_sewa WHERE id_sewa = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>