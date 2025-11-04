<?php
class Pengembalian {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // FUNGSI BARU: Untuk menghitung total data
    public function countAll($search = '') {
        $sql = "SELECT COUNT(pg.id_pengembalian) as total FROM pengembalian pg
                JOIN transaksi_sewa ts ON pg.id_sewa = ts.id_sewa
                JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan";
        
        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " WHERE p.nama LIKE ?";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm];
            $types = 's';
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // UBAH FUNGSI INI: Tambahkan parameter paginasi dan sorting
    public function getAll($search = '', $limit = 10, $offset = 0, $sortBy = 'id_pengembalian', $sortOrder = 'ASC') {
        $allowedSortColumns = ['id_pengembalian', 'id_sewa', 'nama_pelanggan', 'tgl_dikembalikan', 'denda'];
        $sortColumnMap = [
            'id_pengembalian' => 'pg.id_pengembalian',
            'id_sewa' => 'pg.id_sewa',
            'nama_pelanggan' => 'p.nama',
            'tgl_dikembalikan' => 'pg.tgl_dikembalikan',
            'denda' => 'pg.denda'
        ];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_pengembalian';
        }
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        $orderByColumn = $sortColumnMap[$sortBy];

        $sql = "SELECT pg.*, p.nama AS nama_pelanggan FROM pengembalian pg
                JOIN transaksi_sewa ts ON pg.id_sewa = ts.id_sewa
                JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan";

        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " WHERE p.nama LIKE ?";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm];
            $types = 's';
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
        $stmt = $this->conn->prepare("SELECT * FROM pengembalian WHERE id_pengembalian = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($id_sewa, $tgl_dikembalikan, $denda) {
        $stmt = $this->conn->prepare("INSERT INTO pengembalian (id_sewa, tgl_dikembalikan, denda) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $id_sewa, $tgl_dikembalikan, $denda);
        return $stmt->execute();
    }

    public function update($id, $id_sewa, $tgl_dikembalikan, $denda) {
        $stmt = $this->conn->prepare("UPDATE pengembalian SET id_sewa=?, tgl_dikembalikan=?, denda=? WHERE id_pengembalian=?");
        $stmt->bind_param("isdi", $id_sewa, $tgl_dikembalikan, $denda, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM pengembalian WHERE id_pengembalian = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>