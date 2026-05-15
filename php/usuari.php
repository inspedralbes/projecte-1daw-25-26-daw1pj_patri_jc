<?php include './header-footer/header.php' ?>

<main class="d-flex flex-column flex-grow-1 pb-3">
    <div class="col-12 text-center mt-5 pt-5">
        <h1>Portal Usuaris</h1>
        <hr class="border border-primary border-3 opacity-75 mb-3 col-9 col-lg-4 mx-auto">

        <div class="d-grid gap-4 col-lg-3 col-6 mx-auto">
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

<div class="mt-auto col-10 col-lg-12 px-3 py-3 mx-auto">
    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="index.php">
        🢘 Torna enrere
    </a>
</div>

<?php
include './header-footer/footer.php' ?>