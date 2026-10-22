<?php
require_once "FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica
{
    private $lado2;
    private $lado3;

    public function __construct($tipoFigura, $lado1, $lado2, $lado3)
    {
        parent::__construct($tipoFigura, $lado1);
        $this->lado2 = $lado2;
        $this->lado3 = $lado3;
    }

    public function __destruct()
    {
    }

    public function getLado2()
    {
        return $this->lado2;
    }

    public function setLado2($lado2)
    {
        $this->lado2 = $lado2;
    }

    public function getLado3()
    {
        return $this->lado3;
    }

    public function setLado3($lado3)
    {
        $this->lado3 = $lado3;
    }

    public function calcularPerimetro()
    {
        return $this->getLado1() + $this->getLado2() + $this->getLado3();
    }

    // Fórmula de Herón
    public function calcularArea()
    {
        $s = $this->calcularPerimetro() / 2;
        return sqrt($s * ($s - $this->getLado1()) * ($s - $this->getLado2()) * ($s - $this->getLado3()));
    }

    public function __toString()
    {
        return $this->getTipoFigura() . " de lados " . $this->getLado1() . ", "
            . $this->getLado2() . " y " . $this->getLado3();
    }
}
