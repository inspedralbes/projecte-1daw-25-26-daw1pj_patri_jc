<?php
    //funcio que retorna les incidencies d'un departament concret segond l'id
    function llistar_incidencies($conn, $id_dept){
        $sql="SELECT I.ID_INCIDENCIA, I.DATA_INICI, I.DATA_FI, I.DESCRIPCIO, D.NOM_DEPT
        FROM INCIDENCIA I 
        LEFT JOIN DEPARTAMENT D ON I.ID_DEPT = D.ID_DEPT
        WHERE I.ID_DEPT = ?";

        $stmt = $conn -> prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $incidencies = $result->fetch_all(MYSQLI_ASSOC);

        return $incidencies;
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
           cercarPerDept($conn, $id_dept);
        }
    }

    //Cerca les incidencies per el id del departament i redirigeix a la pagina
    function cercarPerDept($conn, $id_dept){
        $sql = "SELECT ID_DEPT FROM DEPARTAMENT
        WHERE ID_DEPT = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_dept);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            //redirige a la pagina de incidencias de ese dept
            header("Location: llistar_incidencies.php?id=$id_dept"); 
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
?>
