<?php
session_start();

use Carbon\Carbon;

include("../_conexion.php");
require '../../vendor/autoload.php';

if (isset($_POST['initSubModulo11']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "select * from `".BASEDATOS."`.gdcTipoDocumento";
		$ListaCategorias = $Conexion -> query($Sentencia);
		while ($Fila = $ListaCategorias -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Conexion->close();
	}

	echo $Respuesta;
}

//Inicializa controles para "Editar Software"
if (isset($_POST['initSubModulo12']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "select a.ofiId, a.ofiCod, a.ofiDesc, a.ofiActivo, b.jefId, b.jefDni, b.jefNombres,
                    b.jefPaterno, b.jefMaterno, b.jefActivo
                    from munioficina a
                    inner join munijefeoficina b on b.jefId = a.jefId
                    where a.ofiActivo = 1;";

		$ListaOficinasJefes = $Conexion->query($Sentencia);
		while ($Fila = $ListaOficinasJefes->fetch_row())
            $Respuesta .= implode('|',$Fila)."$";
		$Respuesta .= "%";

        $Sentencia = "select a.* from munijefeoficina a
                    left outer join munioficina b on b.jefId = a.jefId
                    where b.ofiId is null;";

        $ListaJefes = $Conexion->query($Sentencia);
        while($Fila = $ListaJefes->fetch_row())
            $Respuesta .= implode('|',$Fila)."$";
        $Respuesta .= "%";

		$Conexion -> close();
	}
	echo $Respuesta;
}

if (isset($_POST['initSubModulo13']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
        $Respuesta = ERRORCONEXION;
    else
    {
        $Respuesta = "";
        $Conexion->close();
    }
}

if(isset($_POST['newtdoc']))
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

        $sentencia = "INSERT INTO gdctipodocumento(tipDesc, tipDescAbrv) VALUES ('".$_POST['ntipodocDesc']."','');";

        if($Conexion->query($sentencia))
        {
            $Respuesta = 200;
            $msg = 'Registrado correctamente el nuevo tipo de documento';
        }
        else
        {
            $Respuesta = 500;
            $msg = 'Error al intentar registrar el nuevo tipo de documento';
        }
        $Conexion->close();
    }

    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['newjef']))
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
            $sentencia = "INSERT INTO munijefeoficina(jefDni, jefNombres, jefPaterno, jefMaterno, jefActivo)
                  VALUES ('".$_POST['njefeDni']."','".$_POST['njefeNombres']."','".$_POST['njefePaterno']."','".$_POST['njefeMaterno']."','1')";

            if(!$Conexion->query($sentencia))
                throw new Exception('No se pudo registrar el personal nuevo');

            $Respuesta = 200;
            $msg = 'Nuevo personal registrado correctamente';

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

if(isset($_POST['newofi']))
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

            $sentencia = "INSERT INTO munioficina(ofiDesc, ofiDescC, ofiActivo, jefId)
                    VALUES ('".$_POST['nofiDesc']."','".$_POST['nofiDescCorta']."','1','".$_POST['nofiJefe']."')";

            if(!$Conexion->query($sentencia))
                throw new Exception('Error al intentar registrar la nueva oficina');

            $Respuesta = 200;
            $msg = 'Nueva oficina registrada correctamente';

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

if(isset($_POST['edittdoc']))
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

        $sentencia = "UPDATE gdctipodocumento SET tipDesc = '".$_POST['ntipodocDescE']."' WHERE tipId = '".$_POST['ntipodocId']."'";

        if($Conexion->query($sentencia))
        {
            $Respuesta = 200;
            $msg = 'Actualización correcta del tipo de documento';
        }
        else
        {
            $Respuesta = 500;
            $msg = 'Error al intentar actualizar el tipo de documento seleccionado';
        }
        $Conexion->close();
    }

    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['editofijef']))
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

        $sentencia = "UPDATE munioficina SET jefId = '".$_POST['nofiNuevoJefe']."' WHERE ofiId = '".$_POST['nofiId']."'";

        if($Conexion->query($sentencia))
        {
            $Respuesta = 200;
            $msg = 'Se ha reasignado el jefe del la oficina correctamente';
        }
        else
        {
            $Respuesta = 500;
            $msg = 'Error al intentar reasignar los datos para la oficina seleccionada';
        }
        $Conexion->close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['cargarSeguimiento']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = "";
        $msg = '';
        $exp = explode('-',$_POST['idExp']);

        $Sentencia = "SELECT b.hisId, b.hisIdSourceD, d.derDestinatarios, d.derTipo, a.arcOrigen, a.arcId, c.docId, e.arpOficina, FN_GETDESCTIPODOC(c.tipId) docTipo,
                    FN_GETDESCOFI(b.hisOfiOrigen) ofiOrigen, FN_GETDESCOFI(b.hisOfiDestino) ofiDestino, a.arcEstado, c.docFecha, a.arcFechaRecepcion, a.arcEstado,
                    b.hisFlagR, b.hisFlagA, b.hisFlagD, b.hisDateTimeR, b.hisDateTimeA, b.hisDateTimeD, b.hisDescR, b.hisDescA, b.hisDescD, replace(a.arcExp,'PK',a.arcId) AS codExp,
                    FN_GETFECENVIO(b.hisIdSourceD) fecEnvio
                    FROM gdcarchivador a
                    LEFT JOIN gdchistorial b ON b.arcId = a.arcId
                    INNER JOIN gdcdocumento c ON c.docId = a.docId
                    LEFT JOIN gdcderivacion d ON d.hisId = b.hisId
                    INNER JOIN gdcarchivadorparticular e ON e.arcId = a.arcId
                    WHERE a.arcId = '".$exp[1]."';";

        $ListaSeguimiento = $Conexion->query($Sentencia);

        if($ListaSeguimiento)
        {
            /*while($Fila = $ListaSeguimiento -> fetch_row())
                $Respuesta .= implode('|',$Fila) . '$';
            $Respuesta .= '%';*/
            ob_start();
            include '../../.html/modulo2-admin/m2submod3_seguimiento.php';
            $Respuesta = ob_get_clean();
            $msg = 'Recuperado correctamente';
            $response = 200;
        }
        else
        {
            $Respuesta = '';
            $msg = 'Error al recuperar los datos de seguimiento del documento';
            $response = 500;
        }

        $Conexion -> close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg, 'response' => $response));
}

if(isset($_POST['editdateoperacion']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
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

            if($_POST['name'] == 'rece')
            {
                $sentencia = "UPDATE gdchistorial SET hisDateTimeR = '".$_POST['value']."' WHERE hisId = '".$_POST['pk']."'";
            }
            else if($_POST['name'] == 'aten')
            {
                $sentencia = "UPDATE gdchistorial SET hisDateTimeA = '".$_POST['value']."' WHERE hisId = '".$_POST['pk']."'";
            }
            else if($_POST['name'] == 'deri')
            {
                $sentencia = "UPDATE gdchistorial SET hisDateTimeD = '".$_POST['value']."' WHERE hisId = '".$_POST['pk']."'";
            }

            if(!$Conexion->query($sentencia))
                throw new Exception('No se pudo actualizar la fecha');

            $Respuesta = 200;
            $msg = 'La fecha ha sido actualizada correctamente';

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