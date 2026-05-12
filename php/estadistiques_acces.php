<?php 
    include './header-footer/header.php';
    require_once 'connexio.php'; 
    require_once 'logger.php'; 

    $collection = getCollection();
    $documents = $collection->find();
    
    foreach ($documents as $document) {
        echo $document['url'] . " - " . $document['ip'] . " - " . $document['rol'] . " - " . $document['metode'] . "<br>";
    }
?>
