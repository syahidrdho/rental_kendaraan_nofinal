<?php
require_once "config.php";

$page   = isset($_GET['page']) ? $_GET['page'] : "dashboard"; 
$action = isset($_GET['action']) ? $_GET['action'] : "index";


switch ($page) {
    case "dashboard":
        require_once "controllers/DashboardController.php";
        $controller = new DashboardController($conn);
        break;
    case "kendaraan":
        require_once "controllers/KendaraanController.php";
        $controller = new KendaraanController($conn);
        break;
    case "pelanggan":
        require_once "controllers/PelangganController.php";
        $controller = new PelangganController($conn);
        break;
    case "transaksi":
        require_once "controllers/TransaksiController.php";
        $controller = new TransaksiController($conn);
        break;
    case "pembayaran":
        require_once "controllers/PembayaranController.php";
        $controller = new PembayaranController($conn);
        break;
    case "pengembalian":
        require_once "controllers/PengembalianController.php";
        $controller = new PengembalianController($conn);
        break;
    default:
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        exit;
}


if (method_exists($controller, $action)) {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $controller->$action($id);
} else {
    echo "<h1>404 - Aksi Tidak Ditemukan</h1>";
}
?>