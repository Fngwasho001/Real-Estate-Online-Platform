<?php
include_once('FrontController.php');
include_once('AdminController.php');

if(isset($_GET['admin'])) {
    $obj = new AdminController();
    $obj->initProcess();
} else {
    include_once('FrontController.php');
    $obj = new FrontController();
    $obj->initProcess();
}