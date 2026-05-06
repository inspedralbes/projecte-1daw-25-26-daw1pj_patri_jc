<?php include './header-footer/header.php'    
?>

<main class="d-flex align-items-center justify-content-center" style="min-height: 60vh">
    <div class="w-100 text-center">
        <h1>Portal d'Incidències</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 w-50 mx-auto">

        <div class="d-grid gap-4 col-lg-5 col-6 mx-auto">
            <h2 class="text-center mt-4">Entra com a:</h2>
            <a href="llistaIncidencies.php?idTecnic=1&rol=tecnic" class="btn btn-primary py-3 col-lg-5 col-8 mx-auto">Ermengol</a>

            <a href="llistaIncidencies.php?idTecnic=2&rol=tecnic" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Àlvaro</a>

            <a href="llistaIncidencies.php?idTecnic=3&rol=tecnic" class="btn btn-primary py-3 col-lg-5 mx-auto col-8">Gerard</a> 
        </div>
    </div>
</main>

 <?php
 include './header-footer/footer.php' ?>
 