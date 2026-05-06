<?php

include './header-footer/header.php' ?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 70vh">
        <div class="w-100 text-center">
            <h1>Benvinguts!</h1>
            <hr class="border border-primary border-3 opacity-75 mb-5 col-lg-3  col-6 mx-auto">

            <div class="d-grid gap-4 col-lg-3 col-8 mx-auto">
                <a class="btn btn-primary py-3" href="usuari.php">
                    Entra com a Usuari
                </a>
                <a class="btn btn-primary py-3" href="tecnic.php">
                    Entra com a Tècnic
                </a>
                <a class="btn btn-primary py-3" href="llistaIncidencies.php?rol=admin">
                    Entra com a Admin
                </a>
            </div>
        </div>
</main>

 <?php
 include './header-footer/footer.php' ?>