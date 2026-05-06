<?php 
    include './header-footer/header.php';
    include 'connexio.php';


    function crear_incidencia($conn){

        //Obtenir nom del departament
        $nomDept = $_POST['dept'];

        if(empty($nomDept)){
            echo "<p class='error'>El nom del departament no pot estar buit.</p>";
            return;
        }

        //Obtenir el tipus de la incidencia
        $nomTipus = $_POST['tipus'];

        if(empty($nomTipus)){
            echo "<p class='error'>El tipus de la incidència no pot estar buit.</p>";
            return;
        }

        //Obtenit la descripcio de la incidencia
        $nomDesc = $_POST['desc'];

        if(empty($nomDesc)){
            echo "<p class='error'>La descripció de la incidència no pot estar buit.</p>";
            return;
        }


        $data_inici = date('Y-m-d');


        $sql = "INSERT INTO INCIDENCIA (id_dept, id_tipus,data_inici, desc_incidencia ) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $nomDept, $nomTipus, $data_inici, $nomDesc);

        if($stmt->execute()){
            $id = $stmt->insert_id; // Obtenir l'ID de la última inserción
            echo "<script> window.location.href = 'confirmacio.php?id=" . $id . "'; </script>";
            exit();
        } else{
            echo "<p class ='error'> Error al crear la incidència: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    }

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Incidència</title>
</head>


<body class = "bg-body">
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            crear_incidencia($conn);
        }else{
            ?>


    <div class = "container-lg mt-3 mb-4   p-3 mx-auto">

    <div class ="text-center mt-5">
        <h1 class = "text-center">Formulari d'Incidències</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 col-lg-4 
        col-10 mx-auto">
    </div>
    
    <div class="mb-3 col-lg-6 p-3 mx-auto px-3 mt-3">
        <form action="crear_incidencies.php" method ="POST">
            
            <div class = 'd-flex flex-column mb-2 p-2 border rounded border-dark p-5'>
                <label for="dept" class = "form-label mb-2 mt-2">Departament</label>
                <select name="dept" id="dept" class = "form-control" required>  
                    <option selected disabled value="">Selecciona...</option>
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

                <label for="tipus" class = "form-label mt-3 mb-2">Tipus d'Incidència</label>
                <select name="tipus" id="tipus" class = "form-control" required>
                    <option selected disabled value = "">Selecciona...</option>
                    <option value="1">Hardware</option>
                    <option value="2">Software</option>
                    <option value="3">Xarxa</option>
                    <option value="4">Perifèrics</option>
                    <option value="5">Altres</option>

                </select>
            
                <label for="desc" class = "form-label mt-3 mb-2">Descripció</label>
                <textarea name="desc" id="desc" class = "form-control mb-2" rows = "3" required value = ""></textarea>
                <div class = "text-center">
                <input type="submit" value="Envía" class = "btn btn-primary mt-3">
            </div>
            </div>

            
            
            
        </form>
        <?php
        }
        ?>
    </div>
    </div>
    <div class="mt-auto col-10 col-lg-11 mx-auto">
        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="usuari.php">
            🢘 Torna al Menú Usuari
        </a>
    </div>

    <?php 
    include './header-footer/footer.php';?>
</body>
</html>


