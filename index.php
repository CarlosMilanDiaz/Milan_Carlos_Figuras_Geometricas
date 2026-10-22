<?php
session_start();

if (isset($_POST["enviar"])) {
    $nuevaFigura = $_POST["tipoFigura"];

    // Si cambia de figura, borramos los lados anteriores
    if (isset($_SESSION["tipoFigura"]) && $_SESSION["tipoFigura"] != $nuevaFigura) {
        unset($_SESSION["lado1"], $_SESSION["lado2"], $_SESSION["lado3"]);
    }

    $_SESSION["tipoFigura"] = $nuevaFigura;
    header("Location: datos.php");
    exit;
}

// Si ya había una figura elegida, la dejamos seleccionada
$figuraGuardada = isset($_SESSION["tipoFigura"]) ? $_SESSION["tipoFigura"] : "";
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
    <div class="tarjeta inicio">
        <h1>📐 Figuras geométricas</h1>
        <p>Elige una figura para calcular su área y su perímetro</p>
        <form method="post" action="index.php" id="formFigura" novalidate>
            <select name="tipoFigura" id="tipoFigura">
                <option value="">-- Selecciona una figura --</option>
                <option value="Triángulo"  <?php if ($figuraGuardada == "Triángulo")  echo "selected"; ?>>🔺 Triángulo</option>
                <option value="Rectángulo" <?php if ($figuraGuardada == "Rectángulo") echo "selected"; ?>>▭ Rectángulo</option>
                <option value="Cuadrado"   <?php if ($figuraGuardada == "Cuadrado")   echo "selected"; ?>>⬛ Cuadrado</option>
                <option value="Círculo"    <?php if ($figuraGuardada == "Círculo")    echo "selected"; ?>>⚪ Círculo</option>
            </select>
            <p class="aviso" id="avisoFigura"></p>
            <button type="submit" name="enviar">Continuar</button>
        </form>
    </div>
</body>
</html>
