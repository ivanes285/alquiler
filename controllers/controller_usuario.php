<?php

$opcion = $_REQUEST['opcion'];
include_once './ModelFactura.php';
//$model = new ModelFactura();
session_start();

switch ($opcion) {
    case "guardar":
        $nombreCliente = $_REQUEST['nombreCliente'];
        $subtotal = $_REQUEST['subtotal'];
        $factura = $model->crearFactura($nombreCliente, $subtotal);
        $_SESSION['factura'] = serialize($factura);
        header('Location: resultado.php');
        break;
    case "consultar":
        $listado=$model->consultarFacturas();
        $_SESSION['listado']= serialize($listado);
        header("Location: index.php");
        break;
    case "eliminar":
        $nombreCliente=$_REQUEST['nombreCliente'];
        break;
    case "editar":
        break;
}