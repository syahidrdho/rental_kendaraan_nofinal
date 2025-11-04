<?php
require_once "models/Pembayaran.php";
require_once "models/TransaksiSewa.php";

class PembayaranController {
    private $pembayaranModel;
    private $transaksiModel;

    public function __construct($db) {
        $this->pembayaranModel = new Pembayaran($db);
        $this->transaksiModel = new TransaksiSewa($db);
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
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id_pembayaran';
        $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

        // Ambil total data
        $totalResults = $this->pembayaranModel->countAll($search);
        $totalPages = ceil($totalResults / $limit);
        
        // Panggil method getAll dengan semua parameter
        $result = $this->pembayaranModel->getAll($search, $limit, $offset, $sortBy, $sortOrder);
        
        // Kirim semua data yang dibutuhkan ke view
        include "views/pembayaran/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pembayaranModel->create($_POST['id_sewa'], $_POST['jumlah_bayar'], $_POST['tgl_bayar'], $_POST['metode_bayar']);
            header("Location: index.php?page=pembayaran");
        } else {
            $transaksi = $this->transaksiModel->getAll('', 999);
            include "views/pembayaran/create.php";
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pembayaranModel->update($id, $_POST['id_sewa'], $_POST['jumlah_bayar'], $_POST['tgl_bayar'], $_POST['metode_bayar']);
            header("Location: index.php?page=pembayaran");
        } else {
            $data = $this->pembayaranModel->getById($id);
            $transaksi = $this->transaksiModel->getAll('', 999);
            include "views/pembayaran/edit.php";
        }
    }

    public function delete($id) {
        $this->pembayaranModel->delete($id);
        header("Location: index.php?page=pembayaran");
    }
}
?>