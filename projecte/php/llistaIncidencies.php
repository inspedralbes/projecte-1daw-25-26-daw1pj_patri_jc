<?php
require_once 'connexio.php';
require_once 'funcions.php';

$rol = $_GET['rol'] ?? 'usuari';
$idTecnic = $_GET['idTecnic'] ?? '';
$id_dept = $_GET['id_dept'] ?? '';

if ($rol == 'tecnic' && !empty($idTecnic)) {
    $incidencies = getIncidenciesTecnic($conn, $idTecnic);
    $actuacions  = getActuacions($conn, $incidencies);
} elseif ($rol == 'usuari' && !empty($id_dept)) {
    $incidencies = getIncidenciesDept($conn, $id_dept);
    $nom_dept = $incidencies[0]['NOM_DEPT'] ?? 'Departament';
} elseif ($rol == 'admin') {
    $filtre = $_GET['filtre'] ?? '';
    $filtre_estat = $_GET['filtre_estat'] ?? 'actives';
    $ordre = $_GET['ordre'] ?? 'ID_INCIDENCIA';
    $dir = $_GET['dir'] ?? 'ASC';
    $incidencies = getAllIncidencies($conn, $filtre, $filtre_estat, $ordre, $dir);
    $incidencies = afegirEstat($conn, $incidencies);
    $tecnics = getAllTecnics($conn);
} else {
    header("Location: index.php");
    exit();
}
$nomTecnic = getNomTecnic($conn, $idTecnic);
include './header-footer/header.php';
?>

<main class="d-flex flex-column flex-grow-1 pb-3">

    <!-------------------------------------TECNIC--------------------------------------->
    <?php if ($rol == 'tecnic'):
        //El que veu el tecnic quan inicia sessió amb el seu nom   
    ?>

        <h1 class="mt-5 ms-4 text-center">Benvingut,
            <span style="color: #F28508"><?php echo $nomTecnic ?>!</span>
        </h1>
        <div class="mt-5 col-10 col-lg-8 mx-auto">
            <table class="table table-bordered table-striped table-responsive overflow-auto" style="max-height: 380px">
                <thead>
                    <tr>
                        <th class="col-1" scope="col">ID</th>
                        <th class="col-2" scope="col">Data</th>
                        <th class="col-2" scope="col">Prioritat</th>
                        <th scope="col">Descripció</th>
                        <th scope="col">Estat</th>
                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    <!--Si n'hi han fa un bucle-->
                    <?php if (!empty($incidencies)): ?>
                        <?php foreach ($incidencies as $inc):

                            $res_estat = getEstat($actuacions, $inc);
                            $estat = $res_estat["estat"];
                            $classe = $res_estat["classe"];

                        ?>


                            <td><a href="detall_incidencia.php?id=<?php echo $inc['ID_INCIDENCIA']; ?>&rol=<?php echo $rol; ?>" class="link-primary"><?php echo $inc['ID_INCIDENCIA']; ?></a></td>
                            <td><?= $inc["DATA_INICI"]; ?> </td>
                            <td><?= $inc["PRIORITAT"]; ?> </td>
                            <td><?= $inc["DESC_INCIDENCIA"]; ?> </td>
                            <td class=<?php echo $classe; ?>> <?php echo $estat; ?> </td>


                            <!--Si no un mutted text "No hi han incidencies asignades"-->

                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>


        <!-------------------------------------USUARI--------------------------------------->
    <?php elseif ($rol == 'usuari'):
        //El que veu l'usuari quan busca per departament
    ?>

        <h1 class="mt-5 ms-4 text-center">Indicències
            <span style="color: #F28508"><?php echo $nom_dept ?></span>
        </h1>

        <div class="mt-5 col-10 col-lg-8 mx-auto">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-1" scope="col">ID</th>
                        <th class="col-2" scope="col">Data</th>
                        <th class="col-2" scope="col">Estat</th>
                        <th scope="col">Descripció</th>
                    </tr>
                </thead>

                <tbody class="table-group-divider">
                    <!--Si n'hi han fa un bucle-->
                    <?php if (!empty($incidencies)): ?>
                        <?php foreach ($incidencies as $inc): ?>
                            <tr>
                                <td>
                                    <a href="detall_incidencia.php?id=<?php echo $inc['ID_INCIDENCIA']; ?>&rol=<?php echo $rol; ?>" class="link-primary">
                                        <?php echo $inc['ID_INCIDENCIA']; ?>
                                    </a>
                                </td>
                                <td><?= $inc["DATA_INICI"]; ?> </td>
                                <td><span class="badge <?= $inc['classe'] ?>"><?= $inc['estat'] ?></span></td>
                                <td><?= htmlspecialchars($inc['DESC_INCIDENCIA']) ?></td>
                            </tr>
                        <?php endforeach ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                No hi han indicències
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="mt-auto col-10 col-lg-11 mx-auto">
            <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="buscar_incidencia.php">
                🢘 Torna al cercador
            </a>
        </div>

        <!-------------------------------------ADMIN--------------------------------------->
    <?php elseif ($rol == 'admin'):
        //El que veu l'admin
    ?>

        <h1 class="mt-5 ms-4 text-center">Benvingut,
            <span style="color: #F28508">Administrador!</span>
        </h1>
        <div class="mt-5 col-10 col-lg-11 mx-auto">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2 col-5 col-lg-12">
                <a href="?rol=<?= $rol ?>&filtre=&filtre_estat=actives&ordre=ID_INCIDENCIA&dir=ASC" class="btn btn-outline-secondary btn-sm ">
                    Reset filtres
                </a>
            </div>

            <h5 class="mb-4">Selecciona l'Incidència per modificarla:</h5>
            <div class="table-responsive overflow-auto" style="max-height: 380px;"> <!--table responsive crea un scroll horitzontal segons el contingut -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="col-lg-1 text-nowrap" scope="col">ID</th>
                            <th class="col-lg-1 text-nowrap" scope="col">
                                Data inici&nbsp <!-- afegeix un espai -->
                                <a href="?rol=<?= $rol ?>&filtre=<?= $filtre ?>&filtre_estat=<?= $filtre_estat ?>&ordre=DATA_INICI&dir=ASC" class="text-decoration-none">▲</a>
                                <a href="?rol=<?= $rol ?>&filtre=<?= $filtre ?>&filtre_estat=<?= $filtre_estat ?>&ordre=DATA_INICI&dir=DESC" class="text-decoration-none">▼</a>
                            </th>
                            <th class="col-lg-1 text-nowrap" scope="col">Data fi</th>
                            <th class="col-lg-1 text-nowrap" scope="col">Estat</th>
                            <th class="col-lg-1 text-nowrap" scope="col">
                                Prioritat&nbsp
                                <a href="?rol=<?= $rol ?>&filtre=<?= $filtre ?>&filtre_estat=<?= $filtre_estat ?>&ordre=PRIORITAT&dir=ASC" class="text-decoration-none">▲</a>
                                <a href="?rol=<?= $rol ?>&filtre=<?= $filtre ?>&filtre_estat=<?= $filtre_estat ?>&ordre=PRIORITAT&dir=DESC" class="text-decoration-none">▼</a>
                            </th>
                            <th class="col-lg-1 text-nowrap" scope="col">Tècnic</th>
                            <th scope="col text-nowrap">Descripció</th>
                            <th scope="col-lg-1 text-nowrap">Edita</th>

                        </tr>
                    </thead>

                    <tbody class="table-group-divider">

                        <?php if (!empty($incidencies)): ?>
                            <?php foreach ($incidencies as $inc): ?>
                                <tr>
                                    <td>
                                        <a href="detall_incidencia.php?id=<?php echo $inc['ID_INCIDENCIA']; ?>&rol=<?php echo $rol; ?>" class="link-primary">
                                            <?php echo $inc['ID_INCIDENCIA']; ?>
                                        </a>
                                    </td>
                                    <td><?= $inc['DATA_INICI']; ?></td>
                                    <td><?= $inc['DATA_FI'] ?? '-'; ?></td>
                                    <td class="<?= $inc['classe'] ?>"><?= $inc['estat'] ?></td>
                                    <td><?= $inc['PRIORITAT'] ?? '-'; ?></td>
                                    <td><?= $inc['NOM_TECNIC']; ?></td>
                                    <td><?= $inc['DESC_INCIDENCIA']; ?></td>
                                    <td class="text-center text-dark">
                                        <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#modal<?= $inc['ID_INCIDENCIA'] ?>"> ✏️ </button> <!--obre el modal amb el mateix id de la incidencia quan cliquem sobre el llapis-->
                                    </td>
                                </tr>
                            <?php endforeach ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    No hi han indicències
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <!-- Bootstrap Modal -->
            <?php foreach ($incidencies as $inc): ?>
                <div class="modal fade" id="modal<?= $inc['ID_INCIDENCIA'] ?>" tabindex="-1" aria-labelledby="actIncidenciaModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="actIncidenciaModal">Moficiar Indicència</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post" action="modificar_incidencia.php?id=<?= $inc['ID_INCIDENCIA'] ?>&rol=<?= $rol ?>">
                                <div class="modal-body">
                                    <!-- PRIORITAT -->
                                    <label for="prioritat" class="form-label fw-bold">Prioritat</label>
                                    <select id="prioritat" name="prioritat" class="form-select" aria-label="Seleccionador de prioritat">
                                        <option value="">Selecciona prioritat...</option>
                                        <option value="Alt">Alt</option>
                                        <option value="Mitjana">Mitjana</option>
                                        <option value="Baixa">Baixa</option>
                                    </select>

                                    <!-- TECNIC -->
                                    <label for="tecnic" class="form-label fw-bold mt-4">Tècnic</label>
                                    <select id="tecnic" name="tecnic" class="form-select" aria-label="Seleccionador de tècnic">

                                        <option value="">Selecciona tècnic...</option>

                                        <?php foreach ($tecnics as $tec): ?>
                                            <option value="<?= $tec['ID_TECNIC'] ?>" >
                                            <?= $tec['NOM_TECNIC'] ?>
                                        </option> 
                                        <?php endforeach ?>

                                    </select>

                                </div>
                                <div class="modal-footer mt-2">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tanca</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Filtre per estat incidencia -->

            <div class="row gap-4 mt-5 mb-3">
                <div class="col-12 col-lg-auto">
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtrar per estat
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item <?= $filtre_estat == 'actives' ? 'fw-bold text-primary' : '' // Manté en blau el filtre actual
                                                        ?>" href="?rol=<?= $rol ?>&filtre=<?= $filtre ?>&filtre_estat=actives&ordre=<?= $ordre ?>&dir=<?= $dir ?>">Actives</a></li>
                            <li><a class="dropdown-item <?= $filtre_estat == 'totes' ? 'fw-bold text-primary' : '' ?>" href="?rol=<?= $rol ?>&filtre=<?= $filtre ?>&filtre_estat=totes&ordre=<?= $ordre ?>&dir=<?= $dir ?>">Totes</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Filtre per assignades a tecnic o no -->
                <div class="col-12 col-lg-auto">
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtrar per tècnic
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item <?= $filtre == 'no_assignades' ? 'fw-bold text-primary' : '' ?>" href="?rol=<?= $rol ?>&filtre=no_assignades&filtre_estat=<?= $filtre_estat ?>&ordre=<?= $ordre ?>&dir=<?= $dir ?>">No assignades</a></li>
                            <li><a class="dropdown-item <?= $filtre == '' ? 'fw-bold text-primary' : '' ?>" href="?rol=<?= $rol ?>&filtre='no_assignades'&filtre_estat=<?= $filtre_estat ?>&ordre=<?= $ordre ?>&dir=<?= $dir ?>">Totes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <?php endif ?>

</main>

<?php include './header-footer/footer.php'; ?>