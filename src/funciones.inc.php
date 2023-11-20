<?php

/**
 * esInfoValida
 * Función que toma como parametro cualquier tipo de valor
 * aunque es común para cadena de caracteres y devuelve
 * ese mismo valor si es válido el dato o null por el contrario.
 * @param mixed $informacion
 * @return ?string
 */
function esInfoValida($informacion): ?string
{
    $estaValidado = false;
    (bool) $expresion = preg_match('/(\w\s?)+/', $informacion);
    if (
        $expresion &&
        !empty($informacion) || isset($informacion)
    ) {
        $informacion = htmlspecialchars($informacion);
        $informacion = stripcslashes($informacion);
        $informacion = trim($informacion);
        $estaValidado = true;
    }

    return ($estaValidado) ? $informacion : null;
}

/**
 * actualizarArchivoJson
 *  Función que toma como parametro un array asociativo que formatea
 * a un objeto json conservando la estructura clave => valor e
 * introduce los datos en el archivo devuelve un true o false.
 * @param ?array $contenidoArchivo
 * @return bool
 */
function actualizarArchivoJson(?array $contenidoArchivo): bool
{
    $json = (!empty($contenidoArchivo) && isset($contenidoArchivo))
        ? json_encode($contenidoArchivo, JSON_PRETTY_PRINT) : null;

    if (isset($json) && file_exists("json/tareas.json")) {
        file_put_contents("json/tareas.json", $json);
        return true;
    } else {
        return false;
    }
}

/**
 * obtenerContenidoJson
 *
 * @param string $json
 * @return ?array
 */
function obtenerContenidoJson(string $archivoJson): ?array
{
    if (file_exists($archivoJson)) {
        $contenido = file_get_contents($archivoJson);
        $json = (!empty($contenido) && isset($contenido))
            ? json_decode($contenido, true) : null;
    }
    return (is_array($json) && !empty($json)) ? $json : null;
}


/**
 * mostrarTareas
 *
 * @param  string $filtro
 * @return void
 */
function mostrarTareas(string $filtro = "no completado"): void
{
    $contenidoJson = obtenerContenidoJson("src/json/tareas.json");
    $estaChecked = ($filtro == "completado")? "<i class='bx bx-task' ></i>": "<i class='bx bx-task-x' ></i>";
    $volverAtras = ($filtro == "completado") ? "<i class='bx bx-arrow-back' ></i>": '<i class=" bx bx-check"></i>';
    if (isset($contenidoJson) && count($contenidoJson['tareas']) > 0) {
        foreach ($contenidoJson['tareas'] as $indiceTarea => $tareas) {
            if (!is_bool(array_search($filtro, $tareas))) {
                $enlaceAccion = ($filtro == "completado")
                ?"src/tareitas.php?accion=descompletarTarea&idTarea=$indiceTarea"
                :"src/tareitas.php?accion=completarTarea&idTarea=$indiceTarea";
                
                include 'assets/components/tarea.php';
            }
        }
    } else {
        echo "<tr>
            <td colspan='5'>
                <h1>NO TIENES NINGUNA LISTA </h1>
            </td>
        </tr>";
    }
}


/**
 * mostrarListas
 *
 * @return void
 */
function mostrarListas()
{
    $contenidoJson = obtenerContenidoJson("src/json/tareas.json");
    if (count($contenidoJson["lista"]) > 0) {
        foreach ($contenidoJson['lista'] as $indiceLista => $lista) {
            $tareasCompletadas = 0;
            $tareasIncompletas = 0;
            foreach ($contenidoJson['tareas'] as $tareas) {
                if ($tareas["id_lista"] == $lista['id_lista']) {
                    if ($tareas['estado'] == "completado") {
                        $tareasCompletadas = $tareasCompletadas + 1;
                    } else {
                        $tareasIncompletas = $tareasIncompletas + 1;
                    }
                }
            }
            include 'assets/components/lista-de-tareas.php';
        }
    } else {
        require_once "assets/components/crear-lista.php";
    }
}

function mostrarNotas(){
    $contenidoJson = obtenerContenidoJson("src/json/tareas.json");
    if (count($contenidoJson["nota"]) > 0) {
        foreach ($contenidoJson['nota'] as $indiceNota => $nota) {
            $nombreLista = "";
            foreach($contenidoJson['lista'] as $indiceLista => $lista){
                if($nota['id_lista'] == $lista['id_lista']){
                    $nombreLista = $lista['nombreLista'];
                }
            }
        include 'assets/components/nota.php';
        }
    } else {
        require_once "assets/components/crear-nota.php";
    }
}