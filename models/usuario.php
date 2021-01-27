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
class Usuario {
    //put your code here
    private $cedula;
    private $nombre;
    private $apellido;
    private $telefono;
    private $direcion;
    private $correo;
    private $contrasenia;
    private $ciudad;

    function getCedula() {
        return $this->cedula;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getDirecion() {
        return $this->direcion;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getContrasenia() {
        return $this->contrasenia;
    }
    
    function getCiudad() {

        return $this->ciudad;
    }
    
    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setDirecion($direcion) {
        $this->direcion = $direcion;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setContrasenia($contrasenia) {
        $this->contrasenia = $contrasenia;
    }
    function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }


}
