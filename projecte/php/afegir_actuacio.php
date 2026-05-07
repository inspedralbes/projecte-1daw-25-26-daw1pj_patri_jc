<?php 
include './header-footer/header.php';
require_once 'connexio.php';
require_once 'funcions.php';

$rol = $_GET['rol'] ?? 'usuari';
$idIncidencia = $_GET['id'] ?? '';
$idActuacio = $_GET['idActuacio'] ?? '';
$dataActuacio = $_GET['dataActuacio'] ?? '';
$desc_actuacio = $_GET['desc_actuacio'] ?? '';
$temps = $_GET['temps'] ?? '';
$esVisible = $_GET['esVisible'] ?? '';

?>


<?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $rol = $_POST['rol'];
            $idIncidencia = $_POST['id'];
            $idActuacio = $_POST['idActuacio'] ?? '';
            $desc_actuacio = $_POST['desc'];
            $temps = $_POST['temps'];
            $esVisible = isset($_POST['visible']) ? 1 : 0;
            
            if(empty($idActuacio)){
                afegir_actuacions($conn,$idIncidencia,$rol);
            }else{

                actualizarActuacio($conn, $idActuacio, $desc_actuacio, $temps, $esVisible, $rol);
            }
            


        }else{
            $rol = $_GET['rol'] ?? 'usuari';
            $idIncidencia = $_GET['id'] ?? '';
            ?>

<?php
    if(empty($idActuacio)){
        echo '<h1 class = "text-center mx-auto mt-5">Actuació de la Incidència <span style = "color: #F28508">' . $idIncidencia . '</span></h1>';
    }else{
        echo '<h1 class = "text-center mx-auto mt-5">Modificació de la Actuació <span style = "color: #F28508">'. $idActuacio . '</span></h1>';
    }
?>
        
<hr class="border border-primary border-3 opacity-75 mb-5 col-lg-4 
        col-10 mx-auto">
<div class="mb-3 col-lg-6 p-3 mx-auto px-3 mt-3 col-11">
<form action="afegir_actuacio.php" method ="POST">
            
            <div class = 'd-flex flex-column mb-2 p-2 border rounded border-dark p-5'>

                <label for="temps" class="form-label mb-2 mt-2">Temps(HH:MM:SS):</label>
                <input type="time" name="temps" id="temps" value="<?= $temps ?>" step = "1">

                <?php
                if(empty($dataActuacio)){
                ?>

                    <label for="dataActuacio" class = "form-label mt-3 mb-2">Data:</label>
                    <input type="date" name="dataActuacio" id="dataActuacio" value = "<?= $dataActuacio?>">

                <?php
                }else {
                    ?>
                    <input type="hidden" name="dataActuacio" id="dataActuacio" value = "<?= $dataActuacio?>">
                    <?php
                }?>

                
                
            
                <label for="desc" class = "form-label mt-3 mb-2">Descripció</label>
                <textarea name="desc" id="desc" class = "form-control mb-2" rows = "3" required ><?=$desc_actuacio ?></textarea>

                <div class = "d-inline-block mt-3 col-12 mb-3">
                    <input type="checkbox" name="visible" id="visible" <?= $esVisible == 1 ? 'checked' : '' ?>>
                    <label for="visible">Pot veure l'usuari la incidència?</label>
                </div>

                <input type="hidden" name="id" value="<?= $idIncidencia ?>">
                <input type="hidden" name="rol" value="<?= $rol ?>">
                <input type="hidden" name="idActuacio" value="<?= $idActuacio ?>">

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
