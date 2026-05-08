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
        <h4 class="text-primary col-lg-12">Descripció Indicencia</h4>
        <div class="border rounded p-2">
        <p><?= $incidencia["DESC_INCIDENCIA"] ?></p>
        </div>
    </div>
        
        

    <div class="mt-5 col-10 col-lg-8 mx-auto">
        <h4 class="text-primary">Actuacions</h4>
        <div class = "overflow-auto" style="max-height: 380px;">
        <table class="table table-bordered table-striped ">
        <thead>
            <tr>
                <th class="col-3 col-lg-2"scope="col">Data</th>
                <th scope="col" class="col-3 col-lg-7">Descripció</th>
                <?php
                    if($rol == 'tecnic' || $rol == 'admin'){
                        echo '<th class="col-3 col-lg-2" scope="col">Temps</th>';
                        echo '<th class="col-1 col-lg-3" scope="col">Edita </th>';

                    }
                ?>

            </tr>
        </thead>

        <tbody class="table-group-divider">
            <!--Si n'hi han fa un bucle-->
            <?php if (!empty($actuacions)): ?>

            <?php foreach ($actuacions as $act): ?>
        <tr>
        <?php if($rol == 'tecnic' || $rol == 'admin'): ?>
            <td><?= $act["DATA_ACTUACIO"] ?></td>
            <td><?= $act["DESC_ACTUACIO"] ?></td>
            <td><?= $act["TEMPS"] ?></td>
            <td class="text-center"><a class="link-offset-2 link-underline link-underline-opacity-0" href="afegir_actuacio.php?idActuacio=<?= $act["ID_ACTUACIO"]?>&dataActuacio=<?= $act["DATA_ACTUACIO"]?>&desc_actuacio=<?= $act["DESC_ACTUACIO"]?>&temps=<?= $act["TEMPS"]?>&esVisible=<?= $act["ES_VISIBLE"]?>&rol=<?= $rol?>">✏️</a></td>
        <?php elseif($rol == 'usuari' && $act["ES_VISIBLE"] == 1): ?>
            <td><?= $act["DATA_ACTUACIO"] ?></td>
            <td><?= $act["DESC_ACTUACIO"] ?></td>
        <?php endif; ?>
    </tr>
<?php endforeach; ?>

            <!--Si no hi han actuacions-->
            <?php else: ?>

                <tr>
                    <?php
                        if($rol == 'tecnic'){
                            echo '<td colspan="4" class="text-center text-muted">
                            No hi ha actuacions
                            </td>';
                        }else{
                            echo '<td colspan="2" class="text-center text-muted">
                        No hi ha actuacions
                    </td>';
                        }
                    ?>
                    
                </tr>

            <?php endif; ?>
            <tr>
                <td class = "border-0" colspan = "2"></td>
                <td>
                        <strong>Total:</strong>
        <span><?= sumarTemps($conn, $incidencia["ID_INCIDENCIA"]) ?></span>
                </td>
                <td></td>
            </tr>
        </tbody>

        </table>
    </div>
        <?php if ($rol == 'tecnic'): ?>

    <div class ="mt-3 mb-3 d-flex justify-content-between" >
        <a  href="afegir_actuacio.php?id=<?= $incidencia["ID_INCIDENCIA"] ?>&rol=<?= $rol ?>">
        <button type="button" class="btn btn-primary">Nova Actuació</button>
        </a>

        <?php
            if(getEstat($actuacions, $incidencia) == 'Tancada'){
        ?>
        <form action="confirmacio.php" method = "POST">
            <input type="hidden" name="idIncidencia" value="<?= $incidencia["ID_INCIDENCIA"] ?>">
            <input type="hidden" name="rol" value="<?= $rol ?>">
            <input type="hidden" name="finalitzar" value="1">
            <button type="submit" class="btn btn-danger">Finalitzar Incidència</button>        
        </form>
        <?php
            }
        ?>
    </div>
<?php endif; ?>
    </div>

    <div class="mt-auto col-10 col-lg-12 px-3 mx-auto">
        <?php if($rol == 'usuari'): ?>
        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="buscar_incidencia.php">
            🢘 Torna al cercador
        </a>
         <?php endif; ?>

        <?php if($rol == 'tecnic'): ?>
        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="llistaIncidencies.php?rol=<?= $rol ?>">
            🢘 Torna enrere
        </a>
        <?php endif; ?>
    </div>
</main>

<?php include './header-footer/footer.php'; ?>    