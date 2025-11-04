<?php
require_once "models/Pengembalian.php";
require_once "models/TransaksiSewa.php";

class PengembalianController {
    private $pengembalianModel;
    private $transaksiModel;

    public function __construct($db) {
        $this->pengembalianModel = new Pengembalian($db);
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
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id_pengembalian';
        $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

        // Ambil total data
        $totalResults = $this->pengembalianModel->countAll($search);
        $totalPages = ceil($totalResults / $limit);
        
        // Panggil method getAll dengan semua parameter
        $result = $this->pengembalianModel->getAll($search, $limit, $offset, $sortBy, $sortOrder);
        
        // Kirim semua data yang dibutuhkan ke view
        include "views/pengembalian/index.php";
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pengembalianModel->create($_POST['id_sewa'], $_POST['tgl_dikembalikan'], $_POST['denda']);
            header("Location: index.php?page=pengembalian");
        } else {
            // Ambil semua transaksi untuk dropdown, set limit tinggi
            $transaksi = $this->transaksiModel->getAll('', 999);
            include "views/pengembalian/create.php";
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pengembalianModel->update($id, $_POST['id_sewa'], $_POST['tgl_dikembalikan'], $_POST['denda']);
            header("Location: index.php?page=pengembalian");
        } else {
            $data = $this->pengembalianModel->getById($id);
            // Ambil semua transaksi untuk dropdown, set limit tinggi
            $transaksi = $this->transaksiModel->getAll('', 999);
            include "views/pengembalian/edit.php";
        }
    }

    public function delete($id) {
        $this->pengembalianModel->delete($id);
        header("Location: index.php?page=pengembalian");
    }
}
?>