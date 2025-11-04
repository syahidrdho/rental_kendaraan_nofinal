<?php
require_once "models/Kendaraan.php";

class KendaraanController {
    private $model;

    public function __construct($db) {
        $this->model = new Kendaraan($db);
    }

    public function index() {
        // ... (kode index Anda tetap sama)
        $limit = 5;
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($currentPage - 1) * $limit;
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        $sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id_kendaraan';
        $sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
        $totalResults = $this->model->countAll($search);
        $totalPages = ceil($totalResults / $limit);
        $result = $this->model->getAll($search, $limit, $offset, $sortBy, $sortOrder);
        include "views/kendaraan/index.php";
    }

    public function create() {
        // ... (kode create Anda tetap sama)
        $errors = [];
        $data = ['jenis' => '','merk' => '','no_plat' => '','status' => 'tersedia'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['jenis'] = trim($_POST['jenis']);
            $data['merk'] = trim($_POST['merk']);
            $data['no_plat'] = trim($_POST['no_plat']);
            $data['status'] = $_POST['status'];
            if (empty($data['jenis'])) { $errors['jenis'] = 'Jenis kendaraan tidak boleh kosong.'; }
            if (empty($data['merk'])) { $errors['merk'] = 'Merk tidak boleh kosong.'; }
            if (empty($data['no_plat'])) { $errors['no_plat'] = 'No. Plat tidak boleh kosong.';
            } elseif ($this->model->isPlatExists($data['no_plat'])) {
                $errors['no_plat'] = 'No. Plat ini sudah terdaftar. Harap gunakan yang lain.';
            }
            if (empty($errors)) {
                $this->model->create($data['jenis'], $data['merk'], $data['no_plat'], $data['status']);
                header("Location: index.php?page=kendaraan");
                exit();
            }
        }
        include "views/kendaraan/create.php";
    }

    // UBAH FUNGSI INI
    public function edit($id) {
        $errors = [];
        // Ambil data awal dari database
        $data = $this->model->getById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Timpa data dengan yang disubmit pengguna
            $data['jenis'] = trim($_POST['jenis']);
            $data['merk'] = trim($_POST['merk']);
            $data['no_plat'] = trim($_POST['no_plat']);
            $data['status'] = $_POST['status'];

            // --- Logika Validasi ---
            if (empty($data['jenis'])) {
                $errors['jenis'] = 'Jenis kendaraan tidak boleh kosong.';
            }
            if (empty($data['merk'])) {
                $errors['merk'] = 'Merk tidak boleh kosong.';
            }
            if (empty($data['no_plat'])) {
                $errors['no_plat'] = 'No. Plat tidak boleh kosong.';
            } 
            // Cek keunikan, tapi abaikan untuk ID kendaraan ini sendiri
            elseif ($this->model->isPlatExistsForAnotherVehicle($data['no_plat'], $id)) {
                $errors['no_plat'] = 'No. Plat ini sudah digunakan oleh kendaraan lain.';
            }

            // Jika tidak ada error, update data
            if (empty($errors)) {
                $this->model->update($id, $data['jenis'], $data['merk'], $data['no_plat'], $data['status']);
                header("Location: index.php?page=kendaraan");
                exit();
            }
        }
        // Tampilkan form (baik saat pertama kali dibuka atau saat ada error)
        include "views/kendaraan/edit.php";
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: index.php?page=kendaraan");
    }

    public function recycleBin() {
        $result = $this->model->getAllDeleted();
        include "views/kendaraan/recycle_bin.php";
    }

    public function restore($id) {
        $this->model->restore($id);
        header("Location: index.php?page=kendaraan&action=recycleBin");
    }   
}
?>