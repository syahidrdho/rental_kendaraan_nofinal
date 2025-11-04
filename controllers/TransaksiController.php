<?php
require_once "models/TransaksiSewa.php";
require_once "models/Pelanggan.php";
require_once "models/Kendaraan.php";

class TransaksiController {
    private $transaksiModel;
    private $pelangganModel;
    private $kendaraanModel;

    public function __construct($db) {
        $this->transaksiModel = new TransaksiSewa($db);
        $this->pelangganModel = new Pelanggan($db);
        $this->kendaraanModel = new Kendaraan($db);
    }

    // UBAH FUNGSI INI
    public function index() {
        // Pengaturan Paginasi
        $limit = 5;
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($currentPage - 1) * $limit;

        // Pengaturan Pencarian
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        
        // Pengaturan Penyortiran
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id_sewa';
        $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

        // Ambil total data
        $totalResults = $this->transaksiModel->countAll($search);
        $totalPages = ceil($totalResults / $limit);
        
        // Panggil method getAll dengan semua parameter
        $result = $this->transaksiModel->getAll($search, $limit, $offset, $sortBy, $sortOrder);
        
        // Kirim semua data yang dibutuhkan ke view
        include "views/transaksi/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->transaksiModel->create($_POST['id_pelanggan'], $_POST['id_kendaraan'], $_POST['tgl_sewa'], $_POST['tgl_kembali'], $_POST['total_biaya']);
            header("Location: index.php?page=transaksi");
        } else {
            // Kita tidak perlu paginasi atau sorting di sini
            $pelanggan = $this->pelangganModel->getAll('', 999);
            $kendaraan = $this->kendaraanModel->getAll('', 999);
            include "views/transaksi/create.php";
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->transaksiModel->update($id, $_POST['id_pelanggan'], $_POST['id_kendaraan'], $_POST['tgl_sewa'], $_POST['tgl_kembali'], $_POST['total_biaya']);
            header("Location: index.php?page=transaksi");
        } else {
            $data = $this->transaksiModel->getById($id);
            // Kita tidak perlu paginasi atau sorting di sini
            $pelanggan = $this->pelangganModel->getAll('', 999);
            $kendaraan = $this->kendaraanModel->getAll('', 999);
            include "views/transaksi/edit.php";
        }
    }

    public function delete($id) {
        $this->transaksiModel->delete($id);
        header("Location: index.php?page=transaksi");
    }
}
?>