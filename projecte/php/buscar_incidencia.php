<?php include './header-footer/header.php';
    require_once 'connexio.php';
    $rol = $_GET['rol'] ?? 'usuari';

    function cercar($conn){
        $departament = $_POST['departament'] ?? '';
        $id = $_POST['id'] ?? '';
        
        //Valida si els dos camps estan buits
        if(empty($departament) && empty($id)){
            echo "<p class='error'>Siusplau ompli un dels dos camps.</p>";
            return;
        }

        //Valida si els dos camps están omplerts alhora
        if(!empty($departament) && !empty($id)){
            echo "<p class='error'>Només pot cercar per un dels dos camps.</p>";
            return;
        }

        //Valida que el id sigui un enter vàlid.
        if(!empty($id) && filter_var($id, FILTER_VALIDATE_INT) === false){
            echo "<p class='error'>Introdueixi un identificador vàlid.</p>";
            return;
        }

        //Cerca per id
        if(!empty($id)){
            $sql = "SELECT ID_INCIDENCIA FROM INCIDENCIA
            WHERE ID_INCIDENCIA = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                //redirige a la pagina de detalle de la incidencia con ese id
                header("Location: detall_incidencia.php?id=$id&rol=$rol"); 
                exit;

            }else{
                echo "<p class='error'>No s'ha trobat cap incidència.</p>";
                return;
            }
        }
        
        //Cercar per departament

        if(!empty($departament)){
            $sql = "SELECT ID_DEPT FROM DEPARTAMENT
            WHERE ID_DEPT = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $departament);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                //redirige a la pagina de incidencias de ese dept
                header("Location: llistar_incidencies.php?id=$departament&rol=$rol"); 
                exit;

            }else{
                echo "<p class='error'>No s'ha trobat cap incidència.</p>";
                return;
            }
        }
    }
?>

<main > 
    <div class="text-center mt-5">
        <h1>Cercador d'Incidències</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 w-50 mx-auto">
    </div>

    <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            cercar($conn);
        }else{
            ?>
            <!-- Buscar por departamento -->
                <div class= "col-6 mx-auto">
                    <form method="post" class="border rounded border-dark p-5">
                        <div class="mb-5">
                            <label for="b_departament" class="form-label d-block">
                                Buscar per departament
                            </label>
                            <select class="form-select" aria-label="Selecciona departament" name="departament" id= "b_departament">
                                <option value="">Selecciona...</option>
                                <option value="1">Llengua Anglesa</option>
                                <option value="2">Llengua Catalana</option>
                                <option value="3">Història</option>
                                <option value="4">Biologia</option>
                                <option value="5">Matemàtiques</option>
                                <option value="6">Informàtica</option>
                                <option value="7">Administració</option>
                                <option value="8">Direcció</option>  
                                <option value="9">Altres</option>             
                    
                            </select>      
                        </div>

                <!-- Buscar por id -->
                        <div class="mb-5">
                            <label for="id" class="form-label d-block">Buscar per identificador</label>
                            <input type="text" class="form-control" id= "id" name="id" placeholder="Número identificador ex: 13" inputmode="numeric" 
                            pattern = "[0-9]*">
                        </div>

                        <input class= "btn btn-primary py-1" type="submit" value="Enviar">
                    </form>
                </div> 
            <?php
        }
        ?>
</main>
    <!-- Hay que validar que el id sea valido y un num con php -->


 <?php
 include './header-footer/footer.php' ?>
