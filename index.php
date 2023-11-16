<?php include_once 'assets/layouts/header.php'; ?>
<!-- MAIN CONTENT -->
<!--
    TAREAS PENDIENTES:
    1. CRUD NOTAS.
    2. ARREGLAR EXPRESIONES REGULARES.
    3. NO PERMITIR ESPACIOS VACÍOS.
    4. REFACTORIZAR CRUD DE LISTAS Y TAREAS.
    5. AÑADIR ESTILOS FUENTE E IMAGENES.
-->
<form action="src/tareitas.php" method="post">
    <!-- NAVBAR DE NAVEGACIÓN ENTRE TAREAS -->
    <nav>
        <fieldset>
            <legend></legend>
            <label for="buscador-tarea">
                <input type="search" name="buscador-tarea" id="buscador-tarea">
            </label>
            <label for="ordenar-desc">
                <button type="submit" value="" name="ordenar-desc">
                    <i class='bx bxs-down-arrow' styles="font-size:36px;"></i>
                </button>
            </label>
            <label for="ordenar-asc">
                <button type="submit" value="" name="ordenar-asc">
                    <i class='bx bxs-up-arrow' styles="font-size:36px;"></i>
                </button>
            </label>
            <label for="fecha-creacion">
                <input type="date" name="fecha-creacion" id="fecha-creacion">
            </label>
            <label for="add-tarea">
                <button type="submit" name="create-tarea" value="">
                    <i class='bx bx-plus' styles="font-size:36px;"></i>
                </button>
            </label>
        </fieldset>
    </nav>
    <main>
        <!-- VISUALIZACIÓN DE LAS TAREAS PENDIENTES Y REALIZADAS -->
        <?php
        if (!isset($_GET['accion']) && !isset($_GET['error'])) {
            include_once("assets/components/tareas_pendientes.php");
            include_once("assets/components/tareas_realizadas.php");
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
                default => "Algo salio mal...",
            };

            include_once("assets/layouts/error.php");
        }
        ?>
    </main>
</form>
<?php include_once("assets/layouts/footer.php"); ?>