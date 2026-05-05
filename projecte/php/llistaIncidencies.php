<?php 
    require_once 'connexio.php';
    require_once 'funcions.php';

    $rol = $_GET['rol'] ?? 'usuari';
    $idTecnic = $_GET['idTecnic'] ?? '';
    $id_dept = $_GET['id_dept'] ?? '';
    
    if($rol == 'tecnic' && !empty($idTecnic)){
        $incidencies = getIncidenciesTecnic($conn, $idTecnic);
        $actuacions  = getActuacions($conn, $incidencies);
        $nomTecnic = $incidencies[0]['NOM_TECNIC'] ?? 'Tècnic';
        
    }elseif($rol == 'usuari' && !empty($id_dept)){
        $incidencies = getIncidenciesDept($conn, $id_dept);
        $nom_dept = $incidencies[0]['NOM_DEPT'] ?? 'Departament';

    }elseif($rol == 'admin'){
        $filtre = $_GET['filtre'] ?? '';
        $ordre = $_GET['ordre'] ?? 'ID_INCIDENCIA';
        $dir = $_GET['dir'] ?? 'ASC';
        $incidencies = getAllIncidencies($conn, $filtre, $ordre, $dir);
    }
    else {
        header("Location: index.php");
        exit();
    }

    $incidencies = afegirEstat($conn, $incidencies);

    include './header-footer/header.php';
?>

<main class="d-flex flex-column flex-grow-1 pb-3">

    <!-------------------------------------TECNIC--------------------------------------->
    <?php if($rol == 'tecnic'): 
     //El que veu el tecnic quan inicia sessió amb el seu nom   
    ?>

    <h1 class = "mt-5 ms-4 text-center">Benvingut, 
        <span style = "color: #F28508"><?php echo $nomTecnic ?>!</span>
    </h1>
    <div class="mt-5 col-10 col-lg-8 mx-auto">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-1"scope="col">ID</th>
                <th class="col-2"scope="col">Data</th>
                <th class="col-2"scope="col">Prioritat</th>
                <th scope="col">Descripció</th>
                <th scope="col">Estat</th>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            <!--Si n'hi han fa un bucle-->
            <?php if(!empty($incidencies)): ?>
                <?php foreach($incidencies as $inc):

                    $res_estat = getEstat($actuacions, $inc);
                    $estat = $res_estat ["estat"];
                    $classe = $res_estat["classe"];

                ?>
                
                    
                <a href="detall_incidencia.php"><td><?= $inc["ID_INCIDENCIA"];?> </td></a>
                <td><?= $inc["DATA_INICI"];?> </td>
                <td><?= $inc["PRIORITAT"];?> </td>
                <td><?= $inc["DESC_INCIDENCIA"];?> </td>
                <td class = <?php echo $classe;?> > <?php echo $estat;?> </td>


                <!--Si no un mutted text "No hi han incidencies asignades"-->

                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
    </div>


    <!-------------------------------------USUARI--------------------------------------->
    <?php elseif($rol == 'usuari'): 
    //El que veu l'usuari quan busca per departament
    ?>

    <h1 class = "mt-5 ms-4 text-center">Indicències 
        <span style = "color: #F28508"><?php echo $nom_dept?></span>
    </h1>

    <div class="mt-5 col-10 col-lg-8 mx-auto">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-1"scope="col">ID</th>
                <th class="col-2"scope="col">Data</th>
                <th class="col-2"scope="col">Estat</th>
                <th scope="col">Descripció</th>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            <!--Si n'hi han fa un bucle-->
            <?php if(!empty($incidencies)): ?>
                <?php foreach($incidencies as $inc): ?>
                    <td>
                        <a href="detall_incidencia.php?id=<?php echo $inc['ID_INCIDENCIA']; ?>&rol=<?php echo $rol; ?>" class="link-primary">
                            <?php echo $inc['ID_INCIDENCIA']; ?>
                        </a>
                    </td>
                    <td><?= $inc["DATA_INICI"];?> </td>
                    <td><span class="badge <?= $inc['classe'] ?>"><?= $inc['estat'] ?></span></td>
                    <td><?= htmlspecialchars($inc['DESC_INCIDENCIA']) ?></td>                

                <?php endforeach ?>

            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center text-muted">
                        No hi han indicències
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
    </div>
    <div class="mt-auto col-10 col-lg-11 mx-auto">
        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="buscar_incidencia.php">
            🢘 Torna al cercador
        </a>
    </div>

    <!-------------------------------------ADMIN--------------------------------------->
    <?php elseif($rol == 'admin'): 
    //El que veu l'admin
    ?>

    <h1 class = "mt-5 ms-4 text-center">Benvingut, 
        <span style = "color: #F28508">Administrador!</span>
    </h1>
    <div class="mt-5 col-10 col-lg-11 mx-auto table-responsive"> <!--table responsive crea un scroll horitzontal segons el contingut -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-lg-1"scope="col">ID</th>
                <th class="col-lg-1"scope="col">Data inici</th>
                <th class="col-lg-1"scope="col">Data fi</th>
                <th class="col-lg-1"scope="col">Estat</th>
                <th class="col-lg-1"scope="col">Prioritat</th>
                <th class="col-lg-1"scope="col">Tècnic</th>
                <th scope="col">Descripció</th>
            </tr>
        </thead>

        <tbody class="table-group-divider">
            <?php if(!empty($incidencies)): ?>
                <?php foreach($incidencies as $inc): ?>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>                

                <?php endforeach ?>

            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center text-muted">
                        No hi han indicències
                    </td>
                </tr>
            <?php endif ?>
    </table>
    </div>
<?php endif ?>
</main>    

<?php include './header-footer/footer.php';?>