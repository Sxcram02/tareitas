<article>
    <section>
        <!-- CREACIÓN DE LISTAS -->
        <form action="../../src/tareitas.php" method="post">
            <fieldset>
                <legend>CREAR LISTA</legend>
                <p>
                    <label for="nombreLista">Nombre De La Lista: </label>
                    <input type="text" name="nombreLista" id="nombreLista" required>
                </p>
                <p>
                    <label for="tareas-asociadas">Asocia Tareas</label>
                <ul>
                    <?php
                        foreach($archivoJson['tareas'] as $tarea){
                        echo'<li>
                        <label for="tareas-asociadas">
                            <input type="checkbox" name="tareas-asociadas[]" value="'.$tarea['id'].'">' .
                            $tarea['descripcion']
                            . '</label></li>';
                        }
                    ?>
                </ul>
                </p>
                <p>
                    <label for="crear-lista-de-tareas">
                        <input type="submit" value="Crear Lista" name="crear-lista-de-tareas">
                    </label>
                </p>
            </fieldset>
        </form>
    </section>
</article>