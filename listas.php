<?php
require_once("src/funciones.inc.php");
include_once("assets/layouts/header.php");
?>
<article>
    <p>
        <a href="src/tareitas.php?accion=crearLista">
            <button><i class='bx bx-plus' styles="font-size:36px;"></i></button>
        </a>
    </p>
</article>
<?php
mostrarListas();
include_once("assets/layouts/footer.php");