<?php require_once("src/funciones.inc.php"); ?>
<article class="tabla-tareas">
    <!-- TASK LIST INCOMPLETE -->
    <h1>Tareas Pendientes</h1>
    <table>
        <caption>Tabla con todas las tareas pendientes a realizar</caption>
        <!-- HEAD TABLE -->
        <thead>
            <th></th>
            <th>Id</th>
            <th>Título</th>
            <th>Prioridad</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
        </thead>
        <hr />
        <!-- BODY TABLE -->
        <tbody>
            <?php mostrarTareas(); ?>
        </tbody>
    </table>
</article>