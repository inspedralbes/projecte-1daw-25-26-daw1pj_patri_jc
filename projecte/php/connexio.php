<?php

$servername = "db"; // Nom del servei
$username = getenv('VAR1'); // Usuari (getenv = llegir les variables d'entorn)
$password = getenv('VAR2'); // Contrasenya (getenv = llegir les variables d'entorn)
$dbname = "incidenciesDB"; // Nom de la base de dades


//CREAR LA CONNEXIÓ
$conn = new mysqli($servername, $username,$password,$dbname);


//COMPROVA LA CONNEXIÓ (si connect_error te algu valor)
if ($conn->connect_error){

    echo "<p>Error de connexió: " . htmlspecialchars($conn->connect_error) . "</p>";
    die("Error de connexió: " . $conn->connect_error);// La resta de PHP no es fa
}
