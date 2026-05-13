<?php 
    include './header-footer/header.php';
    require_once 'connexio.php'; 
    require_once 'logger.php'; 

    $collection = getCollection();
    $documents = $collection->find();

    $date = $_GET['date'] ?? date('Y-m-d');
    $usuari = $_GET['usuari'] ?? '';
    $pagina = $_GET['pagina'] ?? '';
    
    
?>

<main class="d-flex flex-column flex-grow-1 pb-3">



    <div class="container mx-auto col-10 col-lg-8 mt-5">


    <div>
        <h1 class="text-primary text-center">Estadísiques d'Accès</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 mx-auto">
    </div>

    <div class = "mb-3 p-3">
        
    <h4 class="text-primary">Filtres</h4>

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
     

    <div class="overflow-auto" style="max-height: 400px;">
        
    
    
    
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


 <?php
 include './header-footer/footer.php' ?>
