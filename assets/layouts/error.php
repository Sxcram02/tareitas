<?php
include_once("header.php");
error_reporting(E_ALL&~E_WARNING);
// HE PUESTO EL ERROR REPORTING DADO QUE ES UNA PANTALLA DE ERROR Y EVITAR FUTUROS WARNINGS
$imagenError = $imagenError ?? "/assets/images/error-comun.php";
$errorMessage = $errorMessage ?? "Algo salió mal...";
?>
<main class="main-listas">
    <article class="error">
        <!-- PÁGINA DE ERROR -->
        <section style="background-image: url('<?php echo $imagenError?>');">
        </section>
        <section>
            <h1>
                ERROR: <?php echo "$errorMessage"?>
            </h1>
        </section>
    </article>
</main>
<?php include_once("footer.php"); ?>