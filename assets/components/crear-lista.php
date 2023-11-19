<article class="crud">
    <section>
        <!-- CREACIÓN DE LISTAS -->
        <form action="#" method="post">
            <fieldset>
                <legend>CREAR LISTA</legend>
                <p>
                    <label for="nombreLista">Nombre De La Lista: </label>
                    <input type="text" name="nombreLista" id="nombreLista" required maxlength="20">
                </p>
                <p>
                    <label for="tareas-asociadas">Asocia Tareas</label>
                <ul>
                    <?php
                    foreach ($archivoJson['tareas'] as $tarea) {
                        echo '<li>
                        <label for="tareas-asociadas">
                            <input type="checkbox" name="tareas-asociadas[]" value="' . $tarea['id'] . '">' .
                            $tarea['descripcion']
                            . '</label></li>';
                    }
                    ?>
                </ul>
                </p>
                <p>
                    <label for="crear-lista-de-tareas">
                        <button type="submit" value="Crear Lista" name="crear-lista-de-tareas">Crear Lista</button>
                    </label>
                </p>
            </fieldset>
            <div class="tareitas-logo-container">
                <img src="/assets/images/icon-footer.png" alt="logo" class="tareitas-logo">
            </div>
        </form>
    </section>
</article>