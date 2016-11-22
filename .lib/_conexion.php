<?php
include("_config.php");

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

function conexionBD()
{
	$Mensaje="";
	$Conexion = new mysqli(SERVIDOR, USUARIO, PASSWORD, BASEDATOS);

	if ($Conexion)
		$Conexion->query("SET NAMES 'utf8'");

	return $Conexion;
}
?>