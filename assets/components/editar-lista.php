<?php
    $listasComprobadas = 0;
    
    foreach($archivoJson['lista'] as $lista){
        if(
            !isset($idLista) &&
            is_bool(array_search($idLista,$lista))
        ){
            $listasComprobadas = $listasComprobadas + 1;
        }
        
        if($listasComprobadas == count($archivoJson["lista"])){
            header("Location: " . MAIN."?error=6");
        }
    }
?>
<article class="crud-editar">
    <!-- PÁGINA DE EDICCIÓN DE TAREAS -->
    <section>
        <form action="?idLista=<?php echo $idLista?>" method="post">
            <fieldset>
                <legend>EDITAR LISTA</legend>
                <p>
                    <label for="nombreLista">Nombre Lista: </label>
                    <input type="text" name="nombreLista"
                        value="<?php echo $archivoJson['lista'][$idLista]['nombreLista']?>">
                </p>
                <p>
                    <label for="tareasAniadidas">¿Quieres añadir alguna tarea?</label>
                    <?php
                        foreach($archivoJson['tareas'] as $tarea){
                            if($tarea['id_lista'] == 0){
                                echo '<label>
                                <input type="checkbox" name="tareasAniadidas[]" value="' . $tarea['id'] . '"/>'
                                . $tarea['descripcion']. '</label>';
                            }
                        }
                    ?>
                </p>
                <p>
                    <label for="tareasEliminadas">¿Quieres eliminar alguna tarea?</label>
                    <?php
                        foreach($archivoJson['tareas'] as $tarea){
                            if($tarea['id_lista'] == $archivoJson['lista'][$idLista]['id_lista']){
                                echo '<label>
                                <input type="checkbox" name="tareasEliminadas[]" value="' . $tarea['id'] . '"/>'
                                . $tarea['descripcion']. '</label>';
                            }
                        }
                    ?>
                </p>
                <p>
                    <label for="change-info-lista">
                        <input type="submit" value="Editar Lista" name="change-info-lista">
                    </label>
                </p>
            </fieldset>
        </form>
    </section>
</article>