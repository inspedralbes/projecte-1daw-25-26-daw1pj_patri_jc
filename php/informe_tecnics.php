<?php
require_once 'connexio.php';
require_once 'funcions.php';

$consum = getInformeTecnic($conn);

include './header-footer/header.php';
?>

<main>

<div class="container mx-auto col-10 col-lg-8 mt-5">


    <div>
        <h1 class="text-primary text-center"> Informe Tècnics</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 mx-auto">
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Tecnic</th>
                <th>Nom Tècnic</th>
                <th>Prioritat</th>
                <th>ID Incidència</th>
                <th>Descripció Incidència</th>
            </tr>
            
        </thead>

        <tbody>
            <?php if(!empty($consum)):?>
                <?php foreach($consum as $tecnic):?>
                    <tr>
                        <td><?= $tecnic["ID_TECNIC"] ?></td>
                        <td><?= $tecnic["nomTecnic"]?></td>
                        <td><?= $tecnic["PRIORITAT"]?></td>
                        <td><?= $tecnic["ID_INCIDENCIA"]?></td>
                        <td><?= $tecnic["descripcioIncidencia"]?></td>
                    </tr>
                <?php endforeach;
                else:?>
                <tr>
                    <td colspan="3" class="text-center text-muted">No hi ha dades</td>
                </tr>
                <?php endif; ?>
        </tbody>
    </table>

    

</div>

    <div class="mt-auto col-10 col-lg-12 px-3 mx-auto">
            <a class=" mb-5 ms-5 position-absolute bottom-0 start-0 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="admin.php">
                🢘 Panell d'administració
            </a>
    </div>
</main>

<?php 
    include './header-footer/footer.php';?>