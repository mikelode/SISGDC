<?php

session_start();

use Carbon\Carbon;

include("../_conexion.php");
require '../../vendor/autoload.php';

//Inicializa controles para "Agregar Equipo"
if (isset($_POST['initSubModulo1']))
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

		$Sentencia = "select a.ofiDesc, b.jefId, b.jefDni, b.jefNombres, b.jefPaterno, b.jefMaterno, b.jefActivo
						from `".BASEDATOS."`.munioficina a
						inner join `".BASEDATOS."`.munijefeoficina b on b.jefId = a.jefId
						where a.ofiId = ".$_SESSION['oficina'];
		$ListaJefe = $Conexion -> query($Sentencia);
		while ($Fila = $ListaJefe -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."$";
		$Respuesta .= "%";

		$Sentencia = "select ofiId, ofiDesc from `".BASEDATOS."`.munioficina where ofiActivo = 1";
		$ListaOficinas = $Conexion -> query($Sentencia);
		while ($Fila = $ListaOficinas -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Sentencia = "select a.arcExp, c.remDoc, c.remNombres, c.remPaterno, c.remMaterno, b.docAsunto, d.tipId, b.docFolio,
                        b.docFecha, a.arcId, a.arcEstado, a.arcControlPersonal, b.docReferencia, b.docNumero
						from `".BASEDATOS."`.gdcarchivador a
						inner join `".BASEDATOS."`.gdcarchivadorparticular ap on ap.arcId = a.arcId
						inner join `".BASEDATOS."`.gdcdocumento b on a.docId = b.docId
						inner join `".BASEDATOS."`.gdcremitente c on b.remId = c.remId
						inner join `".BASEDATOS."`.gdctipodocumento d on d.tipId = b.tipId
						where a.arcOrigen = 'interno' AND ap.ofiId = '".$_SESSION['oficina']."' AND a.arcFlagEliminado = 0
						order by b.docId desc limit 1";

		$UltimoDocumento = $Conexion -> query($Sentencia);
		while ($Fila = $UltimoDocumento -> fetch_row())
		{
			$docFecha = Carbon::createFromFormat('Y-m-d H:i:s',$Fila[8])->toDateString();
			$Respuesta .= str_replace('PK',$Fila[9],$Fila[0])."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$docFecha."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."|".$Fila[13]."$";
		}
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
if (isset($_POST['initSubModulo2']))
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

		$Sentencia = "select ofiId, ofiDesc from `".BASEDATOS."`.munioficina where ofiActivo = 1";
		$ListaOficinas = $Conexion -> query($Sentencia);
		while ($Fila = $ListaOficinas -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Sentencia = "select a.arcExp, c.remDoc, c.remNombres, c.remPaterno, c.remMaterno, b.docAsunto, d.tipId, b.docFolio,
                        b.docFecha, a.arcId, c.remTipo, c.remDesc, a.arcEstado, a.arcControlPersonal, a.arcPrioridad,
                        a.arcFechaRecepcion, b.docReferencia, b.docNumero
						from `".BASEDATOS."`.gdcarchivador a
						inner join `".BASEDATOS."`.gdcarchivadorparticular ap on ap.arcId = a.arcId
						inner join `".BASEDATOS."`.gdcdocumento b on a.docId = b.docId
						inner join `".BASEDATOS."`.gdcremitente c on b.remId = c.remId
						inner join `".BASEDATOS."`.gdctipodocumento d on d.tipId = b.tipId
						where a.arcOrigen = 'externo' AND ap.ofiId = '".$_SESSION['oficina']."' AND a.arcFlagEliminado = 0
						order by b.docId desc limit 1";

		$UltimoDocumento = $Conexion -> query($Sentencia);
		while ($Fila = $UltimoDocumento -> fetch_row())
		{
			$docFecha = Carbon::createFromFormat('Y-m-d H:i:s',$Fila[8])->toDateString();
			$docFechaRecepcion = Carbon::createFromFormat('Y-m-d H:i:s',$Fila[15])->format('Y-m-d H:i:s');
			$Respuesta .= str_replace('PK',$Fila[9],$Fila[0])."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$docFecha."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."|".$Fila[13]."|".$Fila[14]."|".$docFechaRecepcion."|".$Fila[16]."|".$Fila[17]."$";
		}
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

if (isset($_POST['initSubModulo3']))
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

		$Sentencia = "select * from `".BASEDATOS."`.mCategorias";
		$ListaCategorias = $Conexion -> query($Sentencia);
		while ($Fila = $ListaCategorias -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."$";
		$Respuesta .= "%";

		$Conexion -> close();
	}
	echo $Respuesta;
}

if(isset($_POST['save']))
{
	$Conexion = conexionBD();

	if(!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
        $Respuesta = "";
        $msg = '';

		if(!isset($_POST['origen'])) return;

        $Conexion->autocommit(false);

        try{

			if($_POST['origen'] == 'interno')
			{
				$sentencia = "INSERT INTO gdcremitente(remDoc, remNombres, remPaterno, remMaterno, remTipo)
						VALUES('" . $_POST['ndocRemId'] . "','" . $_POST['ndocRemNombres'] . "','" . $_POST['ndocRemPaterno'] . "','" . $_POST['ndocRemMaterno'] . "','Persona')";
			}
			else if($_POST['origen'] == 'externo')
			{
				if ($_POST['ndocTipoRem'] == 'prs')
				{
					$sentencia = "INSERT INTO gdcremitente(remDoc, remNombres, remPaterno, remMaterno, remTipo)
						VALUES('" . $_POST['ndocRemId'] . "','" . $_POST['ndocRemNombres'] . "','" . $_POST['ndocRemPaterno'] . "','" . $_POST['ndocRemMaterno'] . "','Persona')";
				}
				else
				{
					$sentencia = "INSERT INTO gdcremitente(remDoc, remDesc, remTipo)
						VALUES('" . $_POST['ndocRemOtroId'] . "','" . $_POST['ndocRemOtroDesc'] . "','Institucion')";
				}
			}

			if(!$Conexion->query($sentencia))
                throw new Exception('Error al registrar el remitente');

			$ult_remitente = $Conexion->insert_id;
            $docFolio = $_POST['ndocFolios']==''?'NULL':$_POST['ndocFolios'];

			$sentencia = "INSERT INTO gdcdocumento(docAsunto, docFolio, docFecha, docRegisterBy, docRegisterAt, tipId, remId, docReferencia, docNumero)
					VALUES('" . $_POST['ndocAsunto'] . "',$docFolio,'" . $_POST['ndocFecha'] . "','" . $_SESSION['codigo'] . "','" . date('y/m/d H:i:s') . "','" . $_POST['ndocTipo'] . "','" . $ult_remitente . "','".$_POST['ndocReferencia']."','".$_POST['ndocNumero']."')";

			if(!$Conexion->query($sentencia))
                throw new Exception('No se ha podido registrar el documento');

			$ult_documento = $Conexion->insert_id;

			// CODIGO DEL DOCUMENTO A REGISTRARSE CUI: EXyyMM000001 - EX1601000001P EXP16-1-10

			$anio = date('y');
			$mes = date('m');

			$sufijo_exp = 'EXP' . $anio . '-PK-' . $mes;

			if($_POST['origen'] == 'interno')
			{
				$sentencia = "INSERT INTO gdcarchivador(arcExp, arcEstado, arcOrigen, arcRegisterBy, arcRegisterAt, docId, arcAnio, arcControlPersonal)
					VALUES('" . $sufijo_exp . "','Registrado','" . $_POST['origen'] . "','" . $_SESSION['codigo'] . "','" . date('y/m/d H:i:s') . "','" . $ult_documento . "','".Carbon::now()->year."','".$_POST['ndocCtrlPersonal']."')";
			}
			else if($_POST['origen'] == 'externo')
			{
				$sentencia = "INSERT INTO gdcarchivador(arcExp, arcEstado, arcOrigen, arcRegisterBy, arcRegisterAt, docId, arcAnio, arcControlPersonal, arcPrioridad, arcFechaRecepcion)
					VALUES('" . $sufijo_exp . "','Registrado','" . $_POST['origen'] . "','" . $_SESSION['codigo'] . "','" . date('y/m/d H:i:s') . "','" . $ult_documento . "','".Carbon::now()->year."','".$_POST['ndocCtrlPersonal']."','".$_POST['ndocPrioridad']."','".$_POST['ndocFechaRecepcion']."')";
			}

            if(!$Conexion->query($sentencia))
                throw new Exception('Error al registrar el archivador');

			$ult_expid = $Conexion->insert_id;

			$sentencia = "INSERT INTO gdchistorial (hisOfiOrigen, hisOfiDestino, hisFlagR, hisFlagA, hisflagD, hisDateTimeR, hisDescR, arcId, hisRegisterBy, hisRegisterAt)
						VALUES('".$_SESSION['oficina']."','".$_SESSION['oficina']."',1,0,0,'".Carbon::now()->toDateTimeString()."','origen','$ult_expid','".$_SESSION['codigo']."','".Carbon::now()->toDateTimeString()."')";

            if(!$Conexion->query($sentencia))
                throw new Exception('Error al registrar historial de creación');

			$sufijo_part = 'OFI-' . $_SESSION['oficina'] . '-' . $anio . '-PK-' . $mes;
			$sentencia = "INSERT INTO gdcarchivadorparticular (arpExp, arpOficina, arcId, ofiId) VALUES('$sufijo_part',FN_GETDESCOFI('".$_SESSION['oficina']."'),'$ult_expid','".$_SESSION['oficina']."')";

            if(!$Conexion->query($sentencia))
                throw new Exception('Error al registrar archivador particular');

            $Respuesta = 200;
            $msg = NUEVODOCOK;

			$Conexion->commit();

		}catch (Exception $e){

            $Conexion->rollback();
            $Respuesta = 500;
            $msg = 'Error: '.$e->getMessage()."\n";
		}

        $Conexion -> close();
	}

    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['edit']))
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
            $cadena = '';
            $idExp = explode('-',$_POST['ndocId']);
            $sentencia = "select docId from gdcarchivador where arcId = '".$idExp[1]."'";
            $idDoc = $Conexion->query($sentencia);

            if(!$idDoc)
                throw new Exception('No se pudo encontrar el documento');

            while ($Fila = $idDoc -> fetch_row())
                $doc = $Fila[0];

            $docFolio = $_POST['ndocFolios']==''?'NULL':$_POST['ndocFolios'];

            if($_POST['origen'] == 'interno')
            {
                $sentencia = "update gdcdocumento set docAsunto = '".$_POST['ndocAsunto']."', docFolio = $docFolio,
                        docFecha = '".$_POST['ndocFecha']."', tipId = '".$_POST['ndocTipo']."', docReferencia = '".$_POST['ndocReferencia']."',
                        docNumero = '".$_POST['ndocNumero']."'
                        where docId = '".$doc."'";
                $sentencia2 = "UPDATE gdcarchivador SET arcControlPersonal = '".$_POST['ndocCtrlPersonal']."' WHERE arcId = '".$idExp[1]."' ";
            }
            else if($_POST['origen'] == 'externo')
            {
                $sentencia = "select remId from gdcdocumento where docId = '$doc'";
                $idRem = $Conexion->query($sentencia);

                if(!$idRem)
                    throw new Exception('No se pudo encontrar el remitente del documento');

                $Fila = $idRem->fetch_row();
                $rem = $Fila[0];

                if($_POST['ndocTipoRem'] == 'prs')
                {
                    $sentencia = "update gdcremitente set remDoc = '".$_POST['ndocRemId']."', remNombres = '".$_POST['ndocRemNombres']."', remPaterno = '".$_POST['ndocRemPaterno']."', remMaterno = '".$_POST['ndocRemMaterno']."', remTipo = 'Persona' where remId = $rem";
                }
                else
                {
                    $sentencia = "update gdcremitente set remDoc = '".$_POST['ndocRemOtroId']."', remDesc = '".$_POST['ndocRemOtroDesc']."', remTipo = 'Institucion' where remId = $rem";
                }

                $updateRemitente = $Conexion->query($sentencia);

                if(!$updateRemitente)
                    throw new Exception('No se pudo actualizar los datos del remitente');

                $sentencia = "UPDATE gdcdocumento SET docAsunto = '".$_POST['ndocAsunto']."', docFolio = $docFolio,
                    docFecha = '".$_POST['ndocFecha']."', tipId = '".$_POST['ndocTipo']."', docReferencia = '".$_POST['ndocReferencia']."',
                    docNumero = '".$_POST['ndocNumero']."'
                    WHERE docId = '".$doc."'";
                $sentencia2 = "UPDATE gdcarchivador SET arcControlPersonal = '".$_POST['ndocCtrlPersonal']."', arcPrioridad = '".$_POST['ndocPrioridad']."',
                    arcFechaRecepcion = '".$_POST['ndocFechaRecepcion']."'
                    WHERE arcId = '".$idExp[1]."'";

            }

            if($Conexion->query($sentencia) && $Conexion->query($sentencia2))
            {
                /*$sentencia = "select a.arcExp, c.remDoc, c.remNombres, c.remPaterno, c.remMaterno, b.docAsunto, d.tipId, b.docFolio, b.docFecha, a.arcId, c.remTipo, c.remDesc
						from `".BASEDATOS."`.gdcarchivador a
						inner join `".BASEDATOS."`.gdcdocumento b on a.docId = b.docId
						inner join `".BASEDATOS."`.gdcremitente c on b.remId = c.remId
						inner join `".BASEDATOS."`.gdctipodocumento d on d.tipId = b.tipId
						where a.arcId = $idExp[1]
						order by b.docId desc";*/

                $sentencia = "select replace(a.arcExp,'PK',a.arcId) as expId, c.remDoc, c.remNombres, c.remPaterno,
                    c.remMaterno, b.docAsunto, d.tipId, b.docFolio, date_format(b.docFecha,'%Y-%m-%d') as docFecha,
                    a.arcId, c.remTipo, c.remDesc, a.arcEstado, a.arcControlPersonal, a.arcPrioridad, a.arcFechaRecepcion,
                    b.docReferencia, b.docNumero
                    from `".BASEDATOS."`.gdcarchivador a
                    inner join `".BASEDATOS."`.gdcarchivadorparticular ap on ap.arcId = a.arcId
                    inner join `".BASEDATOS."`.gdcdocumento b on a.docId = b.docId
                    inner join `".BASEDATOS."`.gdcremitente c on b.remId = c.remId
                    inner join `".BASEDATOS."`.gdctipodocumento d on d.tipId = b.tipId
                    where a.arcId = $idExp[1]
                    order by b.docId desc";

                $docElegido = $Conexion -> query($sentencia);
                while ($Fila = $docElegido -> fetch_row())
                {
                    //$docFecha = Carbon::createFromFormat('Y-m-d H:i:s',$Fila[8])->toDateString();
                    //$cadena .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$Fila[8]."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."$";
                    $cadena .= implode('|',$Fila) . '$';
                }
                $cadena .= "%";
            }
            else
            {
                throw new Exception('Hubo un error al modificar los datos del documento seleccionado');
            }

            $Respuesta = 200;
            $msg = 'Datos modificados correctamente';

            $Conexion->commit();

        }catch(Exception $e){

            $Conexion->rollback();
            $Respuesta = 500;
            $msg = 'Error: '.$e->getMessage()."\n";
        }

		$Conexion->close();
	}

	echo json_encode(array('Respuesta' => $Respuesta, 'cadena' => $cadena, 'msg' => $msg));
}

if(isset($_POST['posicion']))
{
	$Conexion = conexionBD();
	$respuesta = '';

	if(!$Conexion)
		$respuesta = ERRORCONEXION;
	else
	{
		$sentencia_min = "select min(a.arcId) from gdcarchivador a inner join gdcarchivadorparticular b on b.arcId = a.arcId ";
		$sentencia_max = "select max(a.arcId) from gdcarchivador  a inner join gdcarchivadorparticular b on b.arcId = a.arcId ";

		if($_POST['origen'] == 'interno')
		{
			$sentencia_min .= "where a.arcOrigen = 'interno' AND b.ofiId = '".$_SESSION['oficina']."'";
			$sentencia_max .= "where a.arcOrigen = 'interno' AND b.ofiId = '".$_SESSION['oficina']."'";
		}
		else if($_POST['origen'] == 'externo')
		{
			$sentencia_min .= "where a.arcOrigen = 'externo' AND b.ofiId = '".$_SESSION['oficina']."'";
			$sentencia_max .= "where a.arcOrigen = 'externo' AND b.ofiId = '".$_SESSION['oficina']."'";
		}

		$resultado = $Conexion->query($sentencia_min);
		$Fila = $resultado->fetch_row();
		$min = $Fila[0];

		$resultado = $Conexion->query($sentencia_max);
		$Fila = $resultado->fetch_row();
		$max = $Fila[0];

		$docId = explode('-',$_POST['docId']);
		$docId = $docId[1];
		$newDocId = 0;

		if($_POST['posicion'] == 'anterior')
		{
			$beforeDocId = (int) $docId - 1;

			if($beforeDocId < $min)
				$beforeDocId = $min;

			do{
				$sentencia = "select a.arcId from gdcarchivador a
							inner join gdcarchivadorparticular b on a.arcId = b.arcId
							where a.arcId = '$beforeDocId' and b.ofiId = '".$_SESSION['oficina']."' ";

				if($_POST['origen'] == 'interno')
					$sentencia .= "and arcOrigen = 'interno'";
				else
					$sentencia .= "and arcOrigen = 'externo'";

				$resultado = $Conexion->query($sentencia);
				$beforeDocId--;
			}while($resultado->num_rows == 0);
		}
		else if($_POST['posicion'] == 'posterior')
		{
			$nextDocId = (int) $docId + 1;

			if($nextDocId > $max)
				$nextDocId = $max;

			do{
				$sentencia = "select a.arcId from gdcarchivador a
							inner join gdcarchivadorparticular b on a.arcId = b.arcId
							where a.arcId = '$nextDocId' and b.ofiId = '".$_SESSION['oficina']."' ";

				if($_POST['origen'] == 'interno')
					$sentencia .= "and arcOrigen = 'interno'";
				else
					$sentencia .= "and arcOrigen = 'externo'";

				$resultado = $Conexion->query($sentencia);
				$nextDocId++;
			}while($resultado->num_rows == 0);
		}
        else
        {
            $docId = explode('-',$_POST['posicion']);
            $docId = $docId[1];
            $sentencia = "select a.arcId from gdcarchivador a
							inner join gdcarchivadorparticular b on a.arcId = b.arcId
							where a.arcId = '$docId' and b.ofiId = '".$_SESSION['oficina']."' ";

            if($_POST['origen'] == 'interno')
                $sentencia .= "and arcOrigen = 'interno'";
            else
                $sentencia .= "and arcOrigen = 'externo'";

            $resultado = $Conexion->query($sentencia);
        }

		while($Fila = $resultado->fetch_row())
			$newDocId = $Fila[0];

		$Sentencia = "select a.arcExp, c.remDoc, c.remNombres, c.remPaterno, c.remMaterno, b.docAsunto, d.tipId, b.docFolio,
                        b.docFecha, a.arcId, c.remTipo, c.remDesc, a.arcEstado, a.arcControlPersonal, a.arcPrioridad,
                        a.arcFechaRecepcion, b.docReferencia, b.docNumero
						from `".BASEDATOS."`.gdcarchivador a
						inner join `".BASEDATOS."`.gdcarchivadorparticular ap on ap.arcId = a.arcId
						inner join `".BASEDATOS."`.gdcdocumento b on a.docId = b.docId
						inner join `".BASEDATOS."`.gdcremitente c on b.remId = c.remId
						inner join `".BASEDATOS."`.gdctipodocumento d on d.tipId = b.tipId
						where a.arcId = '$newDocId' AND ap.ofiId = '".$_SESSION['oficina']."' AND a.arcFlagEliminado = 0
						order by b.docId desc";
		$docElegido = $Conexion -> query($Sentencia);
		while ($Fila = $docElegido -> fetch_row())
		{
			$docFecha = Carbon::createFromFormat('Y-m-d H:i:s',$Fila[8])->toDateString();

			if($Fila[15] != '')
				$docFechaRecepcion = Carbon::createFromFormat('Y-m-d H:i:s',$Fila[15])->format('Y-m-d H:i:s');
			else
				$docFechaRecepcion = '';

			$respuesta .= str_replace('PK',$Fila[9],$Fila[0])."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$docFecha."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."|".$Fila[13]."|".$Fila[14]."|".$docFechaRecepcion."|".$Fila[16]."|".$Fila[17]."$";
		}
		$respuesta .= "%";

		$Sentencia = "select a.nCodigo, a.cUsuario, b.ofiId, b.ofiCod, b.ofiDesc from musuarios a
						inner join munioficina b on b.ofiId = a.ofiId
						where nCodigo = '" . $_SESSION['codigo'] . "'";
		$OficinaUsuario = $Conexion->query($Sentencia);
		while($Fila = $OficinaUsuario->fetch_row())
			$respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."$";
		$respuesta .= "%";

		$Conexion -> close();
	}

	echo $respuesta;
}

// PROCEDIMIENTO SE EJECUTA AL ENVIAR EL DOCUMENTO QUE RECIEN HA SIDO REGISTRADO POR EL USUARIO, ES LA PRIMERA DERIVACION EN REALIZARSE
// POR ELLO SE OBTIENE EL ID HISTORIAL RELACIONADO A SU CREACION PARA SER USADO COMO ID DEL NODO PADRE DE LAS OFICINAS DESTINATARIAS
// ADEMAS SE ACTUALIZA EL CAMPO ESTADO DEL ARCHIVADOR PASANDO DE REGISTRADO A PROCESANDO
if(isset($_POST['send']))
{
	$Conexion = conexionBD();
	$respuesta = '';

	if(!$Conexion)
    {
        $respuesta = 500;
        $msg = ERRORCONEXION;
    }
	else
	{
        $Respuesta = '';
        $msg = '';

        $Conexion->autocommit(false);

        try{
            //Debo obtener el pk del historial origen de creación para seguir el rastro
            $sentencia = "SELECT hisId FROM gdchistorial WHERE hisOfiDestino = '".$_POST['ndocEnvioOrigen']."' and arcId = '".$_POST['ndocEnvioExp']."'";

            $resultado = $Conexion->query($sentencia);
            if(!$resultado)
                throw new Exception('No se pudo obtener el registro a actualizar');

            $idHistOrigen = $resultado->fetch_row();
            $idOrigen = $idHistOrigen[0];

            //actualizamos el flag del primer historial o historial anterior registrado
            $sentencia = "UPDATE gdchistorial SET hisFlagD = 1, hisDescD = '".$_POST['ndocEnvioMensaje']."', hisDateTimeD = '".Carbon::now()->toDateTimeString()."' where hisId = '$idOrigen'";

            if(!$Conexion->query($sentencia))
                throw new Exception('No se ha podido actualizar el registro de derivación del documento elegido');

            if(!isset($_POST['ndocEnvioDestino']))
                throw new Exception("Debe elegir almenos una oficina como destino");

            if(count($_POST['ndocEnvioDestino']) > 0)
            {
                $sentencia = "INSERT INTO gdchistorial (hisOfiOrigen, hisOfiDestino, hisFlagR, hisFlagA, hisflagD, hisIdSourceD, arcId, hisRegisterBy, hisRegisterAt) VALUES ";
                $destinatarios = '';

                foreach($_POST['ndocEnvioDestino'] as $ofi)
                {
                    if($_SESSION['oficina'] == $ofi) continue;
                    $sentencia .= "('".$_POST['ndocEnvioOrigen']."','".$ofi."',0,0,0,'$idOrigen','".$_POST['ndocEnvioExp']."','".$_SESSION['codigo']."','".Carbon::now()->toDateTimeString()."'),";
                    $destinatarios .= $ofi.'<'; // separador para destinatarios antes era | cambiado a <
                }
                $sentencia = rtrim($sentencia,',');
                $destinatarios = rtrim($destinatarios,'<');

                if(!$Conexion->query($sentencia))
                    throw new Exception('Error al registrar la derivación del documento hacia los destinatarios elegidos');

                $sentencia = "INSERT INTO gdcderivacion (hisId, derTipo, derExp, derDocTipo, derDestinatarios, derDocDetalle, derDocReferencia, derDerivadoBy, derDerivadoAt)
                          VALUES ('".$idOrigen."','Simple','".$_POST['ndocEnvioExp']."','0','$destinatarios','".$_POST['ndocEnvioMensaje']."','".$idOrigen.'-'.$_POST['ndocEnvioExp']."','".$_SESSION['codigo']."','".Carbon::now()->toDateTimeString()."') ";

                if(!$Conexion->query($sentencia))
                    throw new Exception('No se pudo registrar ls datos de la derivación');

                $sentencia = "UPDATE gdcarchivador SET arcEstado = 'Procesando' WHERE arcId = '".$_POST['ndocEnvioExp']."'";

                if(!$Conexion->query($sentencia))
                    throw new Exception('Error en la actualización del archivador y el estado del documento');
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
            $msg = 'Error: '.$e->getMessage()."\n";
        }

		$Conexion->close();
	}

	echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg));
}

if(isset($_POST['delete']))
{
    $Conexion = conexionBD();

    if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = 500;
        $msg = '';

        $Conexion->autocommit(false);

        try{
            $idExp = explode('-',$_POST['ndocId']);
            $sentencia = "UPDATE gdcarchivador SET arcFlagEliminado = 1 WHERE arcId = $idExp[1]";

            if(!$Conexion->query($sentencia))
                throw new Exception('No se pudo eliminar el documento seleccionado');

            $Respuesta = 200;
            $msg = ELIMINAROK;

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

if(isset($_GET['getjefe']))
{
    $Conexion = conexionBD();

    if(!$Conexion)
    {
        $Respuesta = 500;
        $msg = ERRORCONEXION;
    }
    else
    {
        $Respuesta = 500;
        $msg = array();

        $Sentencia = "select a.ofiDesc, b.jefId, b.jefDni, b.jefNombres, b.jefPaterno, b.jefMaterno, b.jefActivo
						from `".BASEDATOS."`.munioficina a
						inner join `".BASEDATOS."`.munijefeoficina b on b.jefId = a.jefId
						where a.ofiId = ".$_SESSION['oficina'];
        $ListaJefe = $Conexion -> query($Sentencia);
        $Fila = $ListaJefe -> fetch_row();
        $msg['jdni'] = $Fila[2];
        $msg['jnombres'] = $Fila[3];
        $msg['jpaterno'] = $Fila[4];
        $msg['jmaterno'] = $Fila[5];

        $Conexion->close();
    }

    echo json_encode($msg);
}

if(isset($_POST['encdoc']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
    {
        $resultado = '';
        $msg = ERRORCONEXION;
        $Respuesta = 500;
    }
    else
    {
        $resultado = "";

        $Sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcControlPersonal, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                    e.derDestinatarios, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                    a.arcId, b.arcAnio, date_format(c.docFecha,'%d %b %Y') as docFecha, date_format(b.arcRegisterAt,'%d %b %Y %h:%i') as arcFechaReg, c.docAsunto
                    FROM gdchistorial a
                    INNER JOIN gdcarchivador b on b.arcId = a.arcId
                    INNER JOIN gdcdocumento c on c.docId = b.docId
                    INNER JOIN gdcremitente d on d.remId = c.remId
                    LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                    WHERE a.hisOfiDestino = '".$_SESSION['oficina']."'
                    AND a.hisIdSourceD IS NULL
                    AND b.arcFlagEliminado = 0
                    AND b.arcOrigen = '".$_POST['origen']."'";

        if($_POST['nidConsulta'] == 'fechas')
        {
            $Sentencia .= " AND ( CAST(b.arcRegisterAt AS DATE) BETWEEN '".$_POST['ndesdeFecha']."' AND '".$_POST['nhastaFecha']."');";
        }
        else if($_POST['nidConsulta'] == 'asunto')
        {
            $Sentencia .= " AND (c.docAsunto LIKE '%".$_POST['ndescAsunto']."%');";
        }
        else if($_POST['nidConsulta'] == 'codigo')
        {
            $Sentencia .= " AND (replace(b.arcExp,'PK',b.arcId) LIKE '%".$_POST['ndescCodigo']."%');";
        }
        else if($_POST['nidConsulta'] == 'remitp')
        {
            $Sentencia .= " AND (FN_FULLNAMEREM(d.remId,d.remTipo) LIKE '%".$_POST['ndescRemitP']."%');";
        }

        $ListaEmitidos = $Conexion -> query($Sentencia);

        if($ListaEmitidos)
        {
            if($ListaEmitidos->num_rows == 0)
            {
                $resultado = 'No se ha encontrado ningún registro';
            }
            else
            {
                ob_start();
                include '../../.html/modulo1/tabla_resultado_documentos.php';
                $resultado = ob_get_clean();
            }

            $msg = "Recuperado correctamente";
            $Respuesta = 200;
        }
        else
        {
            $resultado = '';
            $msg = 'Error: no se pudo recuperar la información solicitada';
            $Respuesta = 500;
        }

        $Conexion -> close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg, 'resultado' => $resultado));
}

?>