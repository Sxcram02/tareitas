<?php
    $idTarea = $indiceTarea ?? null;
    $estaChecked = $estaChecked ?? "";
    $tituloTarea = $tareas['descripcion'] ?? null;
    $fechaLimite = $tareas["fecha-limite"] ?? null;
?>
<!-- COMPONENTE TAREA EN TABLA -->
<tr>
    <td><input type="checkbox" <?php echo $estaChecked ?> disabled></td>
    <td><?php echo $idTarea ?></td>
    <td><?php echo  $tituloTarea ?></td>
    <td><input type="date" name="fecha" id="fecha" value="<?php echo $fechaLimite ?>" readonly></td>
    <td>
        <div>
            <button>
                <a href="src/tareitas.php?accion=eliminarTarea&idTarea=<?php echo $idTarea ?>">
                    <i class=" bx bx-x"></i>
                </a>
            </button>
            <button>
                <a href="src/tareitas.php?accion=completarTarea&idTarea=<?php echo $idTarea ?>">
                    <i class=" bx bx-check"></i>
                </a>
            </button>
            <button type="submit">
                <a href="src/tareitas.php?accion=editarTarea&idListaTarea=<?php echo $idTarea?>">
                    <i class="bx bx-search-alt-2"></i>
                </a>
            </button>
        </div>
    </td>
</tr>