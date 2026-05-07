<?php
    //Fer update a incidencies prioritat i tecnic
    function updateIncidencia($conn, $id, $prioritat, $idTecnic, $idTipus){

        //Actualitza els tres camps
        if(!empty($prioritat) && !empty($idTecnic) && !empty($idTipus)){
            $sql= "UPDATE INCIDENCIA SET PRIORITAT = ?, ID_TECNIC = ?, ID_TIPUS = ?
            WHERE ID_INCIDENCIA = ?";

            $stmt = $conn->prepare($sql);
            $stmt-> bind_param("siii", $prioritat, $idTecnic, $idTipus, $id);
            
        }        
        //Actualitza la prioritat
        elseif(!empty($prioritat) && empty($idTecnic) && empty($idTipus)){
            $sql= "UPDATE INCIDENCIA SET PRIORITAT = ?
            WHERE ID_INCIDENCIA = ?";

            $stmt = $conn->prepare($sql);
            $stmt-> bind_param("si", $prioritat, $id);
        }
        //Actualitza el tecnic
        elseif(empty($prioritat) && !empty($idTecnic) && empty($idTipus)){
            $sql= "UPDATE INCIDENCIA SET ID_TECNIC = ? 
            WHERE ID_INCIDENCIA = ?";

            $stmt = $conn->prepare($sql);
            $stmt-> bind_param("ii", $idTecnic, $id);
        }
        //Actualitza el tipus
        elseif(empty($prioritat) && empty($idTecnic) && !empty($idTipus)){
            $sql= "UPDATE INCIDENCIA SET ID_TIPUS = ? 
            WHERE ID_INCIDENCIA = ?";

            $stmt = $conn->prepare($sql);
            $stmt-> bind_param("ii", $idTipus, $id);
        }
        //TODO: SI NO OMPLE CAP DELS DOS CAMPS ES RETORNA UN ERROR AMB JS

        $stmt->execute();
    }

   //Llista les incidències d'un tecnic segons el seu id
    function getIncidenciesTecnic($conn, $idTecnic){
            $sql = "SELECT i.ID_INCIDENCIA, i.DATA_INICI, i.DATA_FI,  i.PRIORITAT, i.DESC_INCIDENCIA,
            t.NOM_TECNIC 
            FROM INCIDENCIA i
            LEFT JOIN TECNIC t ON i.ID_TECNIC = t.ID_TECNIC
            WHERE i.ID_TECNIC = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i",$idTecnic);
            $stmt->execute();
            $result = $stmt->get_result();

            $incidenciesTec = $result->fetch_all(MYSQLI_ASSOC);

            return $incidenciesTec;
        } 
   
   //funcio que retorna les incidencies d'un departament concret segons l'id
    function getIncidenciesDept($conn, $id_dept){
        $sql="SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DATA_FI, I.DESC_INCIDENCIA, D.NOM_DEPT
        FROM INCIDENCIA I 
        LEFT JOIN DEPARTAMENT D ON I.ID_DEPT = D.ID_DEPT
        WHERE I.ID_DEPT = ?";

        $stmt = $conn -> prepare($sql);
        $stmt->bind_param("i", $id_dept);
        $stmt->execute();
        $result = $stmt->get_result();

        $incidenciesDept = $result->fetch_all(MYSQLI_ASSOC);

        return $incidenciesDept;
    }

    //Funcio per afegir l'estat a l'array d'incidencies
    function afegirEstat($conn, $incidencies){
        foreach($incidencies as &$inc){ // la & fa que es modifiqui a l'array original
            $actuacions = getActuacions($conn, $inc['ID_INCIDENCIA']);
            $resEstat = getEstat($actuacions, $inc);
            $inc['estat'] = $resEstat['estat'];
            $inc['classe'] = $resEstat['classe'];
        } 
        return $incidencies; //retorna la llista d'incidencies pero amb els camps nous estat i classe.
    }

    //retorna una array amb l'estat i la classe  que canvia el color segons l'estat
    function getEstat($actuacions, $incidencia){
        if($incidencia["DATA_FI"] !== null){
            return[
                "estat" => "Tancada",
                "classe" => "bg-danger bg-gradient"
            ];
        } elseif(!empty($actuacions)){
            return[
                "estat" => "En Procès",
                "classe" => "bg-warning bg-gradient"
            ];
        }else{
            return[
                "estat" => "Enviada",
                "classe" => "bg-success bg-gradient"
            ];
        }
    }

    //funcio que retorna una incidencia segons l'id de la mateixa
    function getIncidencia($conn, $id){
        $sql = "SELECT i.ID_INCIDENCIA, i.PRIORITAT, t.NOM_TIPUS, d.NOM_DEPT, i.DATA_INICI, i.DATA_FI, i.DESC_INCIDENCIA, tec.NOM_TECNIC
        FROM INCIDENCIA i
        LEFT JOIN TIPUS t ON i.ID_TIPUS = t.ID_TIPUS
        LEFT JOIN DEPARTAMENT d ON i.ID_DEPT = d.ID_DEPT
        LEFT JOIN TECNIC tec ON i.ID_TECNIC = tec.ID_TECNIC
        WHERE i.ID_INCIDENCIA = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
                
        $incidencia = $result->fetch_assoc();

        if (!$incidencia) {
            echo "<p class='error'>No s'ha trobat cap incidència.</p>";
            return;
        }

        return $incidencia;
    }

    //funcio que retorna totes les incidencies
    function getAllIncidencies($conn, $filtre, $filtre_estat, $ordre, $dir){
        $sql = "SELECT i.ID_INCIDENCIA, i.PRIORITAT, t.NOM_TIPUS, i.DATA_INICI, i.DATA_FI, i.DESC_INCIDENCIA, tec.NOM_TECNIC, d.NOM_DEPT
        FROM INCIDENCIA  i
        LEFT JOIN TIPUS t ON i.ID_TIPUS = t.ID_TIPUS
        LEFT JOIN DEPARTAMENT d ON i.ID_DEPT = d.ID_DEPT
        LEFT JOIN TECNIC tec ON i.ID_TECNIC = tec.ID_TECNIC
        WHERE 1=1"; //condicio que sempre es true per aixi poder posar la resta de condicions amb AND!

        if($filtre == 'no_assignades'){
            $sql .= " AND i.ID_TECNIC IS NULL";
        }elseif(is_numeric($filtre)){
            $sql .= " AND i.ID_TECNIC = $filtre";
        }

        if($filtre_estat == 'actives'){
            $sql .= " AND i.DATA_FI IS NULL";
        }

        $sql .= " ORDER BY $ordre $dir";

        $stmt = $conn->prepare($sql);

        if(is_numeric($filtre)){
        $stmt->bind_param("i", $filtre);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $incidencies = $result->fetch_all(MYSQLI_ASSOC);

        return $incidencies;
    }

    //funcio que retorna les actuacions d'una incidencia segons el seu id
    function getActuacions($conn, $id){
        $sql = "SELECT *
        FROM ACTUACIO
        WHERE ID_INCIDENCIA = ?
        ORDER BY DATA_ACTUACIO DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
                
        $actuacions = $result->fetch_all(MYSQLI_ASSOC);
    
        return $actuacions;
    }

    function cercar($conn, $rol){
        $id_dept = $_POST['departament'] ?? '';
        $id = $_POST['id'] ?? '';
        
        //Valida si els dos camps estan buits
        if(empty($id_dept) && empty($id)){
            echo "<p class='error'>Siusplau ompli un dels dos camps.</p>";
            return;
        }

        //Valida si els dos camps están omplerts alhora
        if(!empty($id_dept) && !empty($id)){
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
            cercarPerId($conn, $id, $rol);
        }
        
        //Cercar per departament
        if(!empty($id_dept)){
            cercarPerDept($conn, $id_dept, $rol);
        }
    }

    //Cerca les incidencies per el id del departament i redirigeix a la pagina
    function cercarPerDept($conn, $id_dept, $rol){
        $sql = "SELECT ID_DEPT FROM DEPARTAMENT
        WHERE ID_DEPT = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_dept);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            //redirige a la pagina de incidencias de ese dept
            header("Location: llistaIncidencies.php?id_dept=$id_dept&rol=$rol"); 
            exit;

        }else{
            echo "<p class='error'>No s'ha trobat cap incidència.</p>";
            return;
        }
    }

    //Cerca les incidencies per id redirigeix a la pagina de la mateixa i mostra mes info segons el rol.
    function cercarPerId($conn, $id, $rol){
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
    //Funcio que retorna tots els tecnics
    function getAllTipus($conn){
        $sql= "SELECT * FROM TIPUS";

        $stmt=$conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    //Funcio que retorna tots els tecnics
    function getAllTecnics($conn){
        $sql= "SELECT * FROM TECNIC";

        $stmt=$conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    function getNomTecnic ($conn, $id){
        $sql = "SELECT NOM_TECNIC 
        FROM TECNIC 
        WHERE ID_TECNIC = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
         $fila = $result->fetch_assoc();

        if ($fila == null){
            return "Tècnic";
        }else {
            return $fila["NOM_TECNIC"];
        }
    }

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

    function afegir_actuacions($conn, $idIncidencia, $rol){
        
        $temps = $_POST['temps'] . ':00';

        if(empty($temps)){
            echo "<p class='error'>No has posat el temps que has dedicat per fer la incidència.</p>";
            return;
        }

        $data = $_POST['dataActuacio'];

        if(empty($data)){
            echo "<p class='error'>No has posat la data de la incidència.</p>";
            return;
        }

        $desc = $_POST['desc'];

        if(empty($desc)){
            echo "<p class='error'>No has posat res de en la descripcio.</p>";
            return;
        }

        if(isset($_POST['visible'])){
            $visible = 1;
        }else{
            $visible = 0;
        }

        

        $sql = "INSERT INTO ACTUACIO (data_actuacio, desc_actuacio, temps, es_visible, id_incidencia)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii",$data , $desc, $temps, $visible, $idIncidencia);


        if($stmt->execute()){
        $id = $stmt->insert_id;
        echo "<script> window.location.href = 'confirmacio.php?id=" . $id . "&rol=" . $rol . "'; </script>";
        exit();
        }   
        else {
        echo "<p class='error'> Error al crear la actuació: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    }

    function esVisible($conn, $idIncidencia){
        $sql = "SELECT es_visible 
        FROM ACTUACIO 
        WHERE id_incidencia = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idIncidencia);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();

        if($fila["es_visible"] == 0){
            return 0;
        }else{
            return 1;
        }


    }

?>
