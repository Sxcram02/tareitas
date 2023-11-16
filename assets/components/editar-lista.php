<?php
    require_once("funciones.inc.php");
    $archivoJson = obtenerContenidoJson("json/tareas.json");
    $listasComprobadas = 0;
    
    foreach($archivoJson['lista'] as $lista){
        if(
            !isset($idLista) &&
            is_bool(array_search($idLista,$lista))
        ){
            $listasComprobadas = $listasComprobadas + 1;
        }
        
        if($listasComprobadas == count($archivoJson["lista"])){
            header(MAIN."?error=6");
        }
    }
?>
<article>
    <!-- PÁGINA DE EDICCIÓN DE TAREAS -->
    <section>
        <form action="../../src/tareitas.php?idLista=<?php echo $idLista?>" method="post">
            <fieldset>
                <legend>EDITAR LISTA</legend>
                <p>
                    <label for="nombreLista">Nombre Lista: </label>
                    <input type="text" name="nombreLista"
                        value="<?php echo $archivoJson['lista'][$idLista]['nombreLista']?>">
                </p>
                <p>
                    <label for="eliminarTarea">¿Quieres eliminar alguna tarea?</label>
                    <?php
                        foreach($archivoJson['tareas'] as $tarea){
                            if($tarea['id_lista'] == $idLista){
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