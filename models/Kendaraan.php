<?php
class Kendaraan {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ... (fungsi countAll dan getAll tetap sama)
    public function countAll($search = '') {
        $sql = "SELECT COUNT(id_kendaraan) as total FROM kendaraan WHERE deleted_at IS NULL";
        $params = [];
        $types = '';
        if (!empty($search)) {
            $sql .= " AND (jenis LIKE ? OR merk LIKE ? OR no_plat LIKE ?)";
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
    
    public function getAll($search = '', $limit = 10, $offset = 0, $sortBy = 'id_kendaraan', $sortOrder = 'ASC') {
        $allowedSortColumns = ['id_kendaraan', 'jenis', 'merk', 'no_plat', 'status'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_kendaraan';
        }
        if (!in_array(strtoupper($sortOrder), ['ASC', 'DESC'])) {
            $sortOrder = 'ASC';
        }
        $sql = "SELECT * FROM kendaraan WHERE deleted_at IS NULL";
        $params = [];
        $types = '';
        if (!empty($search)) {
            $sql .= " AND (jenis LIKE ? OR merk LIKE ? OR no_plat LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
            $types = 'sss';
        }
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
        $stmt = $this->conn->prepare("SELECT * FROM kendaraan WHERE id_kendaraan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($jenis, $merk, $no_plat, $status) {
        $stmt = $this->conn->prepare("INSERT INTO kendaraan (jenis, merk, no_plat, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $jenis, $merk, $no_plat, $status);
        return $stmt->execute();
    }

    public function update($id, $jenis, $merk, $no_plat, $status) {
        $stmt = $this->conn->prepare("UPDATE kendaraan SET jenis=?, merk=?, no_plat=?, status=? WHERE id_kendaraan=?");
        $stmt->bind_param("ssssi", $jenis, $merk, $no_plat, $status, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("UPDATE kendaraan SET deleted_at = NOW() WHERE id_kendaraan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function getAllDeleted() {
        return $this->conn->query("SELECT * FROM kendaraan WHERE deleted_at IS NOT NULL ORDER BY id_kendaraan ASC");
    }
    
    public function restore($id) {
        $stmt = $this->conn->prepare("UPDATE kendaraan SET deleted_at = NULL WHERE id_kendaraan = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function isPlatExists($no_plat) {
        $stmt = $this->conn->prepare("SELECT id_kendaraan FROM kendaraan WHERE no_plat = ? AND deleted_at IS NULL");
        $stmt->bind_param("s", $no_plat);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // FUNGSI BARU UNTUK VALIDASI EDIT
    public function isPlatExistsForAnotherVehicle($no_plat, $current_id) {
        // Cek apakah no_plat sudah ada, KECUALI untuk ID kendaraan yang sedang diedit
        $stmt = $this->conn->prepare("SELECT id_kendaraan FROM kendaraan WHERE no_plat = ? AND id_kendaraan != ? AND deleted_at IS NULL");
        $stmt->bind_param("si", $no_plat, $current_id);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
?>