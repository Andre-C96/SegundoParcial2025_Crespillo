<?php

class Contrato {
    private $fechaInicio;
    private $fechaVencimiento;
    private $objPlan;
    private $estado;
    private $costo;
    private $renueva;
    private $objCliente;
    private $codigo;


    public function diasContratoVencido($objContrato) {
        // No implementado
    }

    public function actualizarEstadoContrato() {
        $diasVencidos = $this->diasContratoVencido($this);
        if ($diasVencidos == 0) {
            $this->setEstado("al día");
        } else {
            if ($diasVencidos > 0 && $diasVencidos <= 10) {
                $this->setEstado("moroso");
            } else {
                if ($diasVencidos > 10) {
                    $this->setEstado("suspendido");
                }
            }
        }
    }

    public function calcularImporte() {
        $importeTotal = $this->objPlan->getImporte();
        $arrayCanales = $this->objPlan->getCanales();
        foreach ($arrayCanales as $objCanal) {
            $importeTotal += $objCanal->getImporte();
        }
        return $importeTotal;
    }
    
}
