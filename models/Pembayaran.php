<?php
class Pembayaran {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // FUNGSI BARU: Untuk menghitung total data
    public function countAll($search = '') {
        $sql = "SELECT COUNT(pb.id_pembayaran) as total FROM pembayaran pb
                JOIN transaksi_sewa ts ON pb.id_sewa = ts.id_sewa
                JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan";
        
        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " WHERE p.nama LIKE ? OR pb.metode_bayar LIKE ?";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm];
            $types = 'ss';
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // UBAH FUNGSI INI: Tambahkan parameter paginasi dan sorting
    public function getAll($search = '', $limit = 10, $offset = 0, $sortBy = 'id_pembayaran', $sortOrder = 'ASC') {
        $allowedSortColumns = ['id_pembayaran', 'id_sewa', 'nama_pelanggan', 'tgl_bayar', 'jumlah_bayar', 'metode_bayar'];
        $sortColumnMap = [
            'id_pembayaran' => 'pb.id_pembayaran',
            'id_sewa' => 'pb.id_sewa',
            'nama_pelanggan' => 'p.nama',
            'tgl_bayar' => 'pb.tgl_bayar',
            'jumlah_bayar' => 'pb.jumlah_bayar',
            'metode_bayar' => 'pb.metode_bayar'
        ];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_pembayaran';
        }
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        $orderByColumn = $sortColumnMap[$sortBy];

        $sql = "SELECT pb.*, p.nama AS nama_pelanggan FROM pembayaran pb
                JOIN transaksi_sewa ts ON pb.id_sewa = ts.id_sewa
                JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan";

        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " WHERE p.nama LIKE ? OR pb.metode_bayar LIKE ?";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm];
            $types = 'ss';
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
        $stmt = $this->conn->prepare("SELECT * FROM pembayaran WHERE id_pembayaran = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($id_sewa, $jumlah_bayar, $tgl_bayar, $metode_bayar) {
        $stmt = $this->conn->prepare("INSERT INTO pembayaran (id_sewa, jumlah_bayar, tgl_bayar, metode_bayar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $id_sewa, $jumlah_bayar, $tgl_bayar, $metode_bayar);
        return $stmt->execute();
    }

    public function update($id, $id_sewa, $jumlah_bayar, $tgl_bayar, $metode_bayar) {
        $stmt = $this->conn->prepare("UPDATE pembayaran SET id_sewa=?, jumlah_bayar=?, tgl_bayar=?, metode_bayar=? WHERE id_pembayaran=?");
        $stmt->bind_param("idssi", $id_sewa, $jumlah_bayar, $tgl_bayar, $metode_bayar, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM pembayaran WHERE id_pembayaran = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>