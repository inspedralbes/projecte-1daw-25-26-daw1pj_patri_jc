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

    $actuacions = getActuacions($conn, $incidencia["ID_INCIDENCIA"]);

    $resultat = getEstat($actuacions, $incidencia);
    $estat = $resultat["estat"];
    $classe = $resultat["classe"];
?>


<?php include './header-footer/header.php'; ?>

<main class="d-flex flex-column flex-grow-1 pb-3">
    <div class="text-center mt-5 mx-auto col-10 col-lg-4">
    <h1>Incidència#<span style="color: #EB8623"><?php echo $incidencia["ID_INCIDENCIA"]; ?></span></h1>        
    <hr class="border border-primary border-3 opacity-75 mb-5 mx-auto">
    </div>

    <div class="container mx-auto col-10 col-lg-8">
         <div class="row justify-content-center">

            <div class="col-auto">
                <span class="badge bg-secondary bg-gradient"><?php echo $incidencia["NOM_TIPUS"]; ?></span>
            </div>

            <div class="col-auto">
                <span class="badge bg-secondary bg-gradient"><?php echo $incidencia["NOM_DEPT"]; ?></span>
            </div>

            <div class="col-auto">
                <span class="badge bg-secondary bg-gradient"><?php echo $incidencia["DATA_INICI"]; ?></span>
            </div>

            <div class="col-auto">
                <span class="badge <?= $incidencia["DATA_FI"] ? 'bg-secondary' : 'bg-secondary opacity-50' ?> bg-gradient"><?php echo $incidencia["DATA_FI"] ?? 'Pendent de tancar'; ?></span>
            </div>

            <div class="col-auto">
                <span class="badge <?= $incidencia["PRIORITAT"] ? 'bg-secondary' : 'bg-secondary opacity-50' ?> bg-gradient">
                    <?php echo $incidencia["PRIORITAT"] ?? 'Sense Prioritat'; ?>
                </span>
            </div>

            <div class="col-auto">
                <span class="badge <?= $incidencia["NOM_TECNIC"] ? 'bg-info' : 'bg-secondary opacity-50' ?> bg-gradient">
                    <?php echo $incidencia["NOM_TECNIC"] ?? 'Sense Tecnic'; ?>
                </span>
            </div>
            <div class="col-auto">
                <span class="badge <?php echo $classe; ?>">
                    <?php echo $estat; ?>
                </span>
            </div> 
        </div>
    </div>

</main>