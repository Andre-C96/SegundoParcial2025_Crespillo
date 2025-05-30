<?php

class ContratoWeb extends Contrato {

    // Atributos privados

    private $porcentajeDescuento;



    // Constructor

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $estado, $costo, $renueva, $objCliente, $porcentajeDescuento = 10) {

        // Llamada al constructor de la clase padre

        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $estado, $costo, $renueva, $objCliente);

        $this->porcentajeDescuento = $porcentajeDescuento;

    }



    // ToString

    public function __toString() {

        $cadena = parent::__toString();

        $cadena .= "Porcentaje de descuento: " . $this->getPorcentajeDescuento() . "%\n";

        return $cadena;

    }

   public function calcularImporte() {
    $importeBase = parent::calcularImporte();
    $descuento = $importeBase * ($this->getPorcentajeDescuento() / 100);
    return $importeBase - $descuento;
    }

}