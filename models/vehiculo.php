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
class Vehiculo {
    //put your code here
    private $placa;
    private $marca;
    private $categoria;
    private $tipo;
    private $precio;
    
    function getPlaca() {
        return $this->placa;
    }

    function getMarca() {
        return $this->marca;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setMarca($marca) {
        $this->marca = $marca;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }




}
