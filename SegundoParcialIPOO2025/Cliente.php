<?php
class Cliente {
    private $tipoDoc;
    private $numDoc;
    private $nombre;
    private $apellido;
    private $fechaNacimiento;

    //CONSTRUCT
    public function __construct($tipoDoc, $numDoc, $nombre, $apellido, $fechaNacimiento) {
        $this->tipoDoc = $tipoDoc;
        $this->numDoc = $numDoc;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->fechaNacimiento = $fechaNacimiento;
    }

    //SETTERS AND GETTERS
    public function getTipoDoc() {
        return $this->tipoDoc;
    }
    public function setTipoDoc($tipoDoc) {
        $this->tipoDoc = $tipoDoc;
    }
    public function getNumDoc() {
        return $this->numDoc;
    }
    public function setNumDoc($numDoc) {
        $this->numDoc = $numDoc;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }
    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }


    //TO STRING
    public function __toString() {
        return "Tipo Doc: " . $this->getTipoDoc() . ", Nro Doc: " . $this->getNumDoc() . ", Nombre: " . $this->getNombre() . ", Apellido: " . $this->getApellido() . ", Fecha Nac: " . $this->getFechaNacimiento();
    }
}
