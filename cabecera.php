<?php
// Se incluye en datos.php y resultados.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Figuras geométricas</title>
    <link rel="stylesheet" href="estilos.css">
    <script src="validaciones.js" defer></script>
</head>
<body>
<header class="cabecera">
    <h1>📐 Figuras geométricas</h1>
    <p>Figura seleccionada: <strong><?php echo $_SESSION["tipoFigura"]; ?></strong></p>
    <a class="boton-cambiar-figura" href="index.php">Cambiar figura</a>
</header>
<div class="contenedor">
    <div class="tarjeta">
        <div class="columnas">
            <?php include "imagen.php"; ?>
            <div class="contenido">
