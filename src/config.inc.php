<?php

/**
 * !!! EJECUCCIÓN DEL SERVIDOR EN EL ARCHIVO INDEX.PHP CON TODA SU CARPETA
 * **POSIBLES ERRORES DE RUTAS RELATIVAS**
 *
 * Este el archivo php que controla las creaciones, ediciones,
 * eliminaciones y obtención de datos en el json.
 * Requiero de todas las funciones implementadas en el archivo funciones.inc.php
 *
 * @var string $contenidoJson
 * @var string $accion
 * @var array $listaTareas
 * @var int $tareacreadas
 *
 * @file src/json/tareas.json
 * @file src/funciones.inc.php
 * @author Marcos <228@cifpceuta.es>
 */

require_once 'funciones.inc.php';

define("MAIN", "Location: /index.php");
define("LISTAS","Location: /lista.php");

define("ERROR0", "Location: /index.php?error=0");
define("ERROR1", "Location: /index.php?error=1");
define("ERROR2","Location: /index.php?error=2");
define("ERROR3", "Location: /index.php?error=3");
define("ERROR4","Location: /index.php?error=4");
define("ERROR5", "Location: /index.php?error=5");
define("ERROR6","Location: /index.php?error=6");

$contenidoJson = file_get_contents("json/tareas.json");
$accion = $_GET['accion'] ?? null;
$listaTareas = (
    file_exists("json/tareas.json") && !empty($contenidoJson)
) ? json_decode($contenidoJson, true)
    : array(
        'tareas' => array(),
        'lista' => array(
            array(
                "id_lista" => 0,
                "nombreLista" => "Tareas no asignadas",
            )
        )
    );