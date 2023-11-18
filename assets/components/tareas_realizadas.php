<article class="tabla-tareas">
    <h1>Realizadas</h1>
    <table>
        <caption>Tabla con todas las tareas realizadas</caption>
        <thead>
            <th></th>
            <th>Id</th>
            <th>Título</th>
            <th>Prioridad</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
        </thead>
        <hr />
        <tbody>
            <?php
                require_once "src/funciones.inc.php";
                mostrarTareas("completado");
            ?>
        </tbody>
    </table>
</article>