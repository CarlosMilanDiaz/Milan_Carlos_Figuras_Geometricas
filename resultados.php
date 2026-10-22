<?php
session_start();
require_once "clases/Triangulo.php";
require_once "clases/Rectangulo.php";
require_once "clases/Cuadrado.php";
require_once "clases/Circulo.php";

if (!isset($_SESSION["tipoFigura"]) || !isset($_SESSION["lado1"])) {
    header("Location: index.php");
    exit;
}

$tipoFigura = $_SESSION["tipoFigura"];
$lado1 = $_SESSION["lado1"];
$lado2 = isset($_SESSION["lado2"]) ? $_SESSION["lado2"] : 0;
$lado3 = isset($_SESSION["lado3"]) ? $_SESSION["lado3"] : 0;

// Creamos el objeto según la figura elegida
if ($tipoFigura == "Triángulo") {
    $figura = new Triangulo($tipoFigura, $lado1, $lado2, $lado3);
} elseif ($tipoFigura == "Rectángulo") {
    $figura = new Rectangulo($tipoFigura, $lado1, $lado2);
} elseif ($tipoFigura == "Cuadrado") {
    $figura = new Cuadrado($tipoFigura, $lado1);
} else {
    $figura = new Circulo($tipoFigura, $lado1);
}

include "cabecera.php";
?>
                <h2>Resultados</h2>

                <?php if ($tipoFigura == "Triángulo" && ($lado1 + $lado2 <= $lado3 || $lado1 + $lado3 <= $lado2 || $lado2 + $lado3 <= $lado1)) { ?>
                    <div class="error">Con esos lados no se puede formar un triángulo.</div>
                <?php } else { ?>
                    <div class="dato">
                        <span>Tipo de figura</span>
                        <b><?php echo $figura->getTipoFigura(); ?></b>
                    </div>
                    <div class="dato">
                        <span>Descripción</span>
                        <b><?php echo $figura; ?></b>
                    </div>
                    <div class="dato destacado">
                        <span>Área</span>
                        <b><?php echo round($figura->calcularArea(), 2); ?></b>
                    </div>
                    <div class="dato destacado">
                        <span>Perímetro</span>
                        <b><?php echo round($figura->calcularPerimetro(), 2); ?></b>
                    </div>
                <?php } ?>

                <a class="boton" href="datos.php">Modificar datos</a>
                <a class="boton secundario" href="index.php">Otra figura</a>
<?php include "pie.php"; ?>
