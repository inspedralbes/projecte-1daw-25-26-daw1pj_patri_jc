

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Incidència</title>
</head>
<?php
    include './header-footer/header.php';

?>
<body class = "bg-body">



    <div class = "container-lg mt-3 mb-4 border border-primary  w-75 w-md-75 p-3 mx-auto rounded-5 border-3 bg-body-tertiary
" style = "border-color: #20D1E9 !important;">

    
    <h1 class = "text-center" style = "color: #444444;">Formulari d'Incidències</h1>
    <div class="mb-3 w-100 p-3   mx-auto px-3 mt-3">
        <form action="?">
            
            <div class = 'd-flex flex-column mb-2 p-2'>
                <label for="dept" class = "form-label mb-2 mt-2">Departament</label>
                <select name="dept" id="dept" class = "form-control">  
                    <option selected disabled>Selecciona...</option>
                    <option value="Angles">Llengua Anglesa</option>
                    <option value="Catala">Llengua Catalana</option>
                    <option value="Historia">Història</option>
                    <option value="Biologia">Biologia</option>
                    <option value="Matematiques">Matemàtiques</option>
                    <option value="Informatica">Informàtica</option>
                    <option value="Administracio">Administració</option>
                    <option value="Direccio">Direcció</option>  
                </select>

                <label for="tipus" class = "form-label mt-2 mb-2">Tipus d'Incidència</label>
                <select name="tipus" id="tipus" class = "form-control">
                    <option selected disabled>Selecciona...</option>
                    <option value="Hardware">Hardware</option>
                    <option value="Software">Software</option>
                    <option value="Xarxa">Xarxa</option>
                    <option value="Periferics">Perifèrics</option>
                    <option value="Altres">Altres</option>

                </select>
            
                <label for="desc" class = "form-label mb-2">Descripció</label>
                <textarea name="desc" id="desc" class = "form-control mb-2" rows = "3">

                </textarea>
            
            </div>

            <div class = "text-center">
                <input type="submit" value="Envía" class = "btn btn-primary">
            </div>
            
            
        </form>
    </div>
    </div>
    <?php 
    include './header-footer/footer.php';?>
</body>
</html>


<?php 

    function crear_incidencia($conn){

        //Obtenir nom del departament
        $nomDept = $_POST['dept'];

        if(empty($nomDept)){
            echo "<p class='error'>El nom del departament no pot estar buit.</p>";
            return;
        }

        //Obtenir el tipus de la incidencia
        $nomTipus = $_POST['tipus'];

        if(empty($nomtipus)){
            echo "<p class='error'>El tipus de la incidència no pot estar buit.</p>";
            return;
        }

        //Obtenit la descripcio de la incidencia
        $nomDesc = $_POST['desc'];

        if(empty($nomDesc)){
            echo "<p class='error'>La descripció de la incidència no pot estar buit.</p>";
            return;
        }

        
    }
