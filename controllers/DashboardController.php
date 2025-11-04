<?php
require_once "models/Dashboard.php";

class DashboardController {
    private $model;

    public function __construct($db) {
        $this->model = new Dashboard($db);
    }

    public function index() {
        $summary = $this->model->getSummary();
        include "views/dashboard/index.php";
    }
}
?>