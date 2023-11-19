<?php
require_once 'src/funciones.inc.php';
$title = "Listas";
include_once 'assets/layouts/header.php';
?>
<main class="main-listas">
    <article class="listas-nav-bar">
        <p>
            <a href="src/tareitas.php?accion=crearLista">
                <button>Añadir Lista<i class='bx bx-plus' styles="font-size:36px;"></i></button>
            </a>
        </p>
    </article>
    <?php mostrarListas()?>
</main>
<?php include_once 'assets/layouts/footer.php' ?>