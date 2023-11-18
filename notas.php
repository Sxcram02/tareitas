<?php
    $title = "Notas";
    require_once "src/funciones.inc.php";
    include_once 'assets/layouts/header.php';
?>
<article>
    <section>
        <button>
            <a href="src/tareitas.php?accion=crearNota">
                <i class='bx bx-plus' styles="font-size:36px;"></i>
            </a>
        </button>
    </section>
</article>
<?php
    mostrarNotas();
    include_once 'assets/layouts/footer.php';
?>