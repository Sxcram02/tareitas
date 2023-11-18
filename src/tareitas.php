<?php
require_once "config.inc.php";
$title = "Tareitas";

// PARA LOS DATOS RECIBIDOS MEDIANTE POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $estaValidado = false;
    foreach ($_POST as $clave => $valor) {
        if (!is_array($valor)) {
            $datoAvalidar = esInfoValida($valor);
            $estaValidado = (!isset($datoAvalidar)) ? false : true;
            if (!$estaValidado) {
                break;
            }
        } else {
            foreach ($valor as $indice => $contenido) {
                $datoAvalidar = esInfoValida($contenido);
                $estaValidado = (!isset($datoAvalidar)) ? false : true;
                if (!$estaValidado) {
                    break;
                }
            }
        }
    }

    if (!$estaValidado) {
        unset($_POST);
        header(ERROR7);
    }
}

/**
 * ACCIONES ESPECIFICADAS CONTROLADAS POR $_GET
 * POR METODO GET OBTENGO EL ID DE LA TAREA
 * PARA ELIMINAR O EDITAR O COMPLETAR
 */

switch ($accion) {
    case "crearNota":
        $archivoJson = $listaTareas;
        $title = "Crear nota";
        include_once '../assets/layouts/header.php';
        require_once "../assets/components/crear-nota.php";
        break;
    case "crearTarea":
        $archivoJson = $listaTareas;
        $title = "Crear tarea";
        include_once '../assets/layouts/header.php';
        require_once "../assets/components/crear-tarea.php";
        break;
    case "crearLista":
        $archivoJson = $listaTareas;
        $title = "Crear lista";
        include_once '../assets/layouts/header.php';
        require_once '../assets/components/crear-lista.php';
        break;
    case "eliminarNota":
        if (!empty($listaTareas['nota'][$_GET['idNota']])) {
            unset($listaTareas['nota'][$_GET['idNota']]);
            actualizarArchivoJson($listaTareas);
            header(NOTAS);
        } else {
            header(ERROR8);
        }
        break;
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
        if (
            !empty($listaTareas['lista'][$_GET['idLista']]) &&
            $_GET['idLista'] != 0
        ) {
            foreach ($listaTareas['tareas'] as $indiceTarea => $tareas) {
                if ($listaTareas['lista'][$_GET['idLista']]['id_lista'] == $tareas['id_lista']) {
                    unset($listaTareas['tareas'][$indiceTarea]);
                }
            }

            unset($listaTareas['lista'][$_GET['idLista']]);
            actualizarArchivoJson($listaTareas);
            header(LISTAS);
        } else {
            header(ERROR6);
        }
        break;
    case "editarNota":
        $idNota = $_GET['idNota'] ?? null;
        if(isset($listaTareas['nota'][$idNota])){
            $archivoJson = $listaTareas;
            $title = "Editar nota";
            include_once '../assets/layouts/header.php';
            require_once "../assets/components/editar-nota.php";
        }else{
            header(ERROR8);
        }
        break;
    case 'editarLista':
        $idLista = $_GET['idLista'] ?? null;
        if (isset($listaTareas["lista"][$idLista])) {
            $archivoJson = $listaTareas;
            $title = "Editar lista";
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
            $title = "Editar tarea";
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
if (isset($_POST["crear-info-tarea"]) && !isset($_GET['error'])) {
    $contieneInformacion = true;

    $idListaTareas = $_POST['lista-de-tareas'] ?? 0;

    $tarea = [
        /** int */
        "id" => count($listaTareas['tareas']),
        /** string */
        "descripcion" => $_POST['descripcion'],
        /** enum */
        "prioridad" => $_POST['prioridad'],
        /** date */
        "fecha-limite" => date('d-m-Y',strtotime($_POST['fecha-limite'])),
        /** enum */
        "estado" => $_POST['estado'],
        /** int */
        "id_lista" => $idListaTareas,
    ];

    foreach ($tarea as $clave => $valor) {
        if (!isset($valor)) {
            $contieneInformacion = false;
        }
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
if (isset($_POST['change-info-tarea']) && !isset($_GET['error'])) {
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
if (isset($_POST["crear-lista-de-tareas"]) && !isset($_GET['error'])) {
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

        if (isset($_POST['tareas-asociadas'])) {
            // AUN NADA
        }

        header(LISTAS);
    } else {
        header(ERROR5);
    }
}


// BLOQUE DE CÓDIGO QUE CONTROLA LA ACTUALIZACIÓN DE LISTA
if (isset($_POST["change-info-lista"]) && !isset($_GET['error'])) {
    $estaActualizado = false;
    if (!is_bool(array_search($_GET['idLista'], $listaTareas['lista'][$_GET['idLista']]))) {
        /**
         * array(
         *   "lista" => array(
         *      array(
         *          "nombreLista": <valor>,
         *          "id_lista": <valor>
         *          )
         *      array(
         *          "nombreLista": <valor2>,
         *          "id_lista": <valor2>
         *          )
         *      )
         *  )
         */
        $listaTareas['lista'][$_GET['idLista']]['nombreLista'] = $_POST['nombreLista']
            ?? $listaTareas['lista'][$_GET['idLista']]['nombreLista'];

        if (
            isset($listaTareas['lista'][$_GET['idLista']]['nombreLista']) &&
            !empty($listaTareas['lista'][$_GET['idLista']]['nombreLista'])
        ) {
            actualizarArchivoJson($listaTareas);
            $estaActualizado = true;
        }


        if (
            isset($_POST['tareasAniadidas']) &&
            count($_POST['tareasAniadidas']) > 0
        ) {
            $estaActualizado = false;
            foreach ($listaTareas['tareas'] as $indiceTarea => $tareas) {
                foreach ($_POST['tareasAniadidas'] as $valor) {
                    if ($valor == $tareas['id']) {
                        $listaTareas['tareas'][$indiceTarea]["id_lista"] = $_GET['idLista'];
                        $estaActualizado = true;
                    }
                }
            }
            actualizarArchivoJson($listaTareas);
        }


        if (
            isset($_POST['tareasEliminadas']) &&
            count($_POST['tareasEliminadas']) > 0
        ) {
            $estaActualizado = false;
            foreach ($listaTareas['tareas'] as $indiceTarea => $tarea) {
                if (!is_bool(array_search($indiceTarea, $_POST['tareasEliminadas']))) {
                    $listaTareas['tareas'][$indiceTarea]["id_lista"] = 0;
                    $estaActualizado = true;
                }
            }
        }
    } else {
        header(ERROR6);
    }


    if (actualizarArchivoJson($listaTareas) && $estaActualizado) {
        header("Location: /listas.php");
    } else {
        header(ERROR7);
    }
}

//_-------------------------------------------------------------------//
//_--------------------------- NOTAS ----------------------------------//
//_-------------------------------------------------------------------//
// BLOQUE DE CÓDIGO QUE CONTROLA LA CREACIÓN DE UNA NOTA
if(isset($_POST['crear-info-nota'])){
    $contieneInformacion = false;
    
    $nota = [
        "id" => count($listaTareas['nota']),
        "titulo" => $_POST['contenido-nota'] ?? "nota anónima",
        "descripcion" => $_POST['contenido-nota'] ?? "Sin contenido",
        "color_nota" => $_POST['color-nota'] ?? "yellow",
        "id_lista" => (isset($_POST['lista-asociada'])) ? $_POST['lista-asociada'] : "sin lista"
    ];

    foreach ($nota as $clave => $valor) {
        $contieneInformacion = (isset($valor)) ? true : false;
    }
    if ($contieneInformacion) {
        array_push($listaTareas['nota'], $nota);
        if (actualizarArchivoJson($listaTareas)) {
            header(NOTAS);
        }
    } else {
        header(ERROR1);
    }
}


// BLOQUE DE CÓDIGO QUE CONTROLA LA EDICIÓN Y ACTUALIZACIÓN DE NOTAS
if(isset($_POST['change-info-nota'])){
    $idNota = $_GET['idNota'] ?? null;
    $estaActualizado = false;
    if(count($listaTareas['nota'][$idNota]) > 0){
        foreach($listaTareas['nota'] as $indiceNota => $nota){
            if($idNota == $indiceNota){
                $nota['titulo-nota'] = $_POST['titulo-nota'] ?? $nota['titulo-nota'];
                $nota['color_nota'] = $_POST['color-nota'] ?? $nota['color_nota'];
                $nota['descripcion'] = $_POST['contenido-nota'] ?? $nota['descripcion'];
                $nota['id_lista'] = $_POST['lista-asociada'] ?? $nota['id_lista'];
                $estaActualizado = true;
                $listaTareas['nota'][$idNota] = $nota;
            }
        }
        
        if($estaActualizado){
            actualizarArchivoJson($listaTareas);
            header(NOTAS);
        }else{
            header(ERROR7);
        }
        
    }else{
        header(ERROR8);
    }
}

include_once '../assets/layouts/footer.php';