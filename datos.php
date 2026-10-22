<?php
session_start();

// Si no hay figura elegida, volvemos al inicio
if (!isset($_SESSION["tipoFigura"])) {
    header("Location: index.php");
    exit;
}

$tipoFigura = $_SESSION["tipoFigura"];

if (isset($_POST["calcular"])) {
    $_SESSION["lado1"] = $_POST["lado1"];
    if (isset($_POST["lado2"])) {
        $_SESSION["lado2"] = $_POST["lado2"];
    }
    if (isset($_POST["lado3"])) {
        $_SESSION["lado3"] = $_POST["lado3"];
    }
    header("Location: resultados.php");
    exit;
}

// Valores guardados en sesión (para rellenar el formulario)
$lado1 = isset($_SESSION["lado1"]) ? $_SESSION["lado1"] : "";
$lado2 = isset($_SESSION["lado2"]) ? $_SESSION["lado2"] : "";
$lado3 = isset($_SESSION["lado3"]) ? $_SESSION["lado3"] : "";

include "cabecera.php";
?>
                <h2>Introduce los datos</h2>
                <form method="post" action="datos.php" id="formDatos" data-figura="<?php echo $tipoFigura; ?>" novalidate>

                    <?php if ($tipoFigura == "Círculo") { ?>
                        <label for="lado1">Radio</label>
                        <input type="text" inputmode="decimal" id="lado1" name="lado1" data-nombre="Radio" value="<?php echo $lado1; ?>">

                    <?php } elseif ($tipoFigura == "Cuadrado") { ?>
                        <label for="lado1">Lado</label>
                        <input type="text" inputmode="decimal" id="lado1" name="lado1" data-nombre="Lado" value="<?php echo $lado1; ?>">

                    <?php } elseif ($tipoFigura == "Rectángulo") { ?>
                        <label for="lado1">Lado 1</label>
                        <input type="text" inputmode="decimal" id="lado1" name="lado1" data-nombre="Lado 1" value="<?php echo $lado1; ?>">
                        <label for="lado2">Lado 2</label>
                        <input type="text" inputmode="decimal" id="lado2" name="lado2" data-nombre="Lado 2" value="<?php echo $lado2; ?>">

                    <?php } elseif ($tipoFigura == "Triángulo") { ?>
                        <label for="lado1">Lado 1</label>
                        <input type="text" inputmode="decimal" id="lado1" name="lado1" data-nombre="Lado 1" value="<?php echo $lado1; ?>">
                        <label for="lado2">Lado 2</label>
                        <input type="text" inputmode="decimal" id="lado2" name="lado2" data-nombre="Lado 2" value="<?php echo $lado2; ?>">
                        <label for="lado3">Lado 3</label>
                        <input type="text" inputmode="decimal" id="lado3" name="lado3" data-nombre="Lado 3" value="<?php echo $lado3; ?>">
                    <?php } ?>

                    <div class="vista-previa" id="vistaPrevia"></div>

                    <button type="submit" name="calcular">Calcular</button>
                </form>
<?php include "pie.php"; ?>
