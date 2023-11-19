<?php
require_once "funciones.inc.php";
$tareasComprobadas = 0;

foreach ($archivoJson['tareas'] as $tareas) {
    if (
        !isset($idTarea) &&
        is_bool(array_search($idTarea, $tareas))
    ) {
        $tareasComprobadas = $tareasComprobadas + 1;
    }

    if ($tareasComprobadas == count($archivoJson["tareas"])) {
        header(ERROR2);
    }
}
?>
<article class="crud tareas-editar">
    <!-- PÁGINA DE EDICCIÓN DE TAREAS -->
    <section>
        <form action="?idTarea=<?php echo $idTarea ?>" method="post">
            <div class="tareitas-logo-container">
                <img src="/assets/images/icon-footer.png" alt="logo" class="tareitas-logo">
            </div>
            <fieldset>
                <legend>EDITAR TAREA</legend>
                <p>
                    <label for="descripcion">Descripción: </label>
                    <input type="text" name="descripcion" id="" value="<?php echo $archivoJson['tareas'][$idTarea]['descripcion'] ?>" maxlength="20">
                </p>
                <p>
                    <label for="prioridad">Prioridad: </label>
                    <select name="prioridad">
                        <option value="" hidden selected>
                            <?php echo $archivoJson['tareas'][$idTarea]['prioridad'] ?>
                        </option>
                        <option value="muy importante">Muy importante</option>
                        <option value="importante">Importante</option>
                        <option value="intermedio">Normal</option>
                        <option value="no importante">Secundario</option>
                    </select>
                </p>
                <p>
                    <label for="prioridadActual">Prioridad actual</label>
                    <input type="text" name="prioridadActual" id="prioridadActual" value="<?php echo $archivoJson['tareas'][$idTarea]['prioridad'] ?>" disabled>
                </p>
                <p>
                    <label for="fecha-limite">Fecha Límite</label>
                    <input type="date" name="fecha-limite" max="2030-12-31" min="2023-01-01" value="<?php echo $archivoJson['tareas'][$idTarea]['fecha-limite'] ?>">
                </p>
                <p>
                    <label for="estadoActual">Estado actual: </label>
                    <input type="text" name="estadoActual" id="estadoActual" value="<?php echo $archivoJson['tareas'][$idTarea]['estado'] ?>" disabled>
                </p>
                <p>
                    <label for="lista-de-tareas">*Asocia la tarea a una lista</label>
                    <select name="lista-de-tareas" id="lista-de-tareas">
                        <?php
                        foreach ($archivoJson['lista'] as $lista) {
                            if ($lista['id_lista'] == $archivoJson['tareas'][$idTarea]['id_lista']) {
                                echo '<option value="' . $lista['id_lista'] . '" selected>' .
                                    $lista['nombreLista'] . '</option>';
                            } else {
                                echo '<option value="' . $lista['id_lista'] . '">' . $lista['nombreLista'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="change-info-tarea">
                        <button type="submit" value="editar-tarea" name="change-info-tarea">Editar Tarea</button>
                    </label>
                </p>
            </fieldset>
        </form>
    </section>
</article>