<?php

include_once "Canal.php";
include_once "Plan.php";
include_once "Cliente.php";
include_once "EmpresaCable.php";
include_once "Contrato.php";
include_once "ContratoWeb.php";

// Crear instancia de EmpresaCable
$objEmpresa = new EmpresaCable();

// Crear instancias de Canal
$objCanal1 = new Canal("noticias", 500, true);
$objCanal2 = new Canal("deportivo", 700, false);
$objCanal3 = new Canal("peliculas", 600, true);

// Crear instancias de Plan
$arrayCanalesPlan1 = [$objCanal1, $objCanal2];
$arrayCanalesPlan2 = [$objCanal2, $objCanal3];
$objPlan1 = new Plan(111, $arrayCanalesPlan1, 2000, true); // Código 111
$objPlan2 = new Plan(222, $arrayCanalesPlan2, 2500, false); // Otro código

// Crear instancia de Cliente
$objCliente = new Cliente("DNI", 12345678, "Juan", "Perez", "23-01-1996");

// Crear contratos
$fechaInicio = date("d-m-Y");
$fechaVencimiento = "30-06-2025";


$objContratoEmpresa = new Contrato($fechaInicio, $fechaVencimiento, $objPlan1, "al día", 0, true, $objCliente, 1);

$objContratoWeb1 = new ContratoWeb($fechaInicio, $fechaVencimiento, $objPlan2, "al día", 0, true, $objCliente, 2);
$objContratoWeb2 = new ContratoWeb($fechaInicio, $fechaVencimiento, $objPlan1, "al día", 0, true, $objCliente, 3);


echo "Importe Contrato Empresa: " . $objContratoEmpresa->calcularImporte() . "\n";
echo "Importe Contrato Web 1: " . $objContratoWeb1->calcularImporte() . "\n";
echo "Importe Contrato Web 2: " . $objContratoWeb2->calcularImporte() . "\n";

// Incorporar planes
$objEmpresa->incorporarPlan($objPlan1);
$objEmpresa->incorporarPlan($objPlan2);

// Fechas para contratos
$fechaInicio = "20-04-2025";
$fechaVencimiento = "20-05-2025";


$contratoEmpresa = $objEmpresa->incorporarContrato($objPlan1, $objCliente, $fechaInicio, $fechaVencimiento, false);

$contratoWeb = $objEmpresa->incorporarContrato($objPlan2, $objCliente, $fechaInicio, $fechaVencimiento, true);


$importeEmpresa = $objEmpresa->pagarContrato($contratoEmpresa->getCodigo());
echo "Importe a pagar (empresa): $importeEmpresa\n";


$importeWeb = $objEmpresa->pagarContrato($contratoWeb->getCodigo());
echo "Importe a pagar (web): $importeWeb\n";


$promedio = $objEmpresa->retornarPromImporteContratos(111);
echo "Promedio importes contratos plan 111: $promedio\n";

