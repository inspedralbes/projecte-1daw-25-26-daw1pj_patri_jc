<?php
    require_once 'connexio.php';
    $rol = $_GET['rol'] ?? 'usuari';
    $id = $_GET['id'] ?? null;

    //Valida si el id es un enter i no es null
    if (empty($id) || !filter_var($id, FILTER_VALIDATE_INT)) {
        echo "ID no vàlid";
        exit;
    }

    function getIncidencia($conn, $id){
        $sql = "SELECT i.ID_INCIDENCIA, t.NOM_TIPUS, d.NOM_DEPT, i.DATA_INICI, i.DATA_FI
        FROM INCIDENCIA i
        LEFT JOIN TIPUS t ON i.ID_TIPUS = t.ID_TIPUS
        LEFT JOIN DEPARTAMENT d ON i.ID_DEPT = d.ID_DEPT
        WHERE i.ID_INCIDENCIA = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
                
        $incidencia = $result->fetch_assoc();

        if (!$incidencia) {
            echo "<p class='error'>No s'ha trobat cap incidència.</p>";
            return;
        }

        return $incidencia;
    }

    function getActuacions($conn, $id){
        $sql = "SELECT i.ID_INCIDENCIA, i.PRIORITAT, t.NOM_TIPUS, d.NOM_DEPT, i.DATA_INICI, i.DATA_FI
        FROM INCIDENCIA i
        LEFT JOIN TIPUS t ON i.ID_TIPUS = t.ID_TIPUS
        LEFT JOIN DEPARTAMENT d ON i.ID_DEPT = d.ID_DEPT
        WHERE i.ID_INCIDENCIA = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
                
        $incidencia = $result->fetch_assoc();

        if (!$incidencia) {
            echo "<p class='error'>No s'ha trobat cap incidència.</p>";
            return;
        }

        return $incidencia;
    }
?>

<?php $incidencia = getIncidencia($conn, $id);?>

<?php include './header-footer/header.php'; ?>
<main > 
    <div class="text-center mt-5">
    <h1>Incidència#<span style="color: #EB8623"><?= $incidencia["ID_INCIDENCIA"] ?></span></h1>        
    <hr class="border border-primary border-3 opacity-75 mb-5 col-10 col-lg-4 mx-auto">
    </div>
</main>

 <?php include './header-footer/footer.php'; ?>    