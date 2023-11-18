<?php
    $idTarea = $indiceTarea ?? null;
    $volverAtras = $volverAtras ?? null;
    $enlaceAccion = $enlaceAccion ?? null;
    $estaChecked = $estaChecked ?? "";
    $tituloTarea = $tareas['descripcion'] ?? null;
    $fechaLimite = $tareas["fecha-limite"] ?? null;
?>
<!-- COMPONENTE TAREA EN TABLA -->
<tr>
    <td><?php echo $estaChecked ?></td>
    <td><?php echo $idTarea ?></td>
    <td><?php echo  $tituloTarea ?></td>
    <td>
        <?php
            echo match($tareas['prioridad']){
                "muy importante" => "
                <i class='bx bx-error-circle muy-importante'></i>
                <i class='bx bx-error-circle muy-importante'></i>
                <i class='bx bx-error-circle muy-importante'></i>",
                "importante" => "
                <i class='bx bx-error-circle importante'></i>
                <i class='bx bx-error-circle importante'></i>",
                "intermedio" => "<i class='bx bx-error-circle intermedio'></i>",
                default => ""
            };
        ?>
    </td>
    <td><input type="date" name="fecha-buscador" id="fecha" value="<?php echo $fechaLimite ?>" readonly></td>
    <td>
        <div class="fila-acciones">
            <button>
                <a href="src/tareitas.php?accion=eliminarTarea&idTarea=<?php echo $idTarea ?>">
                    <i class=" bx bx-x"></i>
                </a>
            </button>
            <button>
                <a href="<?php echo $enlaceAccion ?>">
                    <?php echo $volverAtras ?>
                </a>
            </button>
            <button>
                <a href="src/tareitas.php?accion=editarTarea&idListaTarea=<?php echo $idTarea?>">
                    <i class="bx bx-search-alt-2"></i>
                </a>
            </button>
            <button>
                <a href="src/tareitas.php?accion=crearNota">
                    <i class='bx bx-note'></i>
                </a>
            </button>
        </div>
    </td>
</tr>