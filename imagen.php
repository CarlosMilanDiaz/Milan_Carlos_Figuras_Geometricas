<?php
// Espacio para la imagen de la figura.
$imagenes = [
    "Triángulo"  => "img/triangulo.png",
    "Rectángulo" => "img/rectangulo.jpg",
    "Cuadrado"   => "img/cuadrado.jpg",
    "Círculo"    => "img/circulo.png"
];
$rutaImagen = $imagenes[$_SESSION["tipoFigura"]];
?>
<div class="caja-imagen">
    <br>
    <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $_SESSION["tipoFigura"]; ?>">
</div>
