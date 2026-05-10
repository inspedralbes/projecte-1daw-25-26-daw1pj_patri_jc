<?php include './header-footer/header.php'    
?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 60vh">
    <div class="w-100 text-center mt-5">
        <h1>Panell d'Administració</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 w-50 mx-auto">

        <div class="d-grid gap-4 col-lg-8 col-6 mx-auto pt-4">

            <a href="llistaIncidencies.php?rol=admin" class="btn btn-primary py-3 col-lg-5 col-8 mx-auto">Llista d'incidències</a>

            <a href="informe_tecnics.php?rol=admin" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Informes de tècnics</a>

            <a href="consum_dept.php?rol=admin" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Consum per departaments</a> 

            <a href="estadistiques_acces.php?rol=admin" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Estadístiques d'Accès</a> 
        </div>
    </div>
</main>

 <?php
 include './header-footer/footer.php' ?>
 