<?php
    include './header-footer/header.php';
    require_once 'connexio.php';
    $id =$_GET['id'];
    $rol = $_GET['rol']; // Obtenir l'ID de la incidencia
?>

<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmacio</title>
</head>
<body>
    <?php
        if($rol == 'tecnic'){
            echo '<div class="mb-3 col-lg-5 col-10 p-5 position-absolute top-50 start-50 translate-middle px-3 mt-3 b border rounded border-dark">';
            echo '<div class="text-center mt-2">';
            echo '<h1 class="mt-4 col-lg-12 mx-auto">Actuació enviada correctament!</h1>';
            echo '<hr class="border border-primary border-3 opacity-75 mb-5 col-lg-12 col-12 mx-auto">';
            echo '<h2 class="mb-5 mt-3">Número de la actuació: <span style="color: #F28508">' . $id . '</span></h2>';
            echo '</div>';
            echo '</div>';
            echo '<a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover mb-5 position-absolute bottom-0 start-0 ms-3" 
            href="tecnic.php">
            Torna al Menú Tècnic
            </a>';
        } 
        else {
                echo '<div class="mb-3 col-lg-5 col-10 p-5 position-absolute top-50 start-50 translate-middle px-3 mt-3 b border rounded border-dark">';
                echo '<div class="text-center mt-2">';
                echo '<h1 class="mt-4 col-lg-12 mx-auto">Incidència enviada correctament!</h1>';
                echo '<hr class="border border-primary border-3 opacity-75 mb-5 col-lg-12 col-12 mx-auto">';
                echo '<h2 class="mb-5 mt-3">Número d\'Incidència <span style="color: #F28508">' . $id . '</span></h2>';
                echo '<h5 class="col-lg-8 mx-auto">Pots consultar l\'estat de la teva incidència mitjançant aquest identificador.</h5>';
                echo '</div>';
                echo '</div>';
    
                echo '<a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover mb-5 position-absolute bottom-0 start-0 ms-3" 
                href="usuari.php">
                Torna al Menú Usuari
                </a>';
                }
    
    
    

    ?>
    <?php
    include './header-footer/footer.php';?>
</body>
</html>

