<?php
include_once "connexio.php";
require_once 'funcions.php';

$rol = $_GET['rol'] ?? 'usuari';
$id = $_GET['id'] ?? null;

if (empty($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
    echo "ID no vàlid";
    exit;
}

if($rol != 'admin'){
    header("Location: index.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    updateIncidencia($conn, $id, $_POST['prioritat'], $_POST['tecnic'], $_POST['tipus']);
    header("Location: llistaIncidencies.php?rol=admin");
    exit;
}

?>  