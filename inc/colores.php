<?php

$db = require_once __DIR__.'./../mysql.php';
$conexion = $db;

$color = $_GET['q'];

$resultado = $conexion->query("SELECT * FROM ep_colaboradores WHERE nome LIKE '%$color%'");

$datos = array();

while ($row=$resultado->fetch_assoc()){

	$datos[] = $row['nome'];
}

echo json_encode($datos);