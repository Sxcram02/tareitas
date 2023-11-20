<?php
$nombreLista = $lista['nombreLista'] ?? null;
$tareas = $lista['tareas'] ?? array();
$nota = $lista['nota'] ?? array();
$colorNota = $nota[0]['color_nota'] ?? "white";
?>
<article class="crud">
    <section>
        <h1><?php echo $nombreLista ?></h1>
    </section>
    <section>
        <?php
        if (!empty($tareas)) {
            foreach ($tareas as $clave => $tarea) {
                echo "<div><ul>";
                foreach ($tarea as $atributo => $valor) {
                    echo "<li>$atributo:  $valor</li>";
                }
                echo "</ul></div>";
            }
        }
        ?>
    </section>
    <section>
        <ul style="background-color: <?php echo $colorNota?>;">
            <?php
            if (!empty($nota)) {
                foreach ($nota as $atributo => $valor) {
                    foreach($valor as $clave => $value){
                        echo "<li>$clave:  $value</li>";
                    }
                }
            }
            ?>
        </ul>
    </section>
</article>