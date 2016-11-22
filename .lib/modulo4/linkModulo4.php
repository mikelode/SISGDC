<?php

session_start();

use Carbon\Carbon;
use Dompdf\Dompdf;

include("../_conexion.php");
require '../../vendor/autoload.php';

//Inicializa controles para "Agregar Intervenci�n"
if (isset($_POST['initSubModulo1']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

		$Sentencia = "select ofiId, ofiCod, ofiDesc from munioficina where ofiActivo = 1";
		$ListaOficinas = $Conexion -> query($Sentencia);
		while ($Fila = $ListaOficinas -> fetch_row())
			$Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."$";
		$Respuesta .= "%";

        $Sentencia = "select tipId, tipDesc from gdctipodocumento";
        $ListaTipos = $Conexion -> query($Sentencia);
        while($Fila = $ListaTipos -> fetch_row())
            $Respuesta .= $Fila[0]."|".$Fila[1]."$";
        $Respuesta .= "%";

		$Conexion -> close();
	}
	echo $Respuesta;
}

//Inicializa controles para "Reportes"
if (isset($_POST['initSubModulo2']))
{
	$Conexion = conexionBD();

	if (!$Conexion)
		$Respuesta = ERRORCONEXION;
	else
	{
		$Respuesta = "";

        $Sentencia = "select ofiId, ofiCod, ofiDesc from munioficina where ofiActivo = 1";
        $ListaOficinas = $Conexion -> query($Sentencia);

        while ($Fila = $ListaOficinas -> fetch_row())
            $Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."$";
        $Respuesta .= "%";

        $Sentencia = "select nCodigo, ofiId, cNombres, cPaterno, cMaterno, cDni
                      from musuarios where cFlagEliminado = 0 and nTipo = 2 and cActivo = 1
                      and nCodigo = '".$_SESSION['codigo']."';";
        $DatosUsuario = $Conexion->query($Sentencia);

        while($Fila = $DatosUsuario->fetch_row())
            $Respuesta .= implode('|',$Fila).'$';
        $Respuesta .= '%';

        $Conexion -> close();
	}
	echo $Respuesta;
}

if(isset($_POST['buscardoc']))
{
    //echo $_POST['ndocCodigo'].'-'.$_POST['ndocTipo'].'-'.$_POST['ndocFechaIni'].'-'.$_POST['ndocFechaFin'].'-'.$_POST['ndocOfiCreador'].'-'.$_POST['ndocOrigen'].'-'.$_POST['ndocAsunto'];
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

        $Sentencia = "SELECT a.docId, a.docAsunto, a.docFolio, a.docFecha, FN_GETDESCTIPODOC(a.tipId) as docTipo,
                        b.arcAnio, b.arcControlPersonal, b.arcEstado, replace(b.arcExp,'PK',b.arcId) AS arcCodExp,
                        b.arcFechaRecepcion, b.arcOrigen, b.arcPrioridad, c.arpOficina, b.arcId
                        FROM gdcdocumento a
                        INNER JOIN gdcarchivador b ON b.docId = a.docId
                        INNER JOIN gdcarchivadorparticular c ON c.arcId = b.arcId
                        WHERE b.arcFlagEliminado = 0 AND";

        if(trim($_POST['ndocCodigo']) != '')
        {
            $key = explode('-',$_POST['ndocCodigo']);
            $Sentencia .= " b.arcId = '".$key[1]."' AND";
        }

        if($_POST['ndocTipo'] != 'all')
        {
            $Sentencia .= " a.tipId = '".$_POST['ndocTipo']."' AND";
        }

        if($_POST['ndocFechaIni'] != '' && $_POST['ndocFechaFin'] != '')
        {
            $Sentencia .= " a.docFecha BETWEEN '".$_POST['ndocFechaIni']."' AND '".$_POST['ndocFechaFin']."' AND";
        }

        if($_POST['ndocOfiCreador'] != 'all')
        {
            $Sentencia .= " c.ofiId = '".$_POST['ndocOfiCreador']."' AND";
        }

        if($_POST['ndocOrigen'] != 'all')
        {
            $Sentencia .= " b.arcOrigen = '".$_POST['ndocOrigen']."' AND";
        }

        if(trim($_POST['ndocAsunto']) != '')
        {
            $Sentencia .= " a.docAsunto LIKE '%".trim($_POST['ndocAsunto'])."%' AND";
        }

        $Sentencia = rtrim($Sentencia, ' AND');

        $ListaDocumentos = $Conexion -> query($Sentencia);

        while($Fila = $ListaDocumentos -> fetch_row())
        {
            $Respuesta .= $Fila[0].'|'.$Fila[1].'|'.$Fila[2].'|'.$Fila[3].'|'.$Fila[4].'|'.$Fila[5].'|'.$Fila[6].'|'.$Fila[7].'|'.$Fila[8].'|'.$Fila[9].'|'.$Fila[10].'|'.$Fila[11].'|'.$Fila[12].'|'.$Fila[13].'$';
        }
        $Respuesta .= "%";

        $Conexion -> close();
    }

    echo $Respuesta;
}

if(isset($_POST['buscarmov']))
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

        $Sentencia = "SELECT a.docId, b.arcId, a.docAsunto, a.docFolio, a.docFecha, FN_GETDESCTIPODOC(a.tipId) as docTipo,
                    b.arcAnio, b.arcControlPersonal, b.arcEstado, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcFechaRecepcion,
                    b.arcOrigen, b.arcPrioridad, c.arpOficina, d.hisId, FN_GETDESCOFI(d.hisOfiOrigen) ofiOrigen, FN_GETDESCOFI(d.hisOfiDestino) ofiDestino, d.hisIdSourceD,
                    d.hisFlagR, d.hisFlagA, d.hisFlagD, d.hisDescR, d.hisDescA, d.hisDescD, d.hisDateTimeR, d.hisDateTimeA,
                    d.hisDateTimeD, e.derTipo, e.derDocTipo, e.derDocDetalle, e.derDestinatarios, FN_GETFECENVIO(d.hisIdSourceD) fecEnvio
                    FROM gdcdocumento a
                    INNER JOIN gdcarchivador b ON b.docId = a.docId
                    INNER JOIN gdcarchivadorparticular c ON c.arcId = b.arcId
                    LEFT JOIN gdchistorial d ON d.arcId = b.arcId
                    LEFT JOIN gdcderivacion e ON e.hisId = d.hisId
                    WHERE b.arcFlagEliminado = 0 AND";

        if($_POST['ndocEnvIni'] != '' && $_POST['ndocEnvFin'] != '')
        {
            $Sentencia .= " d.hisDateTimeD BETWEEN '".$_POST['ndocEnvIni']."' AND '".$_POST['ndocEnvFin']."' AND";
        }

        if($_POST['ndocOfiEnvio'] != 'all')
        {
            $Sentencia .= " d.hisOfiOrigen = '".$_POST['ndocOfiEnvio']."' AND";
        }

        if($_POST['ndocRcpIni'] != '' && $_POST['ndocRcpFin'] != '')
        {
            $Sentencia .= " d.hisDateTimeR BETWEEN '".$_POST['ndocRcpIni']."' AND '".$_POST['ndocRcpFin']."' AND";
        }

        if($_POST['ndocOfiDestino'] != 'all')
        {
            $Sentencia .= " d.hisOfiDestino = '".$_POST['ndocOfiDestino']."' AND";
        }

        if($_POST['ndocEstado'] != 'all')
        {
            $Sentencia .= " b.arcEstado = '".$_POST['ndocEstado']."' AND";
        }

        $Sentencia = rtrim($Sentencia, ' AND');

        $ListaDocumentos = $Conexion -> query($Sentencia);

        while($Fila = $ListaDocumentos -> fetch_row())
        {
            $Respuesta .= $Fila[0].'|'.$Fila[1].'|'.$Fila[2].'|'.$Fila[3].'|'.$Fila[4].'|'.$Fila[5].'|'.$Fila[6].'|'.$Fila[7].'|'.$Fila[8].'|'.$Fila[9].'|'.$Fila[10].'|'.$Fila[11].'|'.$Fila[12].'|'.$Fila[13].'|'.$Fila[14].'|'.$Fila[15].'|';
            $Respuesta .= $Fila[16].'|'.$Fila[17].'|'.$Fila[18].'|'.$Fila[19].'|'.$Fila[20].'|'.$Fila[21].'|'.$Fila[22].'|'.$Fila[23].'|'.$Fila[24].'|'.$Fila[25].'|'.$Fila[26].'|'.$Fila[27].'|'.$Fila[28].'|'.$Fila[29].'|'.$Fila[30].'|'.$Fila[31].'$';
        }
        $Respuesta .= "%";

        $Conexion -> close();
    }

    echo $Respuesta;
}

if(isset($_GET['seguimiento']))
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

        $Sentencia = "SELECT b.hisId, b.hisIdSourceD, d.derDestinatarios, d.derTipo, a.arcOrigen, a.arcId, c.docId, e.arpOficina, FN_GETDESCTIPODOC(c.tipId) docTipo,
                    FN_GETDESCOFI(b.hisOfiOrigen) ofiOrigen, FN_GETDESCOFI(b.hisOfiDestino) ofiDestino, a.arcEstado, c.docFecha, a.arcFechaRecepcion, a.arcEstado,
                    b.hisFlagR, b.hisFlagA, b.hisFlagD, b.hisDateTimeR, b.hisDateTimeA, b.hisDateTimeD, b.hisDescR, b.hisDescA, b.hisDescD, replace(a.arcExp,'PK',a.arcId) AS codExp,
                    FN_GETFECENVIO(b.hisIdSourceD) fecEnvio
                    FROM gdcarchivador a
                    LEFT JOIN gdchistorial b ON b.arcId = a.arcId
                    INNER JOIN gdcdocumento c ON c.docId = a.docId
                    LEFT JOIN gdcderivacion d ON d.hisId = b.hisId
                    INNER JOIN gdcarchivadorparticular e ON e.arcId = a.arcId
                    WHERE a.arcId = '".$_GET['arcId']."';";

        $ListaSeguimiento = $Conexion->query($Sentencia);

        if($ListaSeguimiento)
        {
            /*while($Fila = $ListaSeguimiento -> fetch_row())
                $Respuesta .= implode('|',$Fila) . '$';
            $Respuesta .= '%';*/
            ob_start();
            include '../../.html/modulo4/m4submod1_seguimiento.php';
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

if(isset($_POST['reporte']))
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

        $andWhere = "";
        if($_POST['ndocOrigen'] == 'interno')
        {
            $andWhere = " a.arcOrigen = 'interno' and";
        }
        else if($_POST['ndocOrigen'] == 'externo')
        {
            $andWhere = " a.arcOrigen = 'externo' and";
        }

        $andWhere .= " cast(a.arcRegisterAt as date) between '".$_POST['ndocFechaIni']."' and '".$_POST['ndocFechaFin']."' ";

        if($_POST['ndocReporteTipo'] == 'creados')
        {
            $sentencia = getSentenciaReporte('creados',$andWhere);
            $ListaReporte = $Conexion->query($sentencia);

            if($ListaReporte)
            {
                ob_start();
                include '../../.html/modulo4/resultado_reporte_creados.php';
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
        }
        else if($_POST['ndocReporteTipo'] == 'procesados')
        {

            $sentencia = getSentenciaReporte('procesados',$andWhere);
            $ListaReporte = $Conexion->query($sentencia);

            if($ListaReporte)
            {
                ob_start();
                include '../../.html/modulo4/resultado_reporte_procesados.php';
                $Respuesta = ob_get_clean();
                $msg = 'Recuperado correctamente';
                $response = 200;
            }
            else
            {
                $Respuesta = '';
                $msg = 'Error al recuperar los datos para el reporte de recibidos';
                $response = 500;
            }
        }

        $Conexion -> close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg, 'response' => $response));
}

if(isset($_POST['ndocImprimible']))
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
        $dia = Carbon::now()->day;
        $mes = Carbon::now()->month;
        $anio = Carbon::now()->year;

        $andWhere = "";
        if($_POST['ndocOrigen'] == 'interno')
        {
            $andWhere = " a.arcOrigen = 'interno' and";
        }
        else if($_POST['ndocOrigen'] == 'externo')
        {
            $andWhere = " a.arcOrigen = 'externo' and";
        }

        $andWhere .= " cast(a.arcRegisterAt as date) between '".$_POST['ndocFechaIni']."' and '".$_POST['ndocFechaFin']."' ";

        if($_POST['ndocReporteTipo'] == 'creados')
        {
            $sentencia = getSentenciaReporte('creados',$andWhere);
            $ListaReporte = $Conexion->query($sentencia);
            $tipoReporte = 'EMITIDOS';

            if($ListaReporte)
            {
                ob_start();
                include '../../.html/modulo4/resultado_reporte_creados_pdf.php';
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
        }
        else if($_POST['ndocReporteTipo'] == 'procesados')
        {
            $sentencia = getSentenciaReporte('procesados',$andWhere);
            $ListaReporte = $Conexion->query($sentencia);
            $tipoReporte = 'RECIBIDOS';

            if($ListaReporte)
            {
                ob_start();
                include '../../.html/modulo4/resultado_reporte_procesados_pdf.php';
                $Respuesta = ob_get_clean();
                $msg = 'Recuperado correctamente';
                $response = 200;
            }
            else
            {
                $Respuesta = '';
                $msg = 'Error al recuperar los datos para el reporte de recibidos';
                $response = 500;
            }
        }

        $Conexion -> close();
    }

    $domPdf = new Dompdf();
    $domPdf->loadHtml($Respuesta);
    $domPdf->render();
    $domPdf->stream("reporteTramite.pdf",array('Attachment'=>0));
}

function getSentenciaReporte($tipo, $andWhere)
{
    if($tipo == 'creados')
    {
        $sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) docTipo, replace(a.arcExp,'PK',a.arcId) arcCodExp, FN_GETTEXTESTADO(b.hisId) hisEstado,
                d.derTipo, FN_GETDESCTIPODOC(d.derDocTipo) derDoc, FN_GETMSGESTADO(b.hisId) hisEstadoMensaje,
                FN_GETDESCOFTARGET(d.derDestinatarios) hisDestino, FN_GETFECHAESTADO(b.hisId) hisEstadoFecha,
                b.hisId, b.hisIdSourceD, a.arcOrigen, a.arcId, c.docId, a.arcEstado, c.docFecha, a.arcFechaRecepcion,
                FN_GETFECENVIO(b.hisIdSourceD) fecEnvio
                FROM gdcarchivador a
                LEFT JOIN gdchistorial b ON b.arcId = a.arcId
                INNER JOIN gdcdocumento c ON c.docId = a.docId
                LEFT JOIN gdcderivacion d ON d.hisId = b.hisId
                INNER JOIN gdcarchivadorparticular e ON e.arcId = a.arcId
                WHERE (b.hisOfiDestino = '".$_POST['ndocOfiCreador']."' and b.hisIdSourceD is null and a.arcFlagEliminado = 0)
                AND ($andWhere)
                order by a.arcRegisterAt,b.hisRegisterAt ASC;";
    }
    else if($tipo == 'procesados')
    {
        $sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) docTipo, replace(a.arcExp,'PK',a.arcId) arcCodExp, FN_GETDESCOFI(b.hisOfiOrigen) ofiRemitente,
                b.hisFlagR, b.hisDateTimeR, b.hisDescR, FN_GETTEXTESTADO(b.hisId) hisEstado, d.derTipo, FN_GETDESCTIPODOC(d.derDocTipo) derDoc,
                FN_GETMSGESTADO(b.hisId) hisEstadoMensaje, FN_GETDESCOFTARGET(d.derDestinatarios) hisDestino, FN_GETFECHAESTADO(b.hisId) hisEstadoFecha,
                b.hisId, b.hisIdSourceD, a.arcOrigen, a.arcId, c.docId, a.arcEstado, c.docFecha, a.arcFechaRecepcion,
                FN_GETFECENVIO(b.hisIdSourceD) fecEnvio
                FROM gdcarchivador a
                LEFT JOIN gdchistorial b ON b.arcId = a.arcId
                INNER JOIN gdcdocumento c ON c.docId = a.docId
                LEFT JOIN gdcderivacion d ON d.hisId = b.hisId
                INNER JOIN gdcarchivadorparticular e ON e.arcId = a.arcId
                WHERE (b.hisOfiDestino = '".$_POST['ndocOfiCreador']."' and b.hisOfiOrigen <> '".$_POST['ndocOfiCreador']."' and a.arcFlagEliminado = 0)
                AND ($andWhere)
                order by a.arcRegisterAt,b.hisRegisterAt ASC;";
    }

    return $sentencia;

}

?>