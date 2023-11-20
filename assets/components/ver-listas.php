<?php
$nombreLista = $lista['nombreLista'] ?? null;
$tareas = $lista['tareas'] ?? array();
$nota = $lista['nota'] ?? array();
$colorNota = $nota[0]['color_nota'] ?? "white";
?>
<article class="crud ver-lista">
    <section>
        <h1><?php echo $nombreLista ?></h1>
        <?php
        if (!empty($tareas)) {
            foreach ($tareas as $clave => $tarea) {
                echo "<div class='tareas-lista'><ul>";
                foreach ($tarea as $atributo => $valor) {
                    echo "<li>$atributo:  $valor</li>";
                }
                echo "</ul></div>";
            }
        }
        ?>
    </section>
    <section>
        <h1>NOTAS ASOCIADAS</h1>
        <?php
            if (!empty($nota)) {
                foreach ($nota as $atributo => $valor) {
                    echo '<ul class="lista-nota" style="background-color:'.$colorNota.'">';
                    foreach($valor as $clave => $value){
                        echo "<li>$clave: $value</li>";
                    }
                    echo "</ul>";
                }
        }
        ?>
    </section>
</article>