<?php
require_once "config.inc.php";
$title = "Tareitas";

// PARA LOS DATOS RECIBIDOS MEDIANTE POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach($_POST as $clave => $valor){
        if(!is_array($valor)){
            $datoAvalidar = esInfoValida($valor);
            if(!isset($datoAvalidar)){
                header(ERROR0);
            }
        }else{
            foreach($valor as $indice => $contenido){
                $datoAvalidar = esInfoValida($contenido);
                if(!isset($datoAvalidar)){
                    header(ERROR0);
                }
            }
        }
    }
}

// INPUT QUE CONTROLA LA CREACIÓN
// DE TAREAS & DE LISTAS & DE NOTAS
// MUESTRA EL FORMULARIO DE CREACIÓN
if (isset($_POST["create-tarea"])) {
    $archivoJson = $listaTareas;
    $title = "Crear tarea";
    include_once '../assets/layouts/header.php';
    require_once "../assets/components/crear-tarea.php";
}

/**
 * ACCIONES ESPECIFICADAS CONTROLADAS POR $_GET
 * POR METODO GET OBTENGO EL ID DE LA TAREA
 * PARA ELIMINAR O EDITAR O COMPLETAR
*/

switch ($accion) {
    case "crearLista":
        $archivoJson = $listaTareas;
        $title = "Crear Lista";
        include_once '../assets/layouts/header.php';
        include_once '../assets/components/crear-lista.php';
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
            foreach($listaTareas['tareas'] as $tareas){
                if($_GET['id_lista'] == $tareas['id_lista']){
                    unset($listaTareas['tareas'][$tareas['id']]);
                }
            }
            
            unset($listaTareas['lista'][$_GET['idLista']]);
            actualizarArchivoJson($listaTareas);
            header(MAIN);
        } else {
            header(ERROR6);
        }
        break;
    case 'editarLista':
        $idLista = $_GET['idLista'] ?? null;
        if (isset($listaTareas["lista"][$_GET["idLista"]])) {
            $archivoJson = $listaTareas;
            $title = "Editar Lista";
            include_once '../assets/layouts/header.php';
            require_once "../assets/components/editar-lista.php";
        } else {
            header(ERROR6);
        }
        break;
    case "editarTarea":
        $idTarea = $_GET['idListaTarea'] ?? null;
        if (isset($listaTareas["tareas"][$_GET["idListaTarea"]])) {
            $archivoJson = $listaTareas;
            $title = "Editar Tarea";
            include_once '../assets/layouts/header.php';
            require_once "../assets/components/editar-tarea.php";
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
        ? MAIN : ERROR3);
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
    /** int */    "id" => count($listaTareas['tareas']),
    /** string */    "descripcion" => $_POST['descripcion'],
    /** enum */    "prioridad" => $_POST['prioridad'],
    /** date */    "fecha-limite" => $_POST['fecha-limite'],
    /** enum */    "estado" => $_POST['estado'],
    /** int */    "id_lista" => $idListaTareas ?? 0,
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
        header(ERROR1);
    }
}

// BLOQUE DE CÓDIGO QUE CONTROLA LA EDICIÓN DEL LA TAREA Y SUS ATRIBUTOS
if (isset($_POST['change-info-tarea'])) {
    $estaActualizado = false;
    foreach ($listaTareas['tareas'] as $indiceTarea => $tarea) {
        $tareas = $listaTareas['tareas'][$indiceTarea];
        if ($_GET['idTarea'] == $indiceTarea) {

            $tareas['descripcion'] = $_POST['descripcion'] ?? $tareas['descripcion'];
            $tareas['prioridad'] = $_POST['prioridad'] ?? $tareas['prioridad'];
            $tareas['fecha-limite'] = $_POST['fecha-limite'] ?? $tareas['fecha-limite'];
            $tareas['estado'] = $_POST['estado'] ?? $tareas['estado'];
            $tareas['id_lista'] = $_POST['lista-de-tareas'] ?? $tareas['id_lista'];

            $listaTareas['tareas'][$indiceTarea] = $tareas;
            $estaActualizado = true;
        }
    }

    if (actualizarArchivoJson($listaTareas) && $estaActualizado) {
        header(MAIN);
    } else {
        header(ERROR4);
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
        
        header(LISTAS);
    } else {
        header(ERROR5);
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
        $listaTareas['lista'][$_GET['idLista']]['nombreLista'] = $_POST['nombreLista']
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
        header(ERROR6);
    }
    
    
    if(actualizarArchivoJson($listaTareas) && $estaActualizado){
        header("Location: /listas.php");
    }else{
        header(ERROR0);
    }
    
    
}

include_once '../assets/layouts/footer.php';