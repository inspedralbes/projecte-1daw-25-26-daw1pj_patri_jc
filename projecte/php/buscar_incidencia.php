<?php
    require_once 'connexio.php';
    require_once 'funcions.php';

    $rol = $_GET['rol'] ?? 'usuari';

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        cercar($conn, $rol);
    }       

    include './header-footer/header.php'; 
?>

<main class="d-flex flex-column flex-grow-1 pb-3">
    <div class="text-center mt-5">
        <h1>Cercador d'Incidències</h1>
        <hr class="border border-primary border-3 opacity-75 rounded mb-5 col-10 col-lg-4 mx-auto">
    </div>  
            <!-- Buscar por departamento -->
                <div class= "col-10 col-lg-4 mx-auto">
                    <form method="post" class="border rounded border-dark p-5">
                        <div class="mb-5">
                            <label for="b_departament" class="form-label d-block">
                                Buscar per departament
                            </label>
                            <select class="form-select" aria-label="Selecciona departament" name="departament" id= "b_departament">
                                <option value="">Selecciona...</option>
                                <option value="1">Llengua Anglesa</option>
                                <option value="2">Llengua Catalana</option>
                                <option value="3">Història</option>
                                <option value="4">Biologia</option>
                                <option value="5">Matemàtiques</option>
                                <option value="6">Informàtica</option>
                                <option value="7">Administració</option>
                                <option value="8">Direcció</option>  
                                <option value="9">Altres</option>             
                    
                            </select>      
                        </div>

                <!-- Buscar por id -->
                        <div class="mb-5">
                            <label for="id" class="form-label d-block">Buscar per identificador</label>
                            <input type="text" class="form-control" id= "id" name="id" placeholder="Número identificador ex: 13" inputmode="numeric" 
                            pattern = "[0-9]*">
                        </div>

                        <input class= "btn btn-primary py-1" type="submit" value="Enviar">
                    </form>
                </div> 
    <div class="mt-auto col-10 col-lg-12 px-3 mx-auto">
        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="usuari.php">
            🢘 Torna al Menú Usuari
        </a>
    </div>
</main>

 <?php
 include './header-footer/footer.php' ?>
