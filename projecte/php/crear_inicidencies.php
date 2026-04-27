<?php 

    //Per obtenir la connexió
    require_once 'connexio.php';


    function crear_incidencia($conn){

        //Obtenir la incidencia
        $nomIncidencia = $_POST['nom'];

        
        if(empty($nom)){
            echo "<p class='error'>El nom de la incidència no pot estar buit.</p>";
            return;
        }
    }
