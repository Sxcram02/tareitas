<?php
$title = "Home";
include_once 'assets/layouts/header.php';
?>
<!-- MAIN CONTENT -->
<!--
    TAREAS PENDIENTES:
    1. RF 3.2 DE USABILIDAD E INTERACCIÓON
    2. ARREGLAR EXPRESIONES REGULARES.
    3. NO PERMITIR ESPACIOS VACÍOS.
    4. REFACTORIZAR CRUD.
    5. Estilos tarjetas de notas
    6. input radio del color
-->
<form action="src/tareitas.php" method="post">
    <!-- NAVBAR DE NAVEGACIÓN ENTRE TAREAS -->
    <nav class="nav-bar">
        <label for="create-tarea">
            <button name="create-tarea">
                <a href="src/tareitas.php?accion=crearTarea">
                    <p>Añadir tarea</p>
                    <i class='bx bx-plus' styles="font-size:36px;"></i>
                </a>
            </button>
        </label>
        <label for="buscador-tarea">
            <input type="search" name="buscador-tarea" id="buscador-tarea">
        </label>
        <label for="ordenar-desc">
            <button>
                <a href="src/tareitas.php?accion=completarTodas">
                    <i class='bx bx-check' styles="font-size:36px;"></i>
                </a>
            </button>
        </label>
        <label for="ordenar-asc">
            <button>
                <a href="src/tareitas.php?accion=eliminarTodas">
                    <i class='bx bx-x' styles="font-size:36px;"></i>
                </a>
            </button>
        </label>
        <label for="fecha-creacion">
            <input type="date" name="fecha-creacion" id="fecha-creacion" min="2023-01-01" max="2050-12-31">
        </label>
    </nav>
    <main>
        <!-- VISUALIZACIÓN DE LAS TAREAS PENDIENTES Y REALIZADAS -->
        <?php
        if (!isset($_GET['accion']) && !isset($_GET['error'])) {
            include_once 'assets/components/tareas_pendientes.php';
            include_once 'assets/components/tareas_realizadas.php';
        }

        // POSIBLES ERRORES CON SU RESPECTIVO MENSAJE
        if (isset($_GET["error"]) && !empty($_GET['error'])) {
            $errorMessage = match ($_GET["error"]) {
                "1" => "La tarea NO se ha podido CREAR",
                "2" => "La tarea introducida NO EXISTE",
                "3" => "La tarea no se ha podido COMPLETAR",
                "4" => "La tarea no se ha podido EDITAR",
                "5" => "Ya existe una lista con ese nombre",
                "6" => "La lista introducida NO EXISTE",
                "7" => "Ha surgido un error inseperado...",
                "8" => "La nota introducida NO EXISTE...",
                default => "Algo salio mal...",
            };

            $imagenError = match($_GET['error']){
                "6","8","2" => "/assets/images/error-404.png",
                "1","5" => "/assets/images/error-403.png",
                "3","7" => "/assets/images/error-500.png",
                default => "/assets/images/error-comun.png"
            };

            include_once 'assets/layouts/error.php';
        }
        ?>
    </main>
</form>
<?php include_once 'assets/layouts/footer.php'; ?>