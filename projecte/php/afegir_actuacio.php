<?php include './header-footer/header.php';
    require_once 'connexio.php';
    require_once 'funcions.php';

    $rol = $_GET['rol'] ?? 'usuari';
    $idIncidencia = $_GET['id'] ?? '';
    
?>


<h1 class = "text-center mx-auto">Actuació de la Incidència <span style = "color: #F28508"><?php  echo $idIncidencia ?></span></h1>

<div class="mb-3 col-lg-6 p-3 mx-auto px-3 mt-3">
<form action="crear_incidencies.php" method ="POST">
            
            <div class = 'd-flex flex-column mb-2 p-2 border rounded border-dark p-5'>
                <label for="temmps" class = "form-label mb-2 mt-2">Temps:</label>
                <input type="time" name="temps" id="temps">

                <label for="data" class = "form-label mt-3 mb-2">Data:</label>
                <input type="date" name="date" id="date">
                
            
                <label for="desc" class = "form-label mt-3 mb-2">Descripció</label>
                <textarea name="desc" id="desc" class = "form-control mb-2" rows = "3" required value = ""></textarea>

                <div class = "text-center">
                <input type="submit" value="Envía" class = "btn btn-primary mt-3">
                </div>
            </div>

            
            
            
        </form>
</div>

 <?php
 include './header-footer/footer.php' ?>