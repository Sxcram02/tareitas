<article class="crud">
    <section>
        <!-- CREACIÓN DE NOTAS -->
        <form action="#" method="post">
            <fieldset>
                <legend>Crear nota</legend>
                <p>
                    <label for="titulo-nota">Titulo de la nota</label>
                    <input type="text" name="titulo-nota" required maxlength="20">
                </p>
                <p>
                    <label for="color-nota">Selecciona un color</label>
                    <select name="color-nota">
                        <option value="" hidden selected>--Seleccionar--</option>
                        <option value="darkred">Rojo</option>
                        <option value="darkorange">Naranja</option>
                        <option value="darkblue">Azúl</option>
                        <option value="darkgreen">Verde</option>
                        <option value="yellow">Amarillo</option>
                    </select>
                </p>
                <p>
                    <label for="contenido-nota">Contenido de una nota</label>
                    <textarea name="contenido-nota" cols="50" rows="8"></textarea>
                </p>
                <p>
                    <label for="lista-asociada">¿Quieres asociar la nota a una lista?</label>
                    <select name="lista-asociada" id="lista-asociada">
                        <option value="" hidden selected>--Seleciona lista--</option>
                        <?php
                        foreach ($archivoJson['lista'] as $lista) {
                            echo '<option value="' . $lista['id_lista'] . '">' . $lista['nombreLista'] . '</option>';
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="crear-info-nota">
                        <button type="submit" value="Crear nota" name="crear-info-nota">Crear nota</button>
                    </label>
                </p>
            </fieldset>
            <div class="tareitas-logo-container">
                <img src="/assets/images/icon-footer.png" alt="logo" class="tareitas-logo">
            </div>
        </form>
    </section>
</article>