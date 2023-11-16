<?php
    require_once("funciones.inc.php");
    $archivoJson = obtenerContenidoJson("json/tareas.json");
    $tareasComprobadas = 0;
    
    foreach($archivoJson['tareas'] as $tareas){
        if(
            !isset($idTarea) &&
            is_bool(array_search($idTarea,$tareas))
        ){
            $tareasComprobadas = $tareasComprobadas + 1;
        }
        
        if($tareasComprobadas == count($archivoJson["tareas"])){
            header(ERROR2);
        }
    }
?>
<article>
    <!-- PÁGINA DE EDICCIÓN DE TAREAS -->
    <section>
        <form action="../../src/tareitas.php?idTarea=<?php echo $idTarea?>" method="post">
            <fieldset>
                <legend>EDITAR TAREA</legend>
                <p>
                    <label for="descripcion">Descripción: </label>
                    <input type="text" name="descripcion" id=""
                        value="<?php echo $archivoJson['tareas'][$idTarea]['descripcion']?>">
                </p>
                <p>
                    <label for="prioridad">Prioridad: </label>
                    <label for="prioridad">No importante: <input type="radio" name="prioridad"
                            value="no importante"></label>
                    <label for="prioridad">Intermedio: <input type="radio" name="prioridad" value="intermedio"></label>
                    <label for="prioridad">Importante: <input type="radio" name="prioridad" value="importante"></label>
                    <label for="prioridad">Muy importante: <input type="radio" name="prioridad"
                            value="muy importante"></label>
                </p>
                <p>
                    <label for="prioridadActual">Prioridad actual</label>
                    <input type="text" name="prioridadActual" id="prioridadActual"
                        value="<?php echo $archivoJson['tareas'][$idTarea]['prioridad']?>" disabled>
                </p>
                <p>
                    <label for="fecha-limite">Fecha Límite</label>
                    <input type="date" name="fecha-limite"
                        value="<?php echo $archivoJson['tareas'][$idTarea]['fecha-limite']?>">
                </p>
                <p>
                    <label for="estadoActual">Estado actual: </label>
                    <input type="text" name="estadoActual" id="estadoActual"
                        value="<?php echo $archivoJson['tareas'][$idTarea]['estado'] ?>" disabled>
                </p>
                <p>
                    <label for="lista-de-tareas">Quieres asociar la tarea a una lista?</label>
                    <select name="lista-de-tareas" id="lista-de-tareas">
                        <?php
                        foreach($archivoJson['lista'] as $lista){
                            if($lista['id_lista'] == $archivoJson['tareas'][$idTarea]['id_lista']){
                                echo '<option value="'. $lista['id_lista'] .'" selected>'.
                                $lista['nombreLista'] .'</option>';
                            }else{
                                echo '<option value="'. $lista['id_lista'] .'">'.$lista['nombreLista'] .'</option>';
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="change-info-tarea">
                        <input type="submit" value="Editar Tarea" name="change-info-tarea">
                    </label>
                </p>
            </fieldset>
        </form>
    </section>
</article>