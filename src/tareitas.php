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
    
    /**---------------------------------------------------------------------- */
    /**-------------------------CREACIONES----------------------------------- */
    /**---------------------------------------------------------------------- */
    case "crearNota":
        mostrarVista($listaTareas, "Crear Nota","crear","nota");
        break;
    case "crearTarea":
        mostrarVista($listaTareas, "Crear Tarea","crear","tarea");
        break;
    case "crearLista":
        mostrarVista($listaTareas, "Crear Lista","crear","lista");
        break;
            
    /**---------------------------------------------------------------------- */
    /**-------------------------ELIMINACIONES-------------------------------- */
    /**---------------------------------------------------------------------- */
    case "eliminarTodas":
        foreach ($listaTareas['tareas'] as $indiceTarea => $tarea) {
            unset($listaTareas['tareas'][$indiceTarea]);
            actualizarArchivoJson($listaTareas);
        }
        header(MAIN);
        break;
    case "eliminarNota":
        $estaEliminado = eliminar($listaTareas, "nota", $_GET['idNota']);
        header(($estaEliminado) ? NOTAS : ERROR8);
        break;
    case "eliminarTarea":
        $estaEliminado = eliminar($listaTareas, "tareas", $_GET['idTarea']);
        header(($estaEliminado) ? MAIN : ERROR2);
        break;
    case "eliminarLista":
        $estaEliminado = false;
        if (!empty($listaTareas['lista'][$_GET['idLista']]) && $_GET['idLista'] != 0) {
            $estaEliminado = eliminar($listaTareas, "lista", $_GET['idLista']);
        }
        header(($estaEliminado) ? LISTAS : ERROR6);
        break;
        
    /**------------------------------------------------------------------ */
    /**-------------------------EDICIONES-------------------------------- */
    /**------------------------------------------------------------------ */
    case "editarNota":
        $idNota = $_GET['idNota'] ?? null;
        (isset($listaTareas['nota'][$idNota]))
            ?mostrarVista($listaTareas,"Editar Nota","editar","nota")
            :header(ERROR8);
        break;
    case 'editarLista':
        $idLista = $_GET['idLista'] ?? null;
        (isset($listaTareas["lista"][$idLista]))
            ?mostrarVista($listaTareas,"Editar Lista","editar","lista")
            :header(ERROR6);
        break;
    case "editarTarea":
        $idTarea = $_GET['idListaTarea'] ?? null;
        (isset($listaTareas["tareas"][$_GET["idListaTarea"]]))
            ? mostrarVista($listaTareas,"Editar Tarea","editar","tareas")
            : header(ERROR2);
        break;
        
    /**------------------------------------------------------------------ */
    /**-------------------------SERVICIOS-------------------------------- */
    /**------------------------------------------------------------------ */
    case "completarTarea":
        $listaTareas['tareas'][$_GET['idTarea']]['estado'] =
            (isset($listaTareas['tareas'][$_GET['idTarea']]))
            ? "completado"
            : $listaTareas['tareas'][$_GET['idTarea']]['estado'];
        header((actualizarArchivoJson($listaTareas))
            ? MAIN : ERROR3);
        break;
    case "descompletarTarea":
        $listaTareas['tareas'][$_GET['idTarea']]['estado'] =
            (isset($listaTareas['tareas'][$_GET['idTarea']]))
            ? "no completado"
            : $listaTareas['tareas'][$_GET['idTarea']]['estado'];
        header((actualizarArchivoJson($listaTareas))
            ? MAIN : ERROR3);
        break;

    case "completarTodas":
        foreach ($listaTareas['tareas'] as $indiceTarea => $tarea) {
            $listaTareas['tareas'][$indiceTarea]['estado'] = "completado";
            actualizarArchivoJson($listaTareas);
        }
        header(MAIN);
        break;

        
    /**---------------------------------------------------------------------- */
    /**-------------------------VISUALIZACIONES------------------------------ */
    /**---------------------------------------------------------------------- */
    case "verLista":
        $idLista = $_GET['idLista'] ?? null;
        $lista = $listaTareas['lista'][$idLista] ?? null;
        if (!isset($lista)) {
            header(ERROR6);
        }
        
        $tareas = array_filter(
            $listaTareas['tareas'],
            function ($valor) use ($idLista) {
                return $valor['id_lista'] == $idLista;
            }
        );

        $nota = array_filter(
            $listaTareas['nota'],
            function ($valor) use ($idLista) {
                return $valor['id_lista'] == $idLista;
            }
        );
        $lista['tareas'] = $tareas;
        $lista['nota'] = $nota;
        $title = "Ver Lista";

        include_once '../assets/layouts/header.php';
        include_once '../assets/components/ver-listas.php';
        break;
    default:
        break;
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
        "fecha-limite" => $_POST['fecha-limite'],
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
//_--------------------------- NOTAS ----------------------------------//
//_-------------------------------------------------------------------//
// BLOQUE DE CÓDIGO QUE CONTROLA LA CREACIÓN DE UNA NOTA
if (isset($_POST['crear-info-nota'])) {
    $contieneInformacion = false;

    $nota = [
        "id" => count($listaTareas['nota']),
        "titulo-nota" => $_POST['contenido-nota'] ?? "nota anónima",
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
if (isset($_POST['change-info-nota'])) {
    $idNota = $_GET['idNota'] ?? null;
    $estaActualizado = false;

    if (isset($listaTareas['nota'][$idNota])) {
        foreach ($listaTareas['nota'] as $indiceNota => $nota) {
            if ($idNota == $indiceNota) {
                $nota['titulo-nota'] = (!empty($_POST['titulo-nota']))
                    ? $_POST['titulo-nota'] : $nota['titulo-nota'];

                $nota['color_nota'] = (!empty($_POST['color-nota']))
                    ? $_POST['color-nota'] : $nota['color_nota'];

                $nota['descripcion'] = (!empty($_POST['contenido-nota']))
                    ? $_POST['contenido-nota'] : $nota['descripcion'];

                $nota['id_lista'] = (!empty($_POST['lista-asociada']))
                    ? $_POST['lista-asociada'] : $nota['id_lista'];

                $estaActualizado = true;

                $listaTareas['nota'][$idNota] = $nota;
            }
        }

        if ($estaActualizado) {
            actualizarArchivoJson($listaTareas);
            header(NOTAS);
        } else {
            header(ERROR7);
        }
    } else {
        header(ERROR8);
    }
}

include_once '../assets/layouts/footer.php';