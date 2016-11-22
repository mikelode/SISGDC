<?php
session_start();

use Carbon\Carbon;

include("../_conexion.php");
require '../../vendor/autoload.php';

if (isset($_POST['initSubModulo1']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "SELECT a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagA, a.hisFlagD, a.hisFlagR, a.hisIdSourceD, a.arcId,
						b.arcAnio, b.arcEstado, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName, FN_GETDERIVMSGOF(a.hisIdSourceD) as hisMsg
						FROM gdchistorial a
						INNER JOIN gdcarchivador b on b.arcId = a.arcId
						INNER JOIN gdcdocumento c on c.docId = b.docId
						INNER JOIN gdcremitente d on d.remId = c.remId
						WHERE a.hisOfiDestino = '" . $_SESSION['oficina'] . "' AND b.arcEstado = 'Procesando' AND a.hisFlagD = 0 AND a.hisFlagA = 0 AND b.arcFlagEliminado = 0;";

		$ListaDocPorProcesar = $Conexion->query($Sentencia);
        while ($Fila = $ListaDocPorProcesar->fetch_row())
            $Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$Fila[8]."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."$";
		$Respuesta .= "%";

		$Sentencia = "select ofiId, ofiDesc from `".BASEDATOS."`.munioficina where ofiActivo = 1";
		$ListaOficinas = $Conexion -> query($Sentencia);
        while ($Fila = $ListaOficinas -> fetch_row())
            $Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Sentencia = "select * from `".BASEDATOS."`.gdcTipoDocumento";
		$ListaCategorias = $Conexion -> query($Sentencia);
		while ($Fila = $ListaCategorias -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Conexion->close();
	}

	echo $Respuesta;
}

if (isset($_POST['initSubModulo2']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
        $Respuesta = ERRORCONEXION;
    else
    {
        $Respuesta = "";
        $columns = $_POST['columns'];

        $colSort = $_POST['order'][0]['column'];
        $colSort = $columns[$colSort]['data'];

        $dirSort = $_POST['order'][0]['dir'];

        $iniLimit = $_POST['start'];
        $endLimit = $iniLimit + $_POST['length'];

        $Sentencia = "SELECT a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, FN_GETDESCESTADO(a.hisId) as hisAccion, a.hisIdSourceD, a.arcId,
                        b.arcAnio, b.arcEstado, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                        FN_GETDESCOFTARGET(e.derDestinatarios) as hisDestinos, date_format(FN_GETFECHAESTADO(a.hisId),'%d/%m/%y %H:%i') as hisFechaAccion,
                        FN_GETMSGESTADO(a.hisId) as hisDescAccion, FN_GETDESCTIPODOC(c.tipId) as docTipo
						FROM gdchistorial a
						INNER JOIN gdcarchivador b on b.arcId = a.arcId
						INNER JOIN gdcdocumento c on c.docId = b.docId
						INNER JOIN gdcremitente d on d.remId = c.remId
						LEFT JOIN gdcderivacion e on a.hisId = e.hisId
						WHERE a.hisOfiDestino = '" . $_SESSION['oficina'] . "' AND (b.arcEstado = 'Terminado' OR a.hisFlagD = 1 OR a.hisFlagA = 1) AND a.hisIdSourceD IS NOT NULL AND b.arcFlagEliminado = 0
						ORDER BY $colSort $dirSort LIMIT $iniLimit, $endLimit;";

        $ListaDocProcesados = $Conexion->query($Sentencia);
        $recordsTotal = $ListaDocProcesados->num_rows;
        $data = array();

        if(!empty($_POST['search']['value']))
        {
            $searchVal = $_POST['search']['value'];
            foreach ($columns as $i => $col)
            {
                $field = $col['data'];

                switch ($field) {
                    case 'docTipo':
                        $colName = "FN_GETDESCTIPODOC(c.tipId)";
                        break;
                    case 'arcCodExp':
                        $colName = "replace(b.arcExp,'PK',b.arcId)";
                        break;
                    case 'remOfi':
                        $colName = "FN_GETDESCOFI(a.hisOfiOrigen)";
                        break;
                    case 'remFullName':
                        $colName = "FN_FULLNAMEREM(d.remId,d.remTipo)";
                        break;
                    case 'hisAccion':
                        $colName = "FN_GETDESCESTADO(a.hisId)";
                        break;
                    case 'hisFechaAccion':
                        $colName = "date_format(FN_GETFECHAESTADO(a.hisId),'%d/%m/%y %H:%i')";
                        break;
                    case 'hisDescAccion':
                        $colName = "FN_GETMSGESTADO(a.hisId)";
                        break;
                    case 'hisDestinos':
                        $colName = "FN_GETDESCOFTARGET(e.derDestinatarios)";
                        break;
                }

                $where[] = "$colName like '%$searchVal%'";
            }
            $andWhere = implode(" OR ", $where);

            $SentenciaFilter = "SELECT a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, FN_GETDESCESTADO(a.hisId) as hisAccion, a.hisIdSourceD, a.arcId,
                        b.arcAnio, b.arcEstado, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                        FN_GETDESCOFTARGET(e.derDestinatarios) as hisDestinos, date_format(FN_GETFECHAESTADO(a.hisId),'%d/%m/%y %H:%i') as hisFechaAccion,
                        FN_GETMSGESTADO(a.hisId) as hisDescAccion, FN_GETDESCTIPODOC(c.tipId) as docTipo
						FROM gdchistorial a
						INNER JOIN gdcarchivador b on b.arcId = a.arcId
						INNER JOIN gdcdocumento c on c.docId = b.docId
						INNER JOIN gdcremitente d on d.remId = c.remId
						LEFT JOIN gdcderivacion e on a.hisId = e.hisId
						WHERE a.hisOfiDestino = '" . $_SESSION['oficina'] . "' AND (b.arcEstado = 'Terminado' OR a.hisFlagD = 1 OR a.hisFlagA = 1) AND a.hisIdSourceD IS NOT NULL AND b.arcFlagEliminado = 0
						AND ($andWhere)
						ORDER BY $colSort $dirSort LIMIT $iniLimit, $endLimit;";

            $ListaFiltrados = $Conexion->query($SentenciaFilter);

            $recordsFilter = $ListaFiltrados->num_rows;

            while ($Fila = $ListaFiltrados -> fetch_assoc())
                $data[] = $Fila;
        }
        else
        {
            $recordsFilter = $recordsTotal;

            while ($Fila = $ListaDocProcesados -> fetch_assoc())
                $data[] = $Fila;
        }

        $Respuesta = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFilter,
            'data' => $data
        );

        $Conexion -> close();
    }
    echo json_encode($Respuesta);
}

//Inicializa controles para "Editar Software"
/*if (isset($_POST['initSubModulo2']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "SELECT a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagA, a.hisFlagD, a.hisFlagR, a.hisIdSourceD, a.arcId,
						b.arcAnio, b.arcEstado, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
						FN_GETDESCOFTARGET(e.derDestinatarios) as destinos, date_format(a.hisDateTimeA,'%d/%m/%y %h:%i %p'), date_format(a.hisDateTimeD,'%d/%m/%y %h:%i %p'), a.hisDescA, a.hisDescD, FN_GETDESCTIPODOC(c.tipId) as docTipo
						FROM gdchistorial a
						INNER JOIN gdcarchivador b on b.arcId = a.arcId
						INNER JOIN gdcdocumento c on c.docId = b.docId
						INNER JOIN gdcremitente d on d.remId = c.remId
						LEFT JOIN gdcderivacion e on a.hisId = e.hisId
						WHERE a.hisOfiDestino = '" . $_SESSION['oficina'] . "' AND (b.arcEstado = 'Terminado' OR a.hisFlagD = 1 OR a.hisFlagA = 1) AND a.hisIdSourceD IS NOT NULL AND b.arcFlagEliminado = 0;";

		$ListaDocProcesados = $Conexion->query($Sentencia);
		while ($Fila = $ListaDocProcesados->fetch_row())
        {
            //$Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$Fila[8]."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."|".$Fila[13]."|".$Fila[14]."|".$Fila[15]."|".$Fila[16]."|".$Fila[17]."$";
            $Respuesta .= implode('|',$Fila)."$";
        }
		$Respuesta .= "%";

		$Conexion -> close();
	}
	echo $Respuesta;
}*/

if(isset($_POST['recibir']))
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

            $fechahora = Carbon::now()->toDateTimeString();

            $Sentencia = "UPDATE gdchistorial SET hisFlagR = '1', hisDateTimeR = '$fechahora', hisDescR = '".$_POST['ndocMensajeRecibir']."' WHERE hisId = '".$_POST['ndocHisIdR']."'";

            if(!$Conexion->query($Sentencia))
                throw new Exception('Error al registrar la recepción.');

            $msg = ACEPTAROK;
            $Respuesta = 200;

            $Conexion->commit();

        }catch (Exception $e){
            $Conexion->rollback();
            $msg = 'Error: '.$e->getMessage()."\n";
            $Respuesta = 500;
        }

		$Conexion->close();
	}

	echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['atender']))
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

            $fechahora = Carbon::now()->toDateTimeString();

            $Sentencia = "UPDATE gdchistorial SET hisFlagA = '1', hisDateTimeA = '$fechahora', hisDescA = '".$_POST['ndocMensajeAtender']."' WHERE hisId = '".$_POST['ndocHisIdA']."'";

            if(!$Conexion->query($Sentencia))
                throw new Exception('No se pudo registrar la ATENCION del documento');

            $Sentencia = "SELECT arcId FROM gdchistorial WHERE hisId = '".$_POST['ndocHisIdA']."'";
            $resultado = $Conexion->query($Sentencia);

            if(!$resultado)
                throw new Exception('No se pudo obtener el archivo a editar');

            $fila = $resultado->fetch_row();
            $idArc = $fila[0];

            $Sentencia = "UPDATE gdcarchivador SET arcEstado = 'Terminado' WHERE arcId = '$idArc'";

            if(!$Conexion->query($Sentencia))
                throw new Exception('Advertencia, el registro en el archivador no ha sido actualizado correctamente');

            $msg .= ATENDEROK;
            $Respuesta .= 200;

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

if(isset($_POST['derivarSimple']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
	{
		$Respuesta = 500;
		$msg = ERRORCONEXION;
	}
	else
	{
		$Respuesta = '';
		$msg = '';

        $Conexion->autocommit(false);

        try{

            $fechahora = Carbon::now()->toDateTimeString();
            $idExp = explode('-',$_POST['ndocDerivar']);

            $Sentencia = "UPDATE gdchistorial SET hisFlagD = 1, hisDateTimeD = '$fechahora', hisDescD = '".$_POST['ndocMensajeDerivar']."' where hisId = '".$_POST['ndocHisIdD']."'";

            if(!$Conexion->query($Sentencia))
                throw new Exception('No se ha podido actualizar el registro de derivación del documento elegido');

            if(!isset($_POST['ndocEnvioDestino']))
                throw new Exception("Debe elegir almenos una oficina como destino");

            if(count($_POST['ndocEnvioDestino']) > 0)
            {
                $Sentencia = "INSERT INTO gdchistorial (hisOfiOrigen, hisOfiDestino, hisFlagR, hisFlagA, hisflagD, hisIdSourceD, arcId, hisRegisterBy, hisRegisterAt) VALUES ";
                $destinatarios = '';

                foreach($_POST['ndocEnvioDestino'] as $ofi)
                {
                    // el ID de la oficina origen esta guardad en la variable SESSION['oficina'] que la oficina a la que pertenece el usuario
                    if($_SESSION['oficina'] == $ofi) continue;
                    $Sentencia .= "('".$_SESSION['oficina']."','".$ofi."',0,0,0,'".$_POST['ndocHisIdD']."','$idExp[1]','".$_SESSION['codigo']."','$fechahora'),";
                    $destinatarios .= $ofi.'<';
                }
                $Sentencia = rtrim($Sentencia,',');
                $destinatarios = rtrim($destinatarios,'<');

                if(!$Conexion->query($Sentencia))
                    throw new Exception('Error al registrar la derivación del documento hacia los destinatarios elegidos');

                $Sentencia = "INSERT INTO gdcderivacion (hisId, derTipo, derExp, derDocTipo, derDestinatarios, derDocDetalle, derDocReferencia, derDerivadoBy, derDerivadoAt)
                          VALUES ('".$_POST['ndocHisIdD']."','Simple','$idExp[1]','0','$destinatarios','".$_POST['ndocMensajeDerivar']."','".$_POST['ndocHisIdD'].'-'.$idExp[1]."','".$_SESSION['codigo']."','$fechahora') ";

                if(!$Conexion->query($Sentencia))
                    throw new Exception('No se pudo registrar los datos de la derivación');
            }
            else
            {
                throw new Exception('Error al registrar la derivación, al parecer NO ha seleccionado algun destinario');
            }

            $msg .= DERIVAROK;
            $Respuesta = 200;

            $Conexion->commit();

        }catch (Exception $e){
            $Conexion->rollback();
            $Respuesta = 500;
            $msg = 'Error: '.$e->getMessage().'\n';
        }
		$Conexion->close();
	}

	echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['derivarCompuesta']))
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
            $fechahora = Carbon::now()->toDateTimeString();
            $idExp = explode('-',$_POST['ndocDerivarCD']);

            $Sentencia = "UPDATE gdchistorial SET hisFlagD = 1, hisDateTimeD = '$fechahora', hisDescD = '".$_POST['ndocAsuntoCD']."' where hisId = '".$_POST['ndocHisIdDCD']."'";
            if(!$Conexion->query($Sentencia))
                throw new Exception('No se pudo actualizar el registro de historial del docuento');

            if(!isset($_POST['ndocEnvioDestinoCD']))
                throw new Exception('No se ha seleccionado ninguna oficina como destinatario');

            if(count($_POST['ndocEnvioDestinoCD']) > 0)
            {
                $Sentencia = "INSERT INTO gdchistorial (hisOfiOrigen, hisOfiDestino, hisFlagR, hisFlagA, hisflagD, hisIdSourceD, arcId, hisRegisterBy, hisRegisterAt) VALUES ";
                $destinatarios = '';

                foreach($_POST['ndocEnvioDestinoCD'] as $ofi)
                {
                    // el ID de la oficina origen esta guardad en la variable SESSION['oficina'] que la oficina a la que pertenece el usuario
                    if($_SESSION['oficina'] == $ofi) continue;
                    $Sentencia .= "('".$_SESSION['oficina']."','".$ofi."',0,0,0,'".$_POST['ndocHisIdDCD']."','$idExp[1]','".$_SESSION['codigo']."','$fechahora'),";
                    $destinatarios .= $ofi.'<';
                }
                $Sentencia = rtrim($Sentencia,',');
                $destinatarios = rtrim($destinatarios,'<');

                if(!$Conexion->query($Sentencia))
                    throw new Exception('Error al registrar la derivación del documento hacia los destinatarios elegidos');

                $Sentencia = "INSERT INTO gdcderivacion (hisId, derTipo, derExp, derDocTipo, derDocControlPersonal, derDestinatarios, derDocDetalle, derDocReferencia, derDerivadoBy, derDerivadoAt)
                          VALUES ('".$_POST['ndocHisIdDCD']."','Compuesta','$idExp[1]','".$_POST['ndocTipoDerivarCD']."','".$_POST['ndocCtrlPersonalCD']."','$destinatarios','".$_POST['ndocAsuntoCD']."','".$_POST['ndocHisIdDCD'].'-'.$idExp[1]."','".$_SESSION['codigo']."','$fechahora') ";

                if(!$Conexion->query($Sentencia))
                    throw new Exception('No se pudo registrar ls datos de la derivación');
            }
            else
            {
                throw new Exception('No se ha seleccionado ningun destinario, debe elegir al menos una oficina');
            }

            $msg .= DERIVAROK;
            $Respuesta = 200;

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