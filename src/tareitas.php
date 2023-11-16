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

require_once("funciones.inc.php");
define("MAIN", "Location: ../index.php");
define("ERROR2", MAIN . "?error=2");

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
include_once("../assets/layouts/header.php");

// INPUT QUE CONTROLA LA CREACIÓN
// DE TAREAS & DE LISTAS & DE NOTAS
// MUESTRA EL FORMULARIO DE CREACIÓN
if (isset($_POST["create-tarea"])) {
    require_once("../assets/components/crear-tarea.php");
}

if (isset($_POST["create-list"])) {
    require_once("../assets/components/crear-lista.php");
}

/**
 * ACCIONES ESPECIFICADAS CONTROLADAS POR $_GET
 * POR METODO GET OBTENGO EL ID DE LA TAREA
 * PARA ELIMINAR O EDITAR O COMPLETAR
*/

switch ($accion) {
    case "crearLista":
        include_once("../assets/components/crear-lista.php");
        break;
    // ELIMINACION REFACTORIZAR EN UNA FUNCIÓN CON DOS PARAMETROS
    case "eliminarTarea":
        if (!empty($listaTareas['tareas'][$_GET['idTarea']])) {
            unset($listaTareas['tareas'][$_GET['idTarea']]);
            actualizarArchivoJson($listaTareas);
            header(MAIN);
        } else {
            header(ERROR2);
        }
        break;
    case "eliminarLista":
        if (!empty($listaTareas['lista'][$_GET['idLista']])) {
            unset($listaTareas['lista'][$_GET['idLista']]);
            actualizarArchivoJson($listaTareas);
            header(MAIN);
        } else {
            header(MAIN."?error=6");
        }
        break;
    case 'editarLista':
        $idLista = $_GET['idLista'] ?? null;
        if (isset($listaTareas["lista"][$_GET["idLista"]])) {
            require_once("../assets/components/editar-lista.php");
        } else {
            header(MAIN."?error=6");
        }
        break;
    case "editarTarea":
        $idTarea = $_GET['idListaTarea'] ?? null;
        if (isset($listaTareas["tareas"][$_GET["idListaTarea"]])) {
            require_once("../assets/components/editar-tarea.php");
        } else {
            header(ERROR2);
        }
        break;
    case "completarTarea":
        $listaTareas['tareas'][$_GET['idTarea']]['estado'] =
        (isset($listaTareas['tareas'][$_GET['idTarea']]))
            ? "completado"
            : $listaTareas['tareas'][$_GET['idTarea']]['estado'];
        header((actualizarArchivoJson($listaTareas))
        ? MAIN : MAIN . "?error=3");
        break;
    default:
        break;
}

//_-------------------------------------------------------------------//
//_--------------------------- TAREAS ----------------------------------//
//_-------------------------------------------------------------------//
// CONTROL DE LA CREACIÓN DE LA TAREA JUNTO A LA VALIDACIÓN DEL DATO
if (isset($_POST["crear-info-tarea"])) {
    $contieneInformacion = true;

    $idListaTareas = $_POST['lista-de-tareas'] ?? count($listaTareas['lista']);

    $tarea = [
        "id" => count($listaTareas['tareas']),
        "descripcion" => esInfoValida($_POST['descripcion']),
        "prioridad" => esInfoValida($_POST['prioridad']),
        "fecha-limite" => esInfoValida($_POST['fecha-limite']),
        "estado" => esInfoValida($_POST['estado']),
        "id_lista" => esInfoValida($idListaTareas) ?? 0,
    ];

    foreach ($tarea as $clave => $valor) {
        $contieneInformacion = (
            !isset($tarea[$clave]) ||
            empty($tarea[$clave])
        )? false : true;
    }

    if ($contieneInformacion) {
        array_push($listaTareas['tareas'], $tarea);
        if (actualizarArchivoJson($listaTareas)) {
            header(MAIN);
        }
    } else {
        header(MAIN . "?error=1");
    }
}

// BLOQUE DE CÓDIGO QUE CONTROLA LA EDICIÓN DEL LA TAREA Y SUS ATRIBUTOS
if (isset($_POST['change-info-tarea'])) {
    $estaActualizado = false;
    foreach ($listaTareas['tareas'] as $indiceTarea => $tarea) {
        $tareas = $listaTareas['tareas'][$indiceTarea];
        if ($_GET['idTarea'] == $indiceTarea) {

            $tareas['descripcion'] = esInfoValida($_POST['descripcion']) ?? $tareas['descripcion'];
            $tareas['prioridad'] = esInfoValida($_POST['prioridad']) ?? $tareas['prioridad'];
            $tareas['fecha-limite'] = esInfoValida($_POST['fecha-limite']) ?? $tareas['fecha-limite'];
            $tareas['estado'] = esInfoValida($_POST['estado']) ?? $tareas['estado'];
            $tareas['id_lista'] = esInfoValida($_POST['lista-de-tareas']) ?? $tareas['id_lista'];

            $listaTareas['tareas'][$indiceTarea] = $tareas;
            $estaActualizado = true;
        }
    }

    if (actualizarArchivoJson($listaTareas) && $estaActualizado) {
        header(MAIN);
    } else {
        header(MAIN . "?error=4");
    }
}

//_-------------------------------------------------------------------//
//_--------------------------- LISTAS ----------------------------------//
//_-------------------------------------------------------------------//
// BLOQUE DE CÓDIGO QUE CONTROLA LA CREACIÓN DE LISTAS
if (isset($_POST["crear-lista-de-tareas"])) {
    $existeLista = false;

    foreach ($listaTareas['lista'] as $indiceListe => $lista) {
        $existeLista = (!is_bool(array_search($_POST['nombreLista'], $lista)))
            ? true : false;
    }

    if (!$existeLista) {
        $listaTareas['lista'][] = array(
            "id_lista" => count($listaTareas['lista']),
            "nombreLista" => $_POST['nombreLista']
        );
        actualizarArchivoJson($listaTareas);
        
        if(isset($_POST['tareas-asociadas'])){
            // AUN NADA
        }
        
        header("Location: /listas.php");
    } else {
        header(MAIN . "?error=5");
    }
}


// BLOQUE DE CÓDIGO QUE CONTROLA LA ACTUALIZACIÓN DE LISTA
if(isset($_POST["change-info-lista"])) {
    $estaActualizado = false;
    if(!is_bool(array_search($_GET['idLista'],$listaTareas['lista'][$_GET['idLista']]))){
        /**
         * array(
         *   "lista" => array(
         *      array(
         *          "nombreLista": <valor>,
         *          "id_lista": <valor>
         *          )
         * *      array(
         *          "nombreLista": <valor2>,
         *          "id_lista": <valor2>
         *          )
         *      )
         *  )
         */
        $listaTareas['lista'][$_GET['idLista']]['nombreLista'] = esInfoValida($_POST['nombreLista'])
        ?? $listaTareas['lista'][$_GET['idLista']]['nombreLista'];
        
        if(
            isset($listaTareas['lista'][$_GET['idLista']]['nombreLista'])&&
            !empty($listaTareas['lista'][$_GET['idLista']]['nombreLista'])
        ){
            actualizarArchivoJson($listaTareas);
            $estaActualizado = true;
        }
        
        if(
            isset($_POST['tareasEliminadas']) &&
            count($_POST['tareasEliminadas']) > 0
        ){
            $estaActualizado = false;
            foreach($listaTareas['tareas'] as $indiceTarea => $tarea) {
                if(!is_bool(array_search($indiceTarea, $_POST['tareasEliminadas']))){
                    $listaTareas['tareas'][$indiceTarea]["id_lista"] = 0;
                    $estaActualizado = true;
                }
            }
        }
        
    }else{
        header(MAIN . "?error=6");
    }
    
    
    if(actualizarArchivoJson($listaTareas) && $estaActualizado){
        header("Location: /listas.php");
    }else{
        header(MAIN . "?error=0");
    }
    
    
}

include_once("../assets/layouts/footer.php");