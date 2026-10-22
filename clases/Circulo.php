<?php
require_once "FiguraGeometrica.php";

// En el círculo, lado1 es el radio
class Circulo extends FiguraGeometrica
{
    public function __construct($tipoFigura, $lado1)
    {
        parent::__construct($tipoFigura, $lado1);
    }

    public function __destruct()
    {
    }

    public function calcularArea()
    {
        return pi() * $this->getLado1() * $this->getLado1();
    }

    public function calcularPerimetro()
    {
        return 2 * pi() * $this->getLado1();
    }

    public function __toString()
    {
        return $this->getTipoFigura() . " de radio " . $this->getLado1();
    }
}
