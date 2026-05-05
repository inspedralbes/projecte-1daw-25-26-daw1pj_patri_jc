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

    <div class="container mx-auto col-10 col-lg-5">
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
                <span class="badge <?php echo $classe; ?>">
                    <?php echo $estat; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="mt-5 col-10 col-lg-8 mx-auto">
        <h4 class="text-primary">Descripció Indicencia</h4>

        <div class="border rounded p-2">
            <p><?php echo $incidencia["DESC_INCIDENCIA"]; ?></p>
        </div>
    </div>

    <div class="mt-5 col-10 col-lg-8 mx-auto">
        <h4 class="text-primary">Actuacions</h4>
        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-3"scope="col">Data</th>
                <th scope="col">Descripció</th>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            <!--Si n'hi han fa un bucle-->
            <?php if (!empty($actuacions)): ?>

            <?php foreach ($actuacions as $act): ?>
                <tr>
                    <td><?= $act["DATA_ACTUACIO"]; ?></td>
                    <td><?= $act["DESC_ACTUACIO"]; ?></td>
                </tr>
            <?php endforeach; ?>

            <!--Si no hi han actuacions-->
            <?php else: ?>

                <tr>
                    <td colspan="2" class="text-center text-muted">
                        No hi ha actuacions
                    </td>
                </tr>

            <?php endif; ?>
        </tbody>

        </table>
    </div>

    <div class="mt-auto col-10 col-lg-11 mx-auto">
        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="buscar_incidencia.php">
            🢘 Torna al cercador
        </a>
    </div>
</main>

 <?php include './header-footer/footer.php'; ?>    