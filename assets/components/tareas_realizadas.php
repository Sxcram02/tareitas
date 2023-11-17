<article>
    <h1>Realizadas</h1>
    <table>
        <thead>
            <th></th>
            <th>Titulo</th>
            <th>Descripción</th>
            <th>Fecha Creación</th>
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