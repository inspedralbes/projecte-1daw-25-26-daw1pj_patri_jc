<?php 
    require_once 'connexio.php';
    require_once 'funcions.php';

    $rol = $_GET['rol'] ?? 'usuari';
    $idTecnic = $_GET['idTecnic'] ?? '';
    $id_dept = $_GET['id_dept']  ?? '';

    
    if($rol == 'tecnic' && !empty($idTecnic)){
        $incidencies = getIncidenciesTecnic($conn, $idTecnic);
        $actuacions  = getActuacions($conn, $incidencies);
        $nomTecnic = $incidencies[0]['NOM_TECNIC'] ?? 'Tècnic';
        
    }elseif($rol == 'usuari' && !empty($id_dept)){
        $incidencies = getIncidenciesDept($conn, $id_dept);
        $nom_dept = $incidencies[0]['NOM_DEPT'] ?? 'Departament';
    }
    //opcion con admin
    else {
        header("Location: index.php");
        exit();
    }
    
    include './header-footer/header.php';
?>

<main class="d-flex flex-column flex-grow-1 pb-3">
    <?php   if($rol == 'tecnic' && !empty($idTecnic)): ?>
    <h1 class = "mt-5 ms-4 text-center">
        Benvingut, <span style = "color: #F28508"><?php echo $nomTecnic ?>!</span>
    </h1>
    <div class="mt-5 col-10 col-lg-8 mx-auto">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-1"scope="col">ID</th>
                    <th class="col-2"scope="col">Data</th>
                    <th class="col-2"scope="col">Prioritat</th>
                    <th scope="col">Descripció</th>
                </tr>
            </thead>

            <tbody class="table-group-divider">
                <!--Si n'hi han fa un bucle-->
                <?php if(!empty($incidencies)): ?>
                <?php foreach($incidencies as $inc): ?>
                    <td><?= $inc["ID_INCIDENCIA"];?> </td>
                <!--Si no un mutted text "No hi han incidencies asignades"-->
                <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <?php elseif($rol == 'usuari' && !empty($id_dept)): ?>
        <h1 class = "mt-5 ms-4 text-center">
            Incidències <span style = "color: #F28508"><?php echo $nom_dept?></span>
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
                        <td><?= $inc["ID_INCIDENCIA"];?> </td>
                    <!--Si no un mutted text "No hi han incidencies asignades"-->
                    <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>    

<?php include './header-footer/footer.php';?>