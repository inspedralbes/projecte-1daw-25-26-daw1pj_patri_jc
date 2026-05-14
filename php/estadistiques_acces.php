<?php
include './header-footer/header.php';
require_once 'connexio.php';
require_once 'logger.php';

$collection = getCollection();
$documents = $collection->find();

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
    <!-------------------------------------- NAV -------------------------------------->
    <h4 class="text-primary mt-5 mx-5">Gràfiques</h4>
    <hr class="border border-primary border-3 opacity-75 mb-5 col-2 mx-4">

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid justify-content-center">
            <button onclick="showTopic('accesos')" id="btn-accesos" class="btn btn-outline-secondary active mx-3" type="button">Accesos</button>
            <button onclick="showTopic('pagines')" id="btn-pagines" class="btn btn-outline-secondary mx-3" type="button">Pàgines</button>
            <button onclick="showTopic('usuaris')" id="btn-usuaris" class="btn btn-outline-secondary mx-3" type="button">Usuaris</button>
        </div>
    </nav>

    <!-------------------------------------- ACCESOS -------------------------------------->
    <div id="accesos" class="active">
        
        <h5 class="text-center text-primary mt-5">Accessos a la pàgina</h5>
        <div class="row justify-content-center align-items-center mx-auto col-12">

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
            <div class=" mx-5 mt-4 col-lg-6">
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
<?php include './header-footer/footer.php'; ?>