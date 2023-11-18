<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Marcos Domínguez">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  LINKS CSS Y LIBRERIAS DE ICONOS Y FUENTES-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/assets/styles/index.css">
    <link rel="stylesheet" href="/assets/styles/app.css">
    <link rel="stylesheet" href="/assets/styles/tareas.css">
    <link rel="stylesheet" href="/assets/styles/editar-tarea.css">
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">
    <title><?php echo $title ?></title>
</head>

<body>
    <!--  HEADER COMÚN A TODAS LAS VISTAS -->
    <header>
        <div class="box-content">
            <img src="/assets/images/logo.png" alt="logo">
        </div>
        <ul>
            <li><i class='bx bxs-edit'></i><a href="/index.php">Tareas</a></li>
            <li><i class='bx bx-list-ul'></i><a href="/listas.php">Listas</a></li>
            <li><i class='bx bx-notepad'></i><a href="/notas.php">Notas</a></li>
        </ul>
    </header>