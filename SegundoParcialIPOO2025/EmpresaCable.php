<?php
class EmpresaCable {
    private $colPlanes;      
    private $colCanales;     
    private $colClientes;    
    private $colContratos;   

    
    public function __construct() {
        $this->colPlanes = [];
        $this->colCanales = [];
        $this->colClientes = [];
        $this->colContratos = [];
    }

    
    public function incorporarPlan($objPlanNuevo) {
        $existe = false;
        $canalesNuevo = $objPlanNuevo->getCanales();
        $mgNuevo = $objPlanNuevo->getMG();
        $i = 0;
        $colPlanes = $this->getColPlanes();
        $cantPlanes = count($colPlanes);
        while ($i < $cantPlanes && !$existe) {
            $objPlan = $colPlanes[$i];
            $canales = $objPlan->getCanales();
            $mg = $objPlan->getMG();
            $cantCanales = count($canales);
            $cantCanalesNuevo = count($canalesNuevo);
            if ($cantCanales == $cantCanalesNuevo && $mg == $mgNuevo) {
                $mismosCanales = true;
                $j = 0;
                while ($j < $cantCanales && $mismosCanales) {
                    if ($canales[$j] != $canalesNuevo[$j]) {
                        $mismosCanales = false;
                    }
                    $j++;
                }
                if ($mismosCanales) {
                    $existe = true;
                }
            }
            $i++;
        }
        $agregado = false;
        if (!$existe) {
            $this->colPlanes[] = $objPlanNuevo;
            $agregado = true;
        }
        return $agregado;
    }


    public function buscarContrato($tipoDoc, $numDoc) {
        $i = 0;
        $contratoEncontrado = null;
        $colContratos = $this->colContratos;
        $cantContratos = count($colContratos);
        while ($i < $cantContratos && $contratoEncontrado == null) {
            $objContrato = $colContratos[$i];
            $objCliente = $objContrato->getObjCliente();
            if ($objCliente->getTipoDoc() == $tipoDoc && $objCliente->getNumDoc() == $numDoc) {
                $contratoEncontrado = $objContrato;
            }
            $i++;
        }
        return $contratoEncontrado;
    }



    public function incorporarContrato($objPlan, $objCliente, $fechaInicio, $fechaVencimiento, $esWeb) {
        $contratoExistente = $this->buscarContrato($objCliente->getTipoDoc(), $objCliente->getNumDoc());
        if ($contratoExistente != null) {
            if ($contratoExistente->getEstado() != "finalizado") {
                $contratoExistente->setEstado("finalizado");
            }
        }
        $costo = $objPlan->getImporte();
        if ($esWeb) {
            $nuevoContrato = new ContratoWeb($fechaInicio, $fechaVencimiento, $objPlan, "al día", $costo, true, $objCliente);
        } else {
            $nuevoContrato = new Contrato($fechaInicio, $fechaVencimiento, $objPlan, "al día", $costo, true, $objCliente);
        }
        $this->colContratos[] = $nuevoContrato;
        return $nuevoContrato;
    }


    public function retornarPromImporteContratos($codigoPlan) {
        $colContratos = $this->colContratos;
        $cantContratos = count($colContratos);
        $sumaImportes = 0;
        $cantidad = 0;
        $i = 0;
        while ($i < $cantContratos) {
            $objContrato = $colContratos[$i];
            $objPlan = $objContrato->getObjPlan();
            if ($objPlan->getCodigo() == $codigoPlan) {
                $sumaImportes += $objContrato->calcularImporte();
                $cantidad++;
            }
            $i++;
        }
        $promedio = 0;
        if ($cantidad > 0) {
            $promedio = $sumaImportes / $cantidad;
        }
        return $promedio;
    }

    public function pagarContrato($codigoContrato) {
        $colContratos = $this->colContratos;
        $cantContratos = count($colContratos);
        $i = 0;
        $importeFinal = 0;
        $contratoEncontrado = null;
        while ($i < $cantContratos && $contratoEncontrado == null) {
            $objContrato = $colContratos[$i];
            if ($objContrato->getCodigo() == $codigoContrato) {
                $contratoEncontrado = $objContrato;
            }
            $i++;
        }
        if ($contratoEncontrado != null) {
            $contratoEncontrado->actualizarEstadoContrato();
            $estado = $contratoEncontrado->getEstado();
            if ($estado == "al día") {
                $importeFinal = $contratoEncontrado->calcularImporte();
                $contratoEncontrado->setRenueva(true);

            } else {
                if ($estado == "moroso") {
                    $diasMora = $contratoEncontrado->diasContratoVencido($contratoEncontrado);
                    $importeBase = $contratoEncontrado->calcularImporte();
                    $multa = $importeBase * 0.10 * $diasMora;
                    $importeFinal = $importeBase + $multa;
                    $contratoEncontrado->setEstado("al día");
                    $contratoEncontrado->setRenueva(true);

                } else {
                    if ($estado == "suspendido") {
                        $diasMora = $contratoEncontrado->diasContratoVencido($contratoEncontrado);
                        $importeBase = $contratoEncontrado->calcularImporte();
                        $multa = $importeBase * 0.10 * $diasMora;
                        $importeFinal = $importeBase + $multa;
                        $contratoEncontrado->setRenueva(false);

                    } else {
                        if ($estado == "finalizado") {
                            $importeFinal = 0;
                        }
                    }
                }
            }
        }
        return $importeFinal;
    }
    
}

