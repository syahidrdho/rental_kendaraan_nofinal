<?php
class Dashboard {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSummary() {
        $summary = [];

        // Hitung jumlah kendaraan
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM kendaraan");
        $summary['total_kendaraan'] = $result->fetch_assoc()['total'];

        // Hitung jumlah pelanggan
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM pelanggan");
        $summary['total_pelanggan'] = $result->fetch_assoc()['total'];

        // Hitung jumlah transaksi
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM transaksi_sewa");
        $summary['total_transaksi'] = $result->fetch_assoc()['total'];

        // Hitung total pendapatan
        $result = $this->conn->query("SELECT SUM(jumlah_bayar) AS total FROM pembayaran");
        $summary['total_pendapatan'] = $result->fetch_assoc()['total'] ?? 0;

        return $summary;
    }
}
?>