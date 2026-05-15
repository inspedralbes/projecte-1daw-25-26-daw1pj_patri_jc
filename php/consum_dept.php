<?php
require_once 'connexio.php';
require_once 'funcions.php';

$consum = getConsumDepartaments($conn);

include './header-footer/header.php';
?>

<main>

<div class="container mx-auto col-10 col-lg-8 mt-5">


    <div>
        <h1 class="text-primary text-center"> Consum per Departemanets</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 mx-auto">
    </div>
    
    <div class="table-responsive overflow-auto mb-5" style="max-height: 400px;">
    <table class="table table-bordered table-striped">
        <thead class="position-sticky top-0 table-primary" style="box-shadow: 0 2px 0 0 #0d6efd;">
            <tr>
                <th>Departament</th>
                <th>Total incidències</th>
                <th>Total temps dedicat (HH:MM)</th>
            </tr>
            
        </thead>

        <tbody>
            <?php if(!empty($consum)):?>
                <?php foreach($consum as $dept):?>
                    <tr>
                        <td><?= $dept["nomDepartament"] ?></td>
                        <td><?= $dept["nombreIncidencies"]?></td>
                        <td><?= $dept["tempsTotalDedicat"]?></td>
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

    

</div>

    <div class="mt-auto col-12 col-lg-12 px-3 mx-auto p-3">
            <a class=" mb-5 bottom-0 start-0 link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="admin.php">
                🢘 Panell d'administració
            </a>
    </div>
</main>

<?php 
    include './header-footer/footer.php';?>