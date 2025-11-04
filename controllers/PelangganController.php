<?php
require_once "models/Pelanggan.php";

class PelangganController {
    private $model;

    public function __construct($db) {
        $this->model = new Pelanggan($db);
    }

    public function index() {
        // ... (kode index Anda tetap sama, tidak perlu diubah)
        $limit = 5;
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($currentPage - 1) * $limit;
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id_pelanggan';
        $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
        $totalResults = $this->model->countAll($search);
        $totalPages = ceil($totalResults / $limit);
        $result = $this->model->getAll($search, $limit, $offset, $sortBy, $sortOrder);
        include "views/pelanggan/index.php";
    }

    // UBAH FUNGSI INI
    public function create() {
        $errors = [];
        $data = [
            'nama' => '',
            'alamat' => '',
            'no_hp' => '',
            'no_ktp' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data dari form
            $data['nama'] = trim($_POST['nama']);
            $data['alamat'] = trim($_POST['alamat']);
            $data['no_hp'] = trim($_POST['no_hp']);
            $data['no_ktp'] = trim($_POST['no_ktp']);

            // --- Logika Validasi ---
            if (empty($data['nama'])) {
                $errors['nama'] = 'Nama lengkap tidak boleh kosong.';
            }
            if (empty($data['alamat'])) {
                $errors['alamat'] = 'Alamat tidak boleh kosong.';
            }
            if (empty($data['no_hp'])) {
                $errors['no_hp'] = 'No. Handphone tidak boleh kosong.';
            }
            if (empty($data['no_ktp'])) {
                $errors['no_ktp'] = 'No. KTP tidak boleh kosong.';
            }

            // Jika tidak ada error, simpan data
            if (empty($errors)) {
                $this->model->create($data['nama'], $data['alamat'], $data['no_hp'], $data['no_ktp']);
                header("Location: index.php?page=pelanggan");
                exit(); // Hentikan eksekusi setelah redirect
            }
        }

        // Tampilkan form dengan data dan error (jika ada)
        include "views/pelanggan/create.php";
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->update($id, $_POST['nama'], $_POST['alamat'], $_POST['no_hp'], $_POST['no_ktp']);
            header("Location: index.php?page=pelanggan");
        } else {
            $data = $this->model->getById($id);
            include "views/pelanggan/edit.php";
        }
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?page=pelanggan");
    }

    public function recycleBin() {
        $result = $this->model->getAllDeleted();
        include "views/pelanggan/recycle_bin.php";
    }

    public function restore($id) {
        $this->model->restore($id);
        header("Location: index.php?page=pelanggan&action=recycleBin");
    }
}
?>