<?php

session_start();

use Carbon\Carbon;

include("../_conexion.php");
require '../../vendor/autoload.php';

//Inicializa controles para "Agregar Equipo"
if (isset($_POST['initSubModulo11']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "select ofiId, ofiDesc from `".BASEDATOS."`.munioficina where ofiActivo = 1";
		$ListaOficinas = $Conexion -> query($Sentencia);
		while ($Fila = $ListaOficinas -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Sentencia = "select a.nCodigo, a.cUsuario, b.ofiId, b.ofiCod, b.ofiDesc from musuarios a
						inner join munioficina b on b.ofiId = a.ofiId
						where nCodigo = '" . $_SESSION['codigo'] . "'";
		$OficinaUsuario = $Conexion->query($Sentencia);
		while($Fila = $OficinaUsuario->fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."$";
		$Respuesta .= "%";

		$Conexion -> close();
	}
	echo $Respuesta;
}

//Inicializa controles para "Editar Equipo"
if (isset($_POST['initSubModulo12']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "select a.nCodigo, a.cUsuario, a.cPass, a.nTipo, a.cActivo, a.ofiId, a.cNombres, a.cPaterno,
                    a.cMaterno, a.cDni, b.ofiDesc, if(a.cActivo = 1, 'Activado','Desactivado') as estado
                    from musuarios a
                    inner join munioficina b on b.ofiId = a.ofiId
                    where a.cFlagEliminado = 0;";

		$ListaUsuarios = $Conexion -> query($Sentencia);
		while ($Fila = $ListaUsuarios -> fetch_row())
			$Respuesta .= implode('|',$Fila)."$";
		$Respuesta .= "%";

		$Sentencia = "select ofiId, ofiDesc from `".BASEDATOS."`.munioficina where ofiActivo = 1";
		$ListaOficinas = $Conexion -> query($Sentencia);
		while ($Fila = $ListaOficinas -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Conexion -> close();
	}
	echo $Respuesta;
}

if(isset($_POST['newusr']))
{
	$Conexion = conexionBD();

	if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
	else
	{
        $Respuesta = "";
        $msg = '';

        $Conexion->autocommit(false);

        try{

            $sentencia = "SELECT * FROM musuarios WHERE cDni = '".$_POST['nusrDni']."'";
            $verificar = $Conexion->query($sentencia);

            if($verificar->num_rows == 0)
            {
                $sentencia = "INSERT INTO musuarios(cUsuario,cPass,nTipo,cActivo,ofiId,cNombres,cPaterno,cMaterno,cDni)
                      VALUES('".$_POST['nusrDni']."','".$_POST['nusrDni']."','2','1','".$_POST['nusrOficina']."','".$_POST['nusrNombres']."','".$_POST['nusrPaterno']."','".$_POST['nusrMaterno']."','".$_POST['nusrDni']."')";

                if(!$Conexion->query($sentencia))
                    throw new Exception('No se ha podido registrar el nuevo usuario');
            }
            else
            {
                throw new Exception('ATENCION: El usuario que intenta registrar ya existe');
            }

            $Respuesta = 200;
            $msg = "Usuario creado correctamente. \n El nombre de usuario y contraseña para ingresar al sistema es el DNI de la persona registrada ";

            $Conexion->commit();

        }catch (Exception $e){

            $Conexion->rollback();
            $Respuesta = 500;
            $msg = 'Error: '.$e->getMessage()."\n";

        }

        $Conexion->close();
	}

	echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_GET['restorepass']))
{
    $Conexion = conexionBD();

    if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = "";
        $msg = '';
        $idRow = explode('-',$_GET['row']);
        $sentencia = "UPDATE musuarios SET cPass = 'GESTIONDOCUMENTARIA' WHERE nCodigo = $idRow[2]";

        if($Conexion->query($sentencia))
        {
            $Respuesta = 200;
            $msg = 'Contraseña restaurada correctamente.\n Nueva Contraseña: GESTIONDOCUMENTARIA';
        }
        else
        {
            $Respuesta = 500;
            $msg = 'No se pudo restaurar la constraseña';
        }

        $Conexion->close();
    }

    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_GET['changeState']))
{
    $Conexion = conexionBD();

    if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = "";
        $msg = '';
        $sentencia = "UPDATE musuarios SET cActivo = '".$_POST['value']."' WHERE nCodigo = '".$_POST['pk']."';";

        if($Conexion->query($sentencia))
        {
            $Respuesta = 200;
            $msg = 'Estado cambiado correctamente';
        }
        else
        {
            $Respuesta = 500;
            $msg = 'Error al intentar cambiar el estado';
        }

        $Conexion->close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_GET['usrdelete']))
{
    $Conexion = conexionBD();

    if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = "";
        $msg = '';

        $Conexion->autocommit(false);

        try{

            $idRow = explode('-',$_GET['row']);
            $sentencia = "UPDATE musuarios SET cFlagEliminado = 1 WHERE nCodigo = $idRow[2];";

            if(!$Conexion->query($sentencia))
                throw new Exception('Error al intentar eliminar el usuario seleccionado');

            $Respuesta = 200;
            $msg = 'El usuario seleccionado se ha eliminado correctamente';

            $Conexion->commit();

        }catch (Exception $e){

            $Conexion->rollback();
            $Respuesta = 500;
            $msg = 'Error: '.$e->getMessage()."\n";
        }

        $Conexion->close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['usreditar']))
{
    $Conexion = conexionBD();

    if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = "";
        $msg = '';

        $Conexion->autocommit(false);

        try{

            $sentencia = "UPDATE musuarios SET ofiId = '".$_POST['nusrOficina']."', cNombres = '".$_POST['nusrNombres']."',
                    cPaterno = '".$_POST['nusrPaterno']."', cMaterno = '".$_POST['nusrMaterno']."', cDni = '".$_POST['nusrDni']."'
                    WHERE nCodigo = '".$_POST['nusrId']."'";

            if(!$Conexion->query($sentencia))
                throw new Exception('No se pudo actualizar los datos del usuario');

            $Respuesta = 200;
            $msg = 'Los datos del usuario fueron actualizados correctamente';

            $Conexion->commit();

        }catch (Exception $e){

            $Conexion->rollback();
            $Respuesta = 500;
            $msg = 'Error: '.$e->getMessage()."\n";

        }
        $Conexion->close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

?>