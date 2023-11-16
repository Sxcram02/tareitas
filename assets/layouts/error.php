<?php
include_once("header.php");
error_reporting(E_ALL&~E_WARNING);
// HE PUESTO EL ERROR REPORTING DADO QUE ES UNA PANTALLA DE ERROR Y EVITAR FUTUROS WARNINGS
$errorMessage = $errorMessage ?? "Algo salió mal...";
?>
<article>
    <!-- PÁGINA DE ERROR -->
    <section>
        <img src="" alt="" srcset="">
    </section>
    <section>
        <h1>
            ERROR <?php echo "$errorMessage"?>
        </h1>
    </section>
</article>
<?php include_once("footer.php"); ?>