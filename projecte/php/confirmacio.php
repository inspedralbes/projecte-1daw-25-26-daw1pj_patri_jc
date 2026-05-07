<?php
    include './header-footer/header.php';
    require_once 'connexio.php';
    require_once 'funcions.php';

    $finalitzar = 0;
    

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['finalitzar'])){
        $idIncidencia = $_POST['idIncidencia'];
        $rol = $_POST['rol'];
        $finalitzar = $_POST['finalitzar'] ?? 0;
        finalitzarIncidencia($conn, $idIncidencia, $rol);
    }else{
        $idIncidencia = $_GET['id'] ?? '';
        $rol = $_GET['rol'] ?? '';
        $finalitzar = $_GET['finalitzar'] ?? 0;
    }

    
?>

    <?php
        if($rol == 'tecnic' && $finalitzar == 1){
            ?>
            <div class="mb-3 col-lg-5 col-10 p-5 position-absolute top-50 start-50 translate-middle px-3 mt-3 b border rounded border-dark">
                <div class="text-center mt-2">
                    <h1 class="mt-4 col-lg-12 mx-auto">Incidència Finalitzada correctament!</h1>
                    <hr class="border border-primary border-3 opacity-75 mb-5 col-lg-12 col-12 mx-auto">
                    <h2 class="mb-5 mt-3">Número de la actuació: <span style="color: #F28508"><?= $idIncidencia?></span></h2>
                </div>
            </div>
            <?php
        }

        else if($rol == 'tecnic'){
            ?>
            <div class="mb-3 col-lg-5 col-10 p-5 position-absolute top-50 start-50 translate-middle px-3 mt-3 b border rounded border-dark">
    <div class="text-center mt-2">
        <h1 class="mt-4 col-lg-12 mx-auto">Actuació enviada correctament!</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 col-lg-12 col-12 mx-auto">
        <h2 class="mb-5 mt-3">Número de la actuació: <span style="color: #F28508"><?= $id ?></span></h2>
    </div>
</div>
<a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover mb-5 position-absolute bottom-0 start-0 ms-3" href="tecnic.php">
    🢘   Torna al Menú Tècnic
</a>
            <?php
        } 
        else {
            ?>
                <div class="mb-3 col-lg-5 col-10 p-5 position-absolute top-50 start-50 translate-middle px-3 mt-3 b border rounded border-dark">
    <div class="text-center mt-2">
        <h1 class="mt-4 col-lg-12 mx-auto">Incidència enviada correctament!</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 col-lg-12 col-12 mx-auto">
        <h2 class="mb-5 mt-3">Número d'Incidència <span style="color: #F28508"><?= $id ?></span></h2>
        <h5 class="col-lg-8 mx-auto">Pots consultar l'estat de la teva incidència mitjançant aquest identificador.</h5>
    </div>
</div>
<a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover mb-5 position-absolute bottom-0 start-0 ms-3" href="usuari.php">
    🢘 Torna al Menú Usuari
</a>
            <?php  
            }
    
    
    

    ?>
    <?php
include './header-footer/footer.php';?>


