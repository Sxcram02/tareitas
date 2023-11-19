<article class="crud">
    <section>
        <!-- CREACIÓN DE TAREAS -->
        <form action="#" method="post">
            <fieldset>
                <legend>CREAR TAREA</legend>
                <p>
                    <label for="descripcion">Descripción: </label>
                    <input type="text" name="descripcion" required maxlength="20">
                </p>
                <p>
                    <label for="prioridad">Prioridad: </label>
                    <select name="prioridad">
                        <option value="" hidden selected></option>
                        <option value="muy importante">Muy importante</option>
                        <option value="importante">Importante</option>
                        <option value="intermedio">Normal</option>
                        <option value="no importante">Secundario</option>
                    </select>
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
                        <button type="submit" value="Crear Tarea" name="crear-info-tarea">Crear Tarea</button>
                    </label>
                </p>
            </fieldset>
            <div class="tareitas-logo-container">
                <img src="/assets/images/icon-footer.png" alt="logo" class="tareitas-logo">
            </div>
        </form>
    </section>
</article>