<article>
    <section>
        <!-- CREACIÓN DE TAREAS -->
        <form action="#" method="post">
            <fieldset>
                <legend>CREAR TAREA</legend>
                <p>
                    <label for="descripcion">Descripción: </label>
                    <input type="text" name="descripcion" required>
                </p>
                <p>
                    <label for="prioridad">Prioridad: </label>
                    <label for="prioridad">No importante:
                        <input type="radio" name="prioridad" value="no importante" checked>
                    </label>
                    <label for="prioridad">Intermedio: <input type="radio" name="prioridad" value="intermedio"></label>
                    <label for="prioridad">Importante: <input type="radio" name="prioridad" value="importante"></label>
                    <label for="prioridad">Muy importante: <input type="radio" name="prioridad"
                            value="muy importante"></label>
                </p>
                <p>
                    <label for="fecha-limite">Fecha Límite</label>
                    <input type="date" name="fecha-limite" min="2023-01-01" max="2030-12-31" required>
                </p>
                <p>
                    <label for="estado">Estado:</label>
                    <label for="estado">Si:
                        <input type="radio" name="estado" value="completado"></label>
                    <label for="estado">No:
                        <input type="radio" name="estado" value="no completado" required></label>
                </p>
                <p>
                    <label for="lista-de-tareas">Quieres asociar la tarea a una lista?</label>
                    <select name="lista-de-tareas" id="lista-de-tareas">
                        <?php
                        foreach($archivoJson['lista'] as $lista){
                            if($lista['id_lista'] == 0){
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
                    <label for="crear-info-tarea">
                        <input type="submit" value="Crear Tarea" name="crear-info-tarea">
                    </label>
                </p>
            </fieldset>
        </form>
    </section>
</article>