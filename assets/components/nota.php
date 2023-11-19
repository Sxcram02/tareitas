<article class="notas" style="background-color: <?php echo $nota['color_nota'] ?>;">
    <section>
        <h1><?php echo $nota['titulo-nota'] ?></h1>
        <h3><?php echo $nombreLista ?></h3>
        <p><?php echo $nota['descripcion'] ?></p>
    </section>
    <section>
        <button>
            <a href="src/tareitas.php?accion=eliminarNota&idNota=<?php echo $nota['id'] ?>">
                <i class=" bx bx-x"></i>
            </a>
        </button>
        <button>
            <a href="src/tareitas.php?accion=editarNota&idNota=<?php echo $indiceNota ?>">
                <i class="bx bx-search-alt-2"></i>
            </a>
        </button>
    </section>
</article>