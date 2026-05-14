<?php
include './header-footer/header.php';
require_once 'connexio.php';
require_once 'logger.php';

$collection = getCollection();


//------------------------------------LOGS------------------------------------//
    $date = $_GET['date'] ?? date('Y-m-d');
    $usuari = $_GET['usuari'] ?? '';
    $pagina = $_GET['pagina'] ?? '';
    $documents = filtrarDocuments($collection,$date,$usuari,$pagina);

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

<nav class="navbar bg-body-tertiary mt-3">
    <div class="container-fluid justify-content-center">
        <button onclick="showSection('grafiques')" id="btn-grafiques" class="btn btn-outline-secondary btn btn-primary  mx-3" type="button">
            📊
        </button>
        <button onclick="showSection('logs')" id="btn-logs" class="btn btn-outline-secondary mx-3 btn btn-primary" type="button">
            📋
        </button>
    </div>
</nav>



    <div>
        <h1 class=" text-center mt-5">Estadísiques d'Accès</h1>
        <hr class="border border-primary border-3 opacity-75  mx-auto col-4">
    </div>
    <!-------------------------------------- NAV -------------------------------------->

    <div id="grafiques" class="section d-block">
    <h4 class="text-primary  mx-5">Gràfiques</h4>
    <hr class="border border-primary border-3 opacity-75 mb-1 col-3 col-lg-2 mx-4">

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
    <div id="accesos" class="active border border-light-subtle rounded p-5 col-10 col-lg-8  mx-auto mt-5">
        
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
            <div class=" mx-5 mt-4 col-lg-7 col-12">
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
</div>
    
    <!-------------------------------------- LOGS -------------------------------------->
    <div id="logs" class="section d-none">
    <h4 class="text-primary mx-5">Logs</h4>
    <hr class="border border-primary border-3 opacity-75 mb-1 col-3 col-lg-2 mx-4">
    <div class="container mx-auto col-10 col-lg-8 mt-5">

    <div class = "mb-3 p-3">
        
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-3 ">
    <form action="estadistiques_acces.php" method="get" class = "w-100">
    <div class = "d-flex flex-wrap gap-3 align-items-center">
        
    
    <div class= "mx-auto col-12 col-lg-3  text-center text-lg-start">
            <h5 class ="text-primary mb-0 ">Data</h5>
        
        <input type="date" name="date" id="date" value = <?= $date?> class ="form-control-sm mx-auto ">
        </div>
        
        <div class= "mx-auto col-12 col-lg-3  text-center text-lg-start">
            <h5 class ="text-primary mb-0">Rol</h5>
    <select name="usuari" id="usuari" class="form-control form-control-sm mx-auto">
        <option value="">Tots</option>
        <option value="usuari" <?= $usuari === 'usuari' ? 'selected' : '' ?>>Usuari</option>
        <option value="tecnic" <?= $usuari === 'tecnic' ? 'selected' : '' ?>>Tècnic</option>
        <option value="admin" <?= $usuari === 'admin' ? 'selected' : '' ?>>Administrador</option>
    </select>    
        </div>

        <div class= "mx-auto col-12 col-lg-3  text-center text-lg-start">
            <h5 class ="text-primary mb-0">Pàgina    </h5>
    <select name="pagina" id="pagina" class="form-control form-control-sm mx-auto">
            <option value="">Tots</option>
            <option value="admin" <?= $pagina === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="tecnic" <?= $pagina === 'tecnic' ? 'selected' : '' ?>>Tècnic</option>
            <option value="usuari" <?= $pagina === 'usuari' ? 'selected' : '' ?>>Usuari</option>
            <option value="afeguir_actuacio" <?= $pagina === 'afeguir_actuacio' ? 'selected' : '' ?>>Afegir Actuació</option>
            <option value="buscar_incidencia" <?= $pagina === 'buscar_incidencia' ? 'selected' : '' ?>>Buscar Incidència</option>
            <option value="crear_incidencies" <?= $pagina === 'crear_incidencies' ? 'selected' : '' ?>>Crear Incidència</option>
            <option value="detall_incidencia" <?= $pagina === 'detall_incidencia' ? 'selected' : '' ?>>Detall Incidència</option>
            <option value="llistaIncidencies" <?= $pagina === 'llistaIncidencies' ? 'selected' : '' ?>>Llista Incidències</option>
    </select>

        </div>
        


    

        <button class="btn btn-outline-success  bottom-25 end-0 mx-auto" type="submit">Search</button>
    </div>
    </form>
</nav>
    </div>
     

    <div class="table-responsive overflow-auto mb-5" style="max-height: 400px;">
        
    
    
    
    <!--Taula de estadisiques-->
   <table class="table table-bordered table-striped">
    <thead class="position-sticky top-0 table-primary" style="box-shadow: 0 2px 0 0 #0d6efd;">
        <tr>
            <th scope="col">URL</th>
            <th scope="col">Metode</th>
            <th scope="col">Rol</th>
            <th scope="col">Data
            <th scope="col">Navegador</th>
            <th scope="col">IP</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $document): ?>
        <tr>
            <td><?= substr($document['url'], 0, 24) ?></td>
            <?php $color = $document['metode'] === 'GET' ? 'success' : 'primary'; ?>
            <td class="text-center"><span class="badge bg-<?= $color ?>"><?= $document['metode'] ?></span></td>
            <td><?= $document['rol'] ?></td>
            <td><?= $document['data'] ?></td>
            <td><?= $document['navegador'] ?></td>
            <td><?= $document['ip'] ?></td>
        </tr>
        <?php endforeach; ?>
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

    function showSection(section){
    document.querySelectorAll('.section').forEach(s => {
        s.classList.remove('d-block');
        s.classList.add('d-none');
    });
    document.getElementById(section).classList.remove('d-none');
    document.getElementById(section).classList.add('d-block');
}
</script>

 <?php
 include './header-footer/footer.php' ?>
