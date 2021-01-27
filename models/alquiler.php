<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FacturaDTO
 *
 * @author ESTUDIANTE
 */
class alquiler {
    //put your code here
    private $nombreCliente;
    private $fecha;
    private $entrada;
    private $salida;
    private $placa;
    private $estado; 
    
    function getNombreCliente() {
        return $this->nombreCliente;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getEntrada() {
        return $this->entrada;
    }

    function getSalida() {
        return $this->salida;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getEstado() {
        return $this->estado;
    }

    function setNombreCliente($nombreCliente) {
        $this->nombreCliente = $nombreCliente;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    function setSalida($salida) {
        $this->salida = $salida;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }


}