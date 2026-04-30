<?php include './header-footer/header.php';
    require_once 'connexio.php';  
    $rol = $_GET['rol'] ?? 'usuari';
    $idTecnic = $_GET['idTecnic'] ?? '';
    $nomTecnic = null;


    if ($rol == 'usuari'){
        echo "<script> window.location.href = 'index.php'; </script>";
        echo "<p>No tens el rol corresponent.</p>";
        exit();
    }else{

        $sql = "SELECT NOM_TECNIC FROM TECNIC WHERE ID_TECNIC = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idTecnic);

        if($stmt->execute()){
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $nomTecnic = $row['NOM_TECNIC'];
        }
        }

        function llistarIncidencies($conn, $idTecnic){
            // Consulta SQL per obtenir totes les files de la taula 'cases'
    $sql = "SELECT ID_INCIDENCIA,DATA_INICI, PRIORITAT, DESC_INCIDENCIA 
    FROM INCIDENCIA
     WHERE ID_TECNIC = ?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("i",$idTecnic);
     $stmt->execute();
    $result = $stmt->get_result();

    // Comprovar si hi ha resultats
    if ($result->num_rows > 0) {

        // Llistar els resultats. 
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td style = 'color: #F28508'>" . $row["ID_INCIDENCIA"] . "</td>
                <td>" . $row["DATA_INICI"] . "</td>
                <td>" . $row["PRIORITAT"] . "</td>
                <td>" . htmlspecialchars($row["DESC_INCIDENCIA"])  . "</td>
             </tr>";
        }

    } else {
        echo "<tr><td colspan='5' class = 'text-center p-3'>No hi ha incidències.</td></tr>";
    }
        }

        
    
?>

<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista</title>
</head>
<body>
    <h1 class = "mt-5 ms-4 text-center">Benvingut, <span style = "color: #F28508"><?php echo $nomTecnic ?>!</span></h1>

    <div class = "mx-auto mt-5 col-lg-8 col-10">
        <table class = "table table-bordered ">
        <thead >
            <th >ID</th>
            <th>Data Inicial</th>
            <th>Prioritat</th>
            <th>Descripció</th>
        </thead>

        <tbody>
            <?php llistarIncidencies($conn,$idTecnic)?>
        </tbody>
    </table>
    </div>
    
</body>
</html>









<?php include './header-footer/footer.php';?>