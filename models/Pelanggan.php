<?php
class Pelanggan {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function countAll($search = '') {
        $sql = "SELECT COUNT(id_pelanggan) as total FROM pelanggan WHERE deleted_at IS NULL";
        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " AND (nama LIKE ? OR alamat LIKE ? OR no_hp LIKE ? OR no_ktp LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
            $types = 'ssss';
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // UBAH FUNGSI INI: Tambahkan parameter sort_by dan sort_order
    public function getAll($search = '', $limit = 10, $offset = 0, $sortBy = 'id_pelanggan', $sortOrder = 'ASC') {
        // Whitelist untuk kolom yang diizinkan untuk disortir demi keamanan
        $allowedSortColumns = ['id_pelanggan', 'nama', 'alamat', 'no_hp', 'no_ktp'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_pelanggan'; // Default jika kolom tidak valid
        }
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC'; // Default jika urutan tidak valid
        }

        $sql = "SELECT * FROM pelanggan WHERE deleted_at IS NULL";
        $params = [];
        $types = '';

        if (!empty($search)) {
            $sql .= " AND (nama LIKE ? OR alamat LIKE ? OR no_hp LIKE ? OR no_ktp LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm, $searchTerm, $searchTerm];
            $types = 'ssss';
        }

        // Ganti ORDER BY statis menjadi dinamis
        $sql .= " ORDER BY $sortBy $sortOrder LIMIT ? OFFSET ?";
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
        $stmt = $this->conn->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($nama, $alamat, $no_hp, $no_ktp) {
        $stmt = $this->conn->prepare("INSERT INTO pelanggan (nama, alamat, no_hp, no_ktp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $alamat, $no_hp, $no_ktp);
        return $stmt->execute();
    }

    public function update($id, $nama, $alamat, $no_hp, $no_ktp) {
        $stmt = $this->conn->prepare("UPDATE pelanggan SET nama=?, alamat=?, no_hp=?, no_ktp=? WHERE id_pelanggan=?");
        $stmt->bind_param("ssssi", $nama, $alamat, $no_hp, $no_ktp, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("UPDATE pelanggan SET deleted_at = NOW() WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getAllDeleted() {
        return $this->conn->query("SELECT * FROM pelanggan WHERE deleted_at IS NOT NULL ORDER BY id_pelanggan ASC");
    }

    public function restore($id) {
        $stmt = $this->conn->prepare("UPDATE pelanggan SET deleted_at = NULL WHERE id_pelanggan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>