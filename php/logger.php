<?php
    require 'vendor/autoload.php';

    function getCollection(){
        $uri = getenv('MONGODB_URI');

        if($uri){
            $client = new MongoDB\Client($uri);
            $collection = $client->incidencies->logs;
            
            return $collection;
        }
    }
    
    function inserirLog(){
        $collection = getCollection();

        if(!$collection){
            error_log("MONGODB no té URI configurada.");
            return;
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconegut';
        date_default_timezone_set('Europe/Madrid');
        $data = date('Y-m-d H:i:s');
        $rol = $_GET['rol'] ?? '';

        $collection->insertOne([
            'url' => $_SERVER['REQUEST_URI'],
            'metode' => $_SERVER['REQUEST_METHOD'],
            'rol' => $rol,
            'data' => $data,
            'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'ip' => $ip
        ]);
    }   

    function filtrarDocuments($collections, $date, $usuari, $pagina){
    $documents = $collections->find();
    $resultado = [];
    foreach($documents as $document){
        if(!empty($date) && substr($document['data'] ?? '', 0, 10) !== $date){
            continue;
        }
        if(!empty($usuari) && ($document['rol'] ?? '') !== $usuari){
            continue;
        }
        if(!empty($pagina) && strpos($document['url'] ?? '', $pagina) === false){
            continue;
        }
        $resultado[] = $document;
    }
    return $resultado; 
}
?>