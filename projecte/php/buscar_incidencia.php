<?php include './header-footer/header.php' ?>

<main >
    
    <div class="text-center mt-5">
        <h1>Cercador d'Incidències</h1>
        <hr class="border border-primary border-3 opacity-75 mb-5 w-50 mx-auto">
    </div>

    <!-- Buscar por departamento -->
     <div class= "col-6 mx-auto">
        <form method="post" class="border rounded border-dark p-5">
            <div class="mb-5">
                <label for="b_departament" class="form-label d-block">
                    Buscar per departament
                </label>
                <select class="form-select" aria-label="Selecciona departament" name="departament" id= "b_departament">
                    <option selected disabled>Selecciona...</option>
                    <option value="Angles">Llengua Anglesa</option>
                    <option value="Catala">Llengua Catalana</option>
                    <option value="Historia">Història</option>
                    <option value="Biologia">Biologia</option>
                    <option value="Matematiques">Matemàtiques</option>
                    <option value="Informatica">Informàtica</option>
                    <option value="Administracio">Administració</option>
                    <option value="Direccio">Direcció</option>             
                </select>      
            </div>

    <!-- Buscar por id -->
            <div class="mb-5">
                <label for="id" class="form-label d-block">Buscar per identificador</label>
                <input type="text" class="form-control" id= "id" name="id"      placeholder="Número identificador ex: 13" inputmode="numeric" 
                pattern = "[0-9]*">
            </div>

            <input class= "btn btn-primary py-1" type="submit" value="Enviar">
        </form>
     </div>
        
        
    

</main>

    <!-- Hay que validar que el id sea valido y un num con php -->


 <?php
 include './header-footer/footer.php' ?>