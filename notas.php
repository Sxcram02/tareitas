<?php
    $title = "Notas";
    require_once "src/funciones.inc.php";
    include_once 'assets/layouts/header.php';
?>
<main class="main-listas">
    <article class="notas-nav-bar">
        <p>
            <a href="src/tareitas.php?accion=crearNota">
                <button>Añadir Notas
                    <i class='bx bx-plus' styles="font-size:36px;"></i>
                </button>
            </a>
        </p>
    </article>
    <?php mostrarNotas();?>
</main>
<?php include_once 'assets/layouts/footer.php';?>