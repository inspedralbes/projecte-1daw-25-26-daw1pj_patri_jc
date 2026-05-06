<?php 
    require_once 'connexio.php';
    require_once 'funcions.php';
    $rol = $_GET['rol'] ?? 'usuari';
    $id = $_GET['id'] ?? null;

    //Valida si el id es un enter i no es null
    if (empty($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
        echo "ID no vàlid";
        exit;
    }

    $incidencia = getIncidencia($conn, $id);

    echo "modificar incidencia $id";
?>