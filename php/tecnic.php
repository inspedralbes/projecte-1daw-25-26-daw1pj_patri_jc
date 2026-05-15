<?php include './header-footer/header.php'    
?>

<main class="d-flex flex-column flex-grow-1 pb-3">
    <div class="col-12 text-center mb-3 mt-5 pt-5">
        <h1>Portal Tècnics</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 col-lg-4 col-10 mx-auto">

        <div class="d-grid gap-4 col-lg-5 col-6 mx-auto">
            <h2 class="text-center mt-2">Entra com a:</h2>
            <a href="llistaIncidencies.php?idTecnic=1&rol=tecnic" class="btn btn-primary py-3 col-lg-5 col-8 mx-auto">Ermengol</a>

            <a href="llistaIncidencies.php?idTecnic=2&rol=tecnic" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Àlvaro</a>

            <a href="llistaIncidencies.php?idTecnic=3&rol=tecnic" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Gerard</a> 
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
 