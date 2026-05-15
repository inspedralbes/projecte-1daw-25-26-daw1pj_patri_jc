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
$section = $_GET['section'] ?? 'grafiques';
$documents = filtrarDocuments($collection, $date, $usuari, $pagina);


//------------------------------------USUARIS------------------------------------//

$rolGr = $collection->aggregate([
    ['$match' => [
        'rol' => [
            '$nin' => [null, '', ' ']
        ]
    ]],
    ['$group' => [
        '_id' => '$rol',
        'total' => ['$sum' => 1]
    ]],
    ['$sort' => ['total' => -1]]
]);

$rolArray = iterator_to_array($rolGr);

$rolMesActiu = $rolArray[0]['_id'] ?? 'desconegut';
$rolMesActiuTotal = $rolArray[0]['total'] ?? null;

$rolMenysActiu = end($rolArray)['_id'] ?? 'desconegut';
$rolMenysActiuTotal = end($rolArray)['total'] ?? null;

$rollabels = [];
$rolvalors = [];

foreach ($rolArray as $rol) {
    $rollabels[] = $rol['_id'];
    $rolvalors[] = $rol['total'];
}

//------------------------------------PAGINES------------------------------------//

$paginesMesVisitadesGr = $collection->aggregate([
    ['$group' => [
        '_id' => '$url',
        'total' => ['$sum' => 1]
    ]],

    ['$sort' => ['total' => -1]],
]);

$pagArray = iterator_to_array($paginesMesVisitadesGr); //iterator_to_array converteix el res en una array normal de php.

$paginaMesVisitada = $pagArray[0] ?? null;
$paginaMesVisitadaTotal = $paginaMesVisitada['total'] ?? null;
$paginaMesVisitada = basename(parse_url($paginaMesVisitada['_id'], PHP_URL_PATH));

$paginaMenysVisitada = end($pagArray) ?? null; //Agafa la ultima
$paginaMenysVisitadaTotal = $paginaMenysVisitada['total'] ?? null;
$paginaMenysVisitada = basename(parse_url($paginaMenysVisitada['_id'], PHP_URL_PATH));

$top5Pagines = array_slice($pagArray, 0, 5); //Agafa les 5 primeress

$paglabels = [];
$pagvalors = [];

foreach ($top5Pagines as $pag) {
    $url = $pag['_id']; //Agafa la url de cada pagina

    $pagName = basename(parse_url($url, PHP_URL_PATH)); //Agafa el nom de la pagina a partir de la url, netejant-la de params.

    $paglabels[] = $pagName;
    $pagvalors[] =  $pag['total']; //Agafa el total de visites de cada pagina
}


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

    function graficaPagines() {
        const ctx = document.getElementById('graficaPagines').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($paglabels) ?>,
                datasets: [{
                    label: 'Pagines més visitades',
                    data: <?= json_encode($pagvalors) ?>
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function graficaRols() {
        const ctx = document.getElementById('graficaRols').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($rollabels) ?>,
                datasets: [{
                    label: 'Rols més actius',
                    data: <?= json_encode($rolvalors) ?>
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
</script>




<main class="d-flex flex-column flex-grow-1 pb-3">

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid justify-content-center">
            <button onclick="showSection('grafiques')" id="btn-grafiques" class="btn btn-outline-secondary btn btn-primary mx-3 <?= $section === 'grafiques' ? 'active' : '' ?>" type="button">
                📊
            </button>
            <button onclick="showSection('logs')" id="btn-logs" class="btn btn-outline-secondary mx-3 btn btn-primary <?= $section === 'logs' ? 'active' : '' ?>" type="button">
                📋
            </button>
        </div>
    </nav>

    <div>
        <h1 class=" text-center mt-5">Estadísiques d'Accès</h1>
        <hr class="border border-primary border-3 opacity-75  mx-auto col-8 col-lg-4">
    </div>


    <!-------------------------------------- NAV -------------------------------------->
    <div id="grafiques" class= "section <?= $section === 'grafiques' ? 'd-block' : 'd-none' ?> mb-5">
        <h4 class="text-primary mx-5">Gràfiques</h4>
        <hr class="border border-primary border-3 opacity-75 mb-1 col-4 col-lg-2 mx-4">

        <div class="container mx-auto col-10 col-lg-8 mt-4">
            <nav class="navbar bg-body-tertiary">
                <div class="container-fluid justify-content-center">
                    <button onclick="showTopic('accesos')" id="btn-accesos" class="btn btn-outline-secondary active mx-3" type="button">Accesos</button>
                    <button onclick="showTopic('pagines')" id="btn-pagines" class="btn btn-outline-secondary mx-3" type="button">Pàgines</button>
                    <button onclick="showTopic('rols')" id="btn-rols" class="btn btn-outline-secondary mx-3" type="button">Rols</button>
                </div>
            </nav>
        </div>


        <!---------------------------------- ROLS ---------------------------------->
        <div id="rols" class="tab d-none border border-light-subtle rounded p-5 col-10 col-lg-8 mx-auto mt-5">            
        <h5 class="text-center text-primary">Rols més actius</h5>

            <div class="row justify-content-center align-items-center mx-auto">

                <div class="d-flex flex-column col-lg-4 col-10 mt-3 gap-4">

                    <!-- + actiu -->
                    <div class="border border-dark-subtle rounded">
                        <div class="text-center p-2">
                            <p class="mt-2 fw-bold">Rol més actiu</p>
                            <h6 class="text-primary text-break"><?= $rolMesActiu ?></h6>
                            <small class="text-secondary"><?= $rolMesActiuTotal ?> accessos</small>
                        </div>
                    </div>

                    <!-- - actiu -->
                    <div class="border border-dark-subtle rounded">
                        <div class="text-center p-2">
                            <p class="mt-2 fw-bold">Rol menys actiu</p>
                            <h6 class="text-primary text-break"><?= $rolMenysActiu ?></h6>
                            <small class="text-secondary"><?= $rolMenysActiuTotal ?> accessos</small>
                        </div>
                    </div>

                </div>

                <!--Grafica -->
                <div class=" mx-5 mt-4 col-12 col-lg-6">
                    <canvas id="graficaRols"></canvas>
                    <script>
                        graficaRols();
                    </script>

                </div>

            </div>
        </div>

        <!---------------------------------- PAGINA ---------------------------------->
        <div id="pagines" class="tab d-none border border-light-subtle rounded p-5 col-10 col-lg-8 mx-auto mt-5">
                <h5 class="text-center text-primary">Pàgines més visitades</h5>

            <div class="row justify-content-center align-items-center mx-auto">

                <div class="d-flex flex-column col-lg-4 col-10 mt-3 gap-4">

                    <!-- + visitada -->
                    <div class="border border-dark-subtle rounded">
                        <div class="text-center p-2">
                            <p class="mt-2 fw-bold">Pàgina més visitada</p>
                            <h6 class="text-primary text-break"><?= $paginaMesVisitada ?></h6>
                            <small class="text-secondary"><?= $paginaMesVisitadaTotal ?> accessos</small>
                        </div>
                    </div>

                    <!-- - visitada -->
                    <div class="border border-dark-subtle rounded">
                        <div class="text-center p-2">
                            <p class="mt-2 fw-bold">Pàgina menys visitada</p>
                            <h6 class="text-primary text-break"><?= $paginaMenysVisitada ?></h6>
                            <small class="text-secondary"><?= $paginaMenysVisitadaTotal ?> accessos</small>
                        </div>
                    </div>
                </div>

                <!--Grafica -->
                <div class=" mx-5 mt-4 col-12 col-lg-6">
                    <canvas id="graficaPagines"></canvas>
                    <script>
                        graficaPagines();
                    </script>
                </div>

            </div>

        </div>


        <!---------------------------------- ACCESOS ---------------------------------->
        <div id="accesos" class="tab d-block border border-light-subtle rounded p-5 col-10 col-lg-8 mx-auto mt-5">

            <h5 class="text-center text-primary">Accessos a la pàgina</h5>
            <div class="row justify-content-center align-items-center mx-auto">

                <div class="d-flex flex-column col-lg-3 col-10 mt-3 gap-4">

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
                <div class=" mx-5 mt-4 col-12 col-lg-7">
                    <canvas id="graficaXDies"></canvas>
                    <script>
                        graficaXDies();
                    </script>
                </div>
            </div>

        </div>

    </div>

    <!-------------------------------------- LOGS -------------------------------------->
    <div id="logs" class="section <?= $section === 'logs' ? 'd-block' : 'd-none' ?> mb-5">
        <h4 class="text-primary mx-5">Logs</h4>
        <hr class="border border-primary border-3 opacity-75 mb-1 col-4 col-lg-2 mx-4">
        <div class="container mx-auto col-10 col-lg-8 mt-5">

            <div class="mb-3 p-3">

                <nav class="navbar navbar-expand-lg bg-body-tertiary p-3 ">
                    <form action="estadistiques_acces.php" method="get" class="w-100">
                        <input type="hidden" name="section" value="logs">
                        <div class="d-flex flex-wrap gap-3 align-items-center">


                            <div class="mx-auto col-12 col-lg-3  text-center text-lg-start">
                                <h5 class="text-primary mb-0 ">Data</h5>

                                <input type="date" name="date" id="date" value=<?= $date ?> class="form-control-sm mx-auto ">
                            </div>

                            <div class="mx-auto col-12 col-lg-3  text-center text-lg-start">
                                <h5 class="text-primary mb-0">Rol</h5>
                                <select name="usuari" id="usuari" class="form-control form-control-sm mx-auto">
                                    <option value="">Tots</option>
                                    <option value="usuari" <?= $usuari === 'usuari' ? 'selected' : '' ?>>Usuari</option>
                                    <option value="tecnic" <?= $usuari === 'tecnic' ? 'selected' : '' ?>>Tècnic</option>
                                    <option value="admin" <?= $usuari === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>

                            <div class="mx-auto col-12 col-lg-3 text-center text-lg-start">
    <h5 class="text-primary mb-0">Pàgina</h5>
    <select name="pagina" id="pagina" class="form-control form-control-sm mx-auto">
        <option value="">Tots</option>
        <option value="/admin.php" <?= $pagina === '/admin.php' ? 'selected' : '' ?>>Admin</option>
        <option value="/tecnic.php" <?= $pagina === '/tecnic.php' ? 'selected' : '' ?>>Tècnic</option>
        <option value="/usuari.php" <?= $pagina === '/usuari.php' ? 'selected' : '' ?>>Usuari</option>
        <option value="/afegir_actuacio.php" <?= $pagina === '/afegir_actuacio.php' ? 'selected' : '' ?>>Afegir Actuació</option>
        <option value="/buscar_incidencia.php" <?= $pagina === '/buscar_incidencia.php' ? 'selected' : '' ?>>Buscar Incidència</option>
        <option value="/crear_incidencies.php" <?= $pagina === '/crear_incidencies.php' ? 'selected' : '' ?>>Crear Incidència</option>
        <option value="/detall_incidencia.php" <?= $pagina === '/detall_incidencia.php' ? 'selected' : '' ?>>Detall Incidència</option>
        <option value="/llistaIncidencies.php" <?= $pagina === '/llistaIncidencies.php' ? 'selected' : '' ?>>Llista Incidències</option>
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
                            <th scope="col">Data</th>
                            <th scope="col">Navegador</th>
                            <th scope="col">IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documents as $document): ?>
                            <tr>
                                <td><?= strtok($document['url'], '?') ?></td>
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
<div class="mt-auto col-12 col-lg-12 px-3 mx-auto p-3">
            <a class=" mb-5 bottom-0 start-0 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="admin.php">
                🢘 Panell d'administració
            </a>
    </div>

<script>

    //Canvi de pestanya
    const topics = ['accesos', 'pagines', 'rols'];

    function showTopic(topic) {
        
    // Amagar totes
    topics.forEach(t => {
        const tabDiv = document.getElementById(t);
        const btn = document.getElementById(`btn-${t}`);
        if (tabDiv) {
            tabDiv.classList.remove('d-block');
            tabDiv.classList.add('d-none');
        }
        if (btn) btn.classList.remove('active');
    });
    
    // Mostrar la seleccionada
    const selectedTab = document.getElementById(topic);
    const selectedBtn = document.getElementById(`btn-${topic}`);
    if (selectedTab) {
        selectedTab.classList.remove('d-none');
        selectedTab.classList.add('d-block');
    }
    if (selectedBtn) selectedBtn.classList.add('active');
}

    function showSection(section) {
        document.querySelectorAll('.section').forEach(s => {
            s.classList.remove('d-block');
            s.classList.add('d-none');
        });
        document.getElementById(section).classList.remove('d-none');
        document.getElementById(section).classList.add('d-block');

         if (section === 'grafiques') {
        showTopic('accesos');
    }
    }

    // Inicialitzar
if (document.getElementById('grafiques').classList.contains('d-block')) {
    showTopic('accesos');
}
</script>

<?php
include './header-footer/footer.php' ?>