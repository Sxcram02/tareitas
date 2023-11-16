<?php require_once("src/funciones.inc.php"); ?>
<article>
    <!-- TASK LIST INCOMPLETE -->
    <h1>Pendientes</h1>
    <table>
        <caption>Tabla con todas las tareas pendientes a realizar</caption>
        <!-- HEAD TABLE -->
        <thead>
            <th></th>
            <th>Id</th>
            <th>Descripción</th>
            <th>Fecha Limite</th>
            <th>Acciones</th>
        </thead>
        <hr />
        <!-- BODY TABLE -->
        <tbody>
            <?php mostrarTareas(); ?>
        </tbody>
    </table>
</article>