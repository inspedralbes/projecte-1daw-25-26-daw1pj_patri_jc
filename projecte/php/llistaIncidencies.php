<?php 
    require_once 'connexio.php';
    require_once 'funcions.php';

    $rol = $_GET['rol'] ?? 'usuari';
    $idTecnic = $_GET['idTecnic'] ?? '';
    
    if($rol == 'tecnic' && !empty($idTecnic)){
        $incidencies = getIncidenciesTecnic($conn, $idTecnic);
        $actuacions  = getActuacions($conn, $incidencies);
        
        
    }elseif($rol == 'usuari' && !empty($id_dept)){
        //funcion listar por dept
    }//opcion con admin
    else {
        header("Location: index.php");
        exit();
    }
    $nomTecnic = getNomTecnic($conn, $idTecnic);
    include './header-footer/header.php';
?>

<main class="d-flex flex-column flex-grow-1 pb-3">
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
                <?php foreach($incidencies as $inc):;

                    $res_estat = getEstat($actuacions, $inc);
                    $estat = $res_estat ["estat"];
                    $classe = $res_estat["classe"];
                    
                ?>
                
                    
                <td><a href="detall_incidencia.php?id=<?php echo $inc['ID_INCIDENCIA']; ?>&rol=<?php echo $rol; ?>" class="link-primary"><?php echo $inc['ID_INCIDENCIA']; ?></a></td>
                <td><?= $inc["DATA_INICI"];?> </td>
                <td><?= $inc["PRIORITAT"];?> </td>
                <td><?= $inc["DESC_INCIDENCIA"];?> </td>
                <td class = <?php echo $classe;?> > <?php echo $estat;?> </td>
                </tr>
                
                <!--Si no un mutted text "No hi han incidencies asignades"-->

                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
    </div>
</main>    

<?php include './header-footer/footer.php';?>