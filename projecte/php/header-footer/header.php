<?php 
$titol = "Gestió d'incidències";
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió d'incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav class="navbar" style="background-color: #D0F3F9;" data-bs-theme="light">
            <div class="container-fluid">
                <img src="./assets/logo.png" alt="Logo de l'institut Pedralbes" width="150" class="d-inline-block align-text-top">
                
                <span class="mb-0 me-5 h1 fs-2" style="color: #555555"><?php echo $titol; ?></span> 

                <a class="link-offset-2 link-offset-4-hover link-underline link-underline-opacity-0 mx-3" style="color: #43A9ED;" onmouseover="this.style.color='#0d6efd'"
                onmouseout="this.style.color='#43A9ED'" href="index.php">
                🏠︎ Inici
            </a>
            </div>
        </nav>
    </header>
</body>
</html>


            