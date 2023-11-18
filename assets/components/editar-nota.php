<article class="crud-editar">
    <section>
        <!-- CREACIÓN DE NOTAS -->
        <form action="#" method="post">
            <fieldset>
                <legend>Editar nota</legend>
                <p>
                    <label for="titulo-nota">Titulo de la nota</label>
                    <input type="text" name="titulo-nota"
                        value="<?php echo $archivoJson['nota'][$idNota]['titulo-nota']; ?>" required>
                </p>
                <p>
                    <label for="color-actual">Color Actual</label>
                    <input type="text" name="color-actual"
                        value="<?php echo $archivoJson['nota'][$idNota]['color_nota']; ?>" disabled>
                </p>
                <p>
                    <label for="color-nota">Selecciona un color</label>
                    <input type="radio" name="color-nota" value="red">
                    <input type="radio" name="color-nota" value="blue">
                    <input type="radio" name="color-nota" value="green">
                    <input type="radio" name="color-nota" value="yellow">
                    <input type="radio" name="color-nota" value="orange">
                </p>
                <p>
                    <label for="contenido-nota">Contenido de una nota</label>
                    <textarea name="contenido-nota" cols="50" rows="8"
                        placeholder="<?php echo $archivoJson['nota'][$idNota]['descripcion'] ?>"></textarea>
                </p>
                <p>
                    <label for=" lista-ya-asociada">Lista asociada</label>
                    <input type="text" name="lista-ya-asociada" value="<?php
                $idLista = $archivoJson['nota'][$idNota]['id_lista'];
                if(isset($archivoJson['lista'][$idLista])){
                    echo $archivoJson['lista'][$idLista]['nombreLista'];
                }else{
                echo "Sin lista";
                }
                ?>" disabled>
                </p>
                <p>
                    <label for="lista-asociada">¿Quieres asociar la nota a una lista?</label>
                    <select name="lista-asociada" id="lista-asociada">
                        <option value="" hidden selected>--Seleciona lista--</option>
                        <?php
                        foreach($archivoJson['lista'] as $lista){
                            echo '<option value="'. $lista['id_lista'] .'">'.$lista['nombreLista'] .'</option>';
                        }
                    ?>
                    </select>
                </p>
                <p>
                    <label for="change-info-nota">
                        <input type="submit" value="Editar nota" name="change-info-nota">
                    </label>
                </p>
            </fieldset>
        </form>
    </section>
</article>