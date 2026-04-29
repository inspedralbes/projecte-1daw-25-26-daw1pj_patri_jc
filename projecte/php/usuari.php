<?php include './header-footer/header.php' ?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 60vh">
    <div class="w-100 text-center">
        <h1>Portal d'Incidències</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 w-50 mx-auto">

        <div class="d-grid gap-4 col-3 mx-auto">
            <h2 class="text-center mt-4">Usuari</h2>
            <a class="btn btn-primary py-3" href="crear_incidencies.php">
                    Nova incidència
            </a>
            <a class="btn btn-primary py-3" href="buscar_incidencia.php?rol=usuari">
                    Veure estat incidència
            </a>
        </div>
    </div>
</main>

 <?php
 include './header-footer/footer.php' ?>
 