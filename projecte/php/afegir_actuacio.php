<?php include './header-footer/header.php';
    require_once 'connexio.php';
    require_once 'funcions.php';

    $rol = $_GET['rol'] ?? 'usuari';
    $idIncidencia = $_GET['id'] ?? '';
    
?>


<?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $rol = $_POST['rol'];
            $idIncidencia = $_POST['id']; 
            afegir_actuacions($conn,$idIncidencia,$rol);
        }else{
            $rol = $_GET['rol'] ?? 'usuari';
            $idIncidencia = $_GET['id'] ?? '';
            ?>


        <h1 class = "text-center mx-auto mt-5">Actuació de la Incidència <span style = "color: #F28508"><?php  echo $idIncidencia ?></span></h1>
<hr class="border border-primary border-3 opacity-75 mb-5 col-lg-4 
        col-10 mx-auto">
<div class="mb-3 col-lg-6 p-3 mx-auto px-3 mt-3 col-11">
<form action="afegir_actuacio.php" method ="POST">
            
            <div class = 'd-flex flex-column mb-2 p-2 border rounded border-dark p-5'>
                <label for="temps" class = "form-label mb-2 mt-2">Temps(HH:MM):</label>
                <input type="time" name="temps" id="temps">

                <label for="dataActuacio" class = "form-label mt-3 mb-2">Data:</label>
                <input type="date" name="dataActuacio" id="dataActuacio">
                
            
                <label for="desc" class = "form-label mt-3 mb-2">Descripció</label>
                <textarea name="desc" id="desc" class = "form-control mb-2" rows = "3" required value = ""></textarea>

                <div class = "d-inline-block mt-3 col-12 mb-3">
                    <input type="checkbox" name="visible" id="visible">
                    <label for="visible">Pot veure l'usuari la incidència?</label>
                </div>

                <input type="hidden" name="id" value="<?= $idIncidencia ?>">
                <input type="hidden" name="rol" value="<?= $rol ?>">
                

                <div class = "text-center">
                <input type="submit" value="Envía" class = "btn btn-primary mt-3">
                </div>
            </div>

            
            
            
        </form>
        <?php }?>
</div>

 <?php
 include './header-footer/footer.php' ?>
</body>
</html>
