<?php
/*
Archivo config.php
@version 1.0
@licencia GNU Lesser General Public License, http://www.gnu.org/copyleft/lesser.html
@autor Ing. Erick Fernando Pinto Valdivia
@usuario Municipalidad Distrital de Yarabamba
@creado 2016-09-22 / 10:40:00 (-5 GMT)
@link  ../../.lib/_config.php
*/

$Servidor='127.0.0.1'; //Direccion IP o Nombre del Servidor de Base de Datos
$Usuario='root'; //Usuario para acceso a la Base de Datos
$Password='Mikelode100x'; //Password de acceso a la Base de Datos
$Basedatos='MUNIYRB-SISGDC'; //Nombre de la Base de Datos
$Cliente='Municipalidad Distrital de Yarabamba';
$Sistema='Sistema de Gesti&oacute;n de Inventario Inform&aacute;tico';
$Alias='SISGDC';
$Autor='SYMVA INC.';

$ErrorConexion='Error de conexion a la Base de Datos, revise los parametros';
$AgregarOK='Los datos han sido agregados correctamente';
$EditarOK='Los datos han sido editados correctamente';
$EliminarOK='Los datos han sido removidos correctamente';

$documentoOK = 'EL documento ha sido registrado correctamente';
$aceptarOK = 'El documento ha sido aceptado correctamente';
$atenderOK = 'El documento ha sido atendido correctamente';
$derivarOK = 'EL documento ha sido derivado correctamente';

define ('SERVIDOR',$Servidor);
define ('USUARIO',$Usuario);
define ('PASSWORD',$Password);
define ('BASEDATOS',$Basedatos);
define ('CLIENTE',$Cliente);
define ('SISTEMA',$Sistema);
define ('ALIAS',$Alias);
define ('AUTOR',$Autor);

define('ERRORCONEXION',$ErrorConexion);
define('AGREGAROK',$AgregarOK);
define('EDITAROK',$EditarOK);
define('ELIMINAROK',$EliminarOK);

define('NUEVODOCOK',$documentoOK);
define('ACEPTAROK',$aceptarOK);
define('ATENDEROK',$atenderOK);
define('DERIVAROK',$derivarOK);

?>