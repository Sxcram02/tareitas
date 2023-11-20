<?php
    $idLista = $indiceLista ?? null;
    $nombreLista = $lista['nombreLista'] ?? null;
    $tareasRealizadas = $tareasCompletadas ?? null;
    $tareasNoRealizadas = $tareasIncompletas ?? null;
?>
<!-- COMPONENTE LISTA -->
<article class="listas">
    <section>
        <div>
            <h1><?php echo $nombreLista ?></h1>
        </div>
        <div>
            <ol>
                <li>
                    <p><?php echo $tareasRealizadas ?> tareas completadas</p>
                </li>
                <li>
                    <p><?php echo $tareasNoRealizadas ?> tareas pendientes</p>
                </li>
            </ol>
        </div>
    </section>
    <section>
        <p>
            <button>
                <a href="src/tareitas.php?accion=eliminarLista&idLista=<?php echo $idLista ?>">
                    <p>Eliminar</p>
                    <i class="bx bx-x"></i>
                </a>
            </button>
            <button>
                <a href="src/tareitas.php?accion=editarLista&idLista=<?php echo $idLista ?>">
                    <p>Editar</p>
                    <i class='bx bx-pencil'></i>
                </a>
            </button>
            <button>
                <a href="src/tareitas.php?accion=verLista&idLista=<?php echo $idLista ?>">
                    <i class="bx bx-search-alt-2"></i>
                </a>
            </button>
        </p>
    </section>
</article>