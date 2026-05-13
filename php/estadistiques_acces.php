<?php
include './header-footer/header.php';
require_once 'connexio.php';
require_once 'logger.php';

$collection = getCollection();
$documents = $collection->find();

//------------------------------------LOGS------------------------------------//
$date = $_GET['date'] ?? date('Y-m-d');
    $usuari = $_GET['usuari'] ?? '';
    $pagina = $_GET['pagina'] ?? '';


//------------------------------------ACCESSOS------------------------------------//
$totalAccesos =  $collection->countDocuments();

$data_avui = date('Y-m-d');
$accesosAvui = $collection->countDocuments([
    'data' => ['$gte' => $data_avui . ' 00:00:00', '$lte' => $data_avui . ' 23:59:59']
    //guarda els logs que son entre avui a les 00 i les 23:59
]);

$estadAccessAvui = $collection->aggregate([
    ['$group' => [
        '_id' => ['$substr' => ['$data', 0, 10]],
        'total' => ['$sum' => 1]
    ]], // Agrupa per data els accesos agafant desde la pos 0 del string fins la 10 i després suma 1 per a aquella data al total.
    ['$sort' => ['_id' => 1]]
]);

$accessosTotals = [];
$dies = [];

foreach ($estadAccessAvui as $e) { //separa el res de la agregacio en dos arrays relacionats per posicio   
    $dies[] = $e['_id'];
    $accessosTotals[] = $e['total'];
}
?>

<script>
    function graficaXDies() {
        //canvas grafica dies
        const ctx = document.getElementById('graficaXDies').getContext('2d');
        new Chart(ctx, { //crea una grafica nova
            type: 'line',
            data: {
                labels: <?= json_encode($dies) ?>, //json_encode es un traductor entre php i js
                datasets: [{
                    label: 'Accessos per dia',
                    data: <?= json_encode($accessosTotals) ?>
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false //aixo oculta la llegenda
                    }
                }
            }
        });
    }
</script>

<main class="d-flex flex-column flex-grow-1 pb-3">
    <div>
        <h1 class=" text-center mt-5">Estadísiques d'Accès</h1>
        <hr class="border border-primary border-3 opacity-75  mx-auto col-4">
    </div>
    <!-------------------------------------- NAV -------------------------------------->
    <h4 class="text-primary mt-5 mx-5">Gràfiques</h4>
    <hr class="border border-primary border-3 opacity-75 mb-1 col-2 mx-4">

<div class="container mx-auto col-10 col-lg-8 mt-5">
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid justify-content-center">
            <button onclick="showTopic('accesos')" id="btn-accesos" class="btn btn-outline-secondary active mx-3" type="button">Accesos</button>
            <button onclick="showTopic('pagines')" id="btn-pagines" class="btn btn-outline-secondary mx-3" type="button">Pàgines</button>
            <button onclick="showTopic('usuaris')" id="btn-usuaris" class="btn btn-outline-secondary mx-3" type="button">Usuaris</button>
        </div>
    </nav>
</div>

    <!-------------------------------------- divs -------------------------------------->
    <div id="accesos" class="active border border-light-subtle rounded p-5 col-8 mx-auto mt-5">
        
        <h5 class="text-center text-primary">Accessos a la pàgina</h5>
        <div class="row justify-content-center align-items-center mx-auto">

            <div class="d-flex flex-column col-lg-2 col-8 mt-3 gap-4">

                <div class="border border-dark-subtle rounded">
                    <!--Accessos totals-->
                    <div class="text-center p-2">
                        <p class="mt-2 fw-bold">Accessos totals</p>
                        <h3 class="text-primary"><?= $totalAccesos ?></h3>
                    </div>
                </div>
                <!--Accessos avui-->
                <div class="border border-dark-subtle rounded">
                    <div class="text-center p-2">
                        <p class="mt-2 fw-bold">Accessos avui</p>
                        <h3 class="text-primary"><?= $accesosAvui ?></h3>
                    </div>
                </div>

            </div>

            <!--Grafica -->
            <div class=" mx-5 mt-4 col-lg-8">
                <canvas id="graficaXDies"></canvas>
                <script>
                    graficaXDies();
                </script>
            </div>
        </div>

    </div>


    <div id="pagines">
        blublu
    </div>
    <div id="usuaris">
        bleble
    </div>
    <hr class="border border-light-subtle border-1 opacity-75 my-5 mx-4">
    <!-------------------------------------- LOGS -------------------------------------->

    <h4 class="text-primary mx-5">Logs</h4>
    <hr class="border border-primary border-3 opacity-75 mb-1 col-2 mx-4">
    <div class="container mx-auto col-10 col-lg-8 mt-5">

    <div class = "mb-3 p-3">
        
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-3 ">
    <form action="estadistiques.php" method="get">
    <div class = "d-flex gap-5">

        <h5 class ="text-primary">Data</h5>
        
        <input type="date" name="date" id="date" value = <?= date('Y-m-d')?> class = "form-control w-50 ">

        <h5 class ="text-primary">Rol</h5>
        <select name="usuari" id="usuari" class = "form-control form-control-sm w-25">
            <option selected value="">Tots</option>
            <option value="usuari">Usuari</option>
            <option value="tecnic">Tècnic</option>
            <option value="admin">Administrador</option>
        </select>

        <h5 class ="text-primary">Pàgina    </h5>
        <select name="pagina" id="pagina" class = "form-control form-control-sm w-25">
            <option selected value="">Tots</option>
            <option value="admin">Admin</option>
            <option value="tecnic">Tècnic</option>
            <option value="usuari">Usuari</option>
            <option value="afeguir_actuacio">Afegir Actuació</option>
            <option value="buscar_incidencia">Buscar Incidència</option>
            <option value="confromacio">Confirmació</option>
            <option value="consum_dept">Cosnum per Departament</option>
            <option value="crear_incidencies">Crear Incidència</option>
            <option value="detall_incidencia">Detall Incidència</option>
            <option value="estadistiques_acces">Estadísiques d'Àcces</option>
            <option value="index">Index</option>
            <option value="informe_tecnics">Informe Tècnics</option>
            <option value="llistaIncidencies">Llista Incidències</option>
            <option value="modificar_incidencia">Modificar Incidència</option>
            
        </select>

        <button class="btn btn-outline-success position-absolute bottom-25 end-0 mx-4" type="submit">Search</button>
    </div>
    </form>
</nav>
    </div>
     

    <div class="overflow-auto mb-5" style="max-height: 400px;">
        
    
    
    
    <!--Taula de estadisiques-->
    <table class="table table-bordered table-striped ">

            <thead class="position-sticky top-0 table-primary" style="box-shadow: 0 2px 0 0 #0d6efd;">
                <tr>
                    <th>URL</th>
                    <th>Metode</th>
                    <th>Rol</th>
                    <th>Data</th>
                    <th>Navegador</th>
                    <th>IP</th>
                </tr>
            </thead>

            <tbody >
                <tr>
                    <?php foreach ($documents as $document) {
    
                    ?>
                    <td><?= substr($document['url'], 0, 24)?></td>
                    <?php $color = $document['metode'] === 'GET' ? 'success' : 'primary';?>
                    <td class = "text-center"><span class="badge bg-<?= $color ?>"><?= $document['metode'] ?></span></td>
                    <td><?= $document['rol']?></td>
                    <td><?= $document['data']?></td>
                    <td><?= $document['navegador']?></td>
                    <td><?= $document['ip']?></td>

                    
                </tr>
                <?php } ?>
            </tbody>
    </table>
</div>
</div>
</main>

<script>
    //Canvi de pestanya
    const topics = ['accesos', 'pagines', 'usuaris'];

    function showTopic(topic) {

        topics.forEach(t => {
            document.getElementById(t).classList.remove('active');
            document.getElementById(`btn-${t}`).classList.remove('active');
        });

        document.getElementById(topic).classList.add('active');
        document.getElementById(`btn-${topic}`).classList.add('active');
    }
</script>

 <?php
 include './header-footer/footer.php' ?>
