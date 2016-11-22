<?php
session_start();

use Carbon\Carbon;

include("../_conexion.php");
require '../../vendor/autoload.php';

//Inicializa controles para "Agregar Personal"
if (isset($_POST['initSubModulo1']))
{
	/*$Conexion = conexionBD();

        if (!$Conexion)
        {
            $Respuesta = '';
            $msg = ERRORCONEXION;
            $response = 500;
        }
        else
        {
            $Respuesta = "";

            $Sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcControlPersonal, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                        e.derDestinatarios, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                        a.arcId, b.arcAnio, date_format(c.docFecha,'%d %b %Y') as docFecha, date_format(b.arcRegisterAt,'%d %b %Y %h:%i') as arcFechaReg
                        FROM gdchistorial a
                        INNER JOIN gdcarchivador b on b.arcId = a.arcId
                        INNER JOIN gdcdocumento c on c.docId = b.docId
                        INNER JOIN gdcremitente d on d.remId = c.remId
                        LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                        WHERE a.hisOfiDestino = '".$_SESSION['oficina']."' AND b.arcEstado = 'Registrado' AND a.hisIdSourceD IS NULL AND b.arcFlagEliminado = 0;";

            $ListaEmitidos = $Conexion -> query($Sentencia);

            if($ListaEmitidos)
            {
                while ($Fila = $ListaEmitidos -> fetch_row())
                    $Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$Fila[4]."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$Fila[8]."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."|".$Fila[13]."|".$Fila[14]."|".$Fila[15]."|".$Fila[16]."|".$Fila[17]."$";
                $Respuesta .= "%";
                $msg = 'Recuperado correctamente';
                $response = 200;
            }
            else
            {
                $Respuesta = '';
                $msg = 'Error al recuperar la información de documentos emitidos';
                $response = 500;
            }

            $Conexion -> close();
        }
        echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg, 'response' => $response));*/
}

if (isset($_POST['initDataTable']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
    {
        $Respuesta = '';
        $msg = ERRORCONEXION;
        $response = 500;
    }
    else
    {
        $Respuesta = "";
        $columns = $_POST['columns'];

        $colSort = $_POST['order'][0]['column'];
        $colSort = $columns[$colSort]['data'];

        $dirSort = $_POST['order'][0]['dir'];

        $iniLimit = $_POST['start'];
        $endLimit = $iniLimit + $_POST['length'];

        $Sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcControlPersonal, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                    e.derDestinatarios, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                    a.arcId, b.arcAnio, date_format(c.docFecha,'%d %b %Y') as docFecha, date_format(b.arcRegisterAt,'%d %b %Y %h:%i') as arcFechaReg
                    FROM gdchistorial a
                    INNER JOIN gdcarchivador b on b.arcId = a.arcId
                    INNER JOIN gdcdocumento c on c.docId = b.docId
                    INNER JOIN gdcremitente d on d.remId = c.remId
                    LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                    WHERE a.hisOfiDestino = '".$_SESSION['oficina']."' AND b.arcEstado = 'Registrado' AND a.hisIdSourceD IS NULL AND b.arcFlagEliminado = 0
                    ORDER BY $colSort $dirSort LIMIT $iniLimit, $endLimit
                    ;";

        $ListaEmitidos = $Conexion -> query($Sentencia);
        $recordsTotal = $ListaEmitidos->num_rows;
        $data = array();

        if(!empty($_POST['search']['value']))
        {
            $searchVal = $_POST['search']['value'];
            foreach($columns as $i => $col)
            {
                $field = $col['data'];

                switch($field)
                {
                    case 'docTipo':
                        $colName = "FN_GETDESCTIPODOC(c.tipId)";
                        break;
                    case 'arcCodExp':
                        $colName = "replace(b.arcExp,'PK',b.arcId)";
                        break;
                    case 'remFullName':
                        $colName = "FN_FULLNAMEREM(d.remId,d.remTipo)";
                        break;
                    case 'docFecha':
                        $colName = "date_format(c.docFecha,'%d %b %Y')";
                        break;
                    case 'arcFechaReg':
                        $colName = "date_format(b.arcRegisterAt,'%d %b %Y %h:%i')";
                        break;
                }

                $where[] =  "$colName like '%$searchVal%'";
            }
            $andWhere = implode(" OR ",$where);

            $SentenciaFilter = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcControlPersonal, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                    e.derDestinatarios, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                    a.arcId, b.arcAnio, date_format(c.docFecha,'%d %b %Y') as docFecha, date_format(b.arcRegisterAt,'%d %b %Y %h:%i') as arcFechaReg
                    FROM gdchistorial a
                    INNER JOIN gdcarchivador b on b.arcId = a.arcId
                    INNER JOIN gdcdocumento c on c.docId = b.docId
                    INNER JOIN gdcremitente d on d.remId = c.remId
                    LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                    WHERE a.hisOfiDestino = '".$_SESSION['oficina']."' AND b.arcEstado = 'Registrado' AND a.hisIdSourceD IS NULL AND b.arcFlagEliminado = 0
                    AND ($andWhere)
                    ORDER BY $colSort $dirSort LIMIT $iniLimit, $endLimit
                    ;";

            $ListaFiltrados = $Conexion->query($SentenciaFilter);

            $recordsFilter = $ListaFiltrados->num_rows;

            while ($Fila = $ListaFiltrados -> fetch_assoc())
                $data[] = $Fila;
        }
        else
        {
            $recordsFilter = $recordsTotal;

            while ($Fila = $ListaEmitidos -> fetch_assoc())
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

//Inicializa controles para "Editar Personal"
if (isset($_POST['initSubModulo2']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
    {
        $Respuesta = '';
        $msg = ERRORCONEXION;
        $response = 500;
    }
    else
    {
        $Respuesta = "";
        $columns = $_POST['columns'];

        $colSort = $_POST['order'][0]['column'];
        $colSort = $columns[$colSort]['data'];

        $dirSort = $_POST['order'][0]['dir'];

        $iniLimit = $_POST['start'];
        $endLimit = $iniLimit + $_POST['length'];

        $Sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcControlPersonal, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                    FN_GETDESCOFTARGET(e.derDestinatarios) as hisDestinos, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                    a.arcId, b.arcAnio, c.docNumero
                    FROM gdchistorial a
                    INNER JOIN gdcarchivador b on b.arcId = a.arcId
                    INNER JOIN gdcdocumento c on c.docId = b.docId
                    INNER JOIN gdcremitente d on d.remId = c.remId
                    LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                    WHERE a.hisOfiDestino = '".$_SESSION['oficina']."' AND b.arcEstado != 'Registrado' AND a.hisIdSourceD IS NULL AND b.arcFlagEliminado = 0
                    ORDER BY $colSort $dirSort LIMIT $iniLimit, $endLimit;";

        $ListaEmitidos = $Conexion -> query($Sentencia);
        $recordsTotal = $ListaEmitidos->num_rows;
        $data = array();

        if(!empty($_POST['search']['value']))
        {
            $searchVal = $_POST['search']['value'];
            foreach($columns as $i => $col)
            {
                $field = $col['data'];

                switch($field)
                {
                    case 'docTipo':
                        $colName = "FN_GETDESCTIPODOC(c.tipId)";
                        break;
                    case 'arcCodExp':
                        $colName = "replace(b.arcExp,'PK',b.arcId)";
                        break;
                    case 'remFullName':
                        $colName = "FN_FULLNAMEREM(d.remId,d.remTipo)";
                        break;
                    case 'hisDestinos':
                        $colName = "FN_GETDESCOFTARGET(e.derDestinatarios)";
                        break;
                }

                $where[] =  "$colName like '%$searchVal%'";
            }
            $andWhere = implode(" OR ",$where);

            $SentenciaFilter = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, c.docNumero, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                    FN_GETDESCOFTARGET(e.derDestinatarios) as hisDestinos, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                    a.arcId, b.arcAnio, c.docNumero
                    FROM gdchistorial a
                    INNER JOIN gdcarchivador b on b.arcId = a.arcId
                    INNER JOIN gdcdocumento c on c.docId = b.docId
                    INNER JOIN gdcremitente d on d.remId = c.remId
                    LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                    WHERE a.hisOfiDestino = '".$_SESSION['oficina']."' AND b.arcEstado != 'Registrado' AND a.hisIdSourceD IS NULL AND b.arcFlagEliminado = 0
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

            while ($Fila = $ListaEmitidos -> fetch_assoc())
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

/*if (isset($_POST['initSubModulo2']))
{
    $Conexion = conexionBD();

    if (!$Conexion)
    {
        $Respuesta = '';
        $msg = ERRORCONEXION;
        $response = 500;
    }
    else
    {
        $Respuesta = "";

        $Sentencia = "SELECT FN_GETDESCTIPODOC(c.tipId) as docTipo, replace(b.arcExp,'PK',b.arcId) AS arcCodExp, b.arcControlPersonal, FN_FULLNAMEREM(d.remId,d.remTipo) as remFullName,
                    e.derDestinatarios, a.hisDescD, b.arcEstado, a.hisId, a.hisOfiOrigen, FN_GETDESCOFI(a.hisOfiOrigen) AS remOfi, a.hisFlagR, a.hisFlagA, a.hisFlagD, a.hisIdSourceD,
                    a.arcId, b.arcAnio
                    FROM gdchistorial a
                    INNER JOIN gdcarchivador b on b.arcId = a.arcId
                    INNER JOIN gdcdocumento c on c.docId = b.docId
                    INNER JOIN gdcremitente d on d.remId = c.remId
                    LEFT JOIN gdcderivacion e on e.hisId = a.hisId
                    WHERE a.hisOfiDestino = '".$_SESSION['oficina']."' AND b.arcEstado != 'Registrado' AND a.hisIdSourceD IS NULL AND b.arcFlagEliminado = 0;";

        $ListaEmitidos = $Conexion -> query($Sentencia);

        if($ListaEmitidos)
        {
            while ($Fila = $ListaEmitidos -> fetch_row())
            {
                $destinatarios = explode('<',$Fila[4]);
                $ofisDestinos = '';
                foreach($destinatarios as $d)
                {
                    $sentencia = "SELECT ofiDesc FROM munioficina WHERE ofiId = $d";
                    $listaOfis = $Conexion->query($sentencia);
                    $filaOfis = $listaOfis->fetch_row();
                    $ofisDestinos .= $filaOfis[0] . ';';

                }
                $ofisDestinos = rtrim($ofisDestinos,';');
                $Respuesta .= $Fila[0]."|".$Fila[1]."|".$Fila[2]."|".$Fila[3]."|".$ofisDestinos."|".$Fila[5]."|".$Fila[6]."|".$Fila[7]."|".$Fila[8]."|".$Fila[9]."|".$Fila[10]."|".$Fila[11]."|".$Fila[12]."|".$Fila[13]."|".$Fila[14]."|".$Fila[15]."$";
            }
            $Respuesta .= "%";
            $msg = 'Recuperado correctamente';
            $response = 200;
        }
        else
        {
            $Respuesta = '';
            $msg = 'Error al recuperar la información de documentos emitidos';
            $response = 500;
        }

        $Conexion -> close();
    }
    echo json_encode(array('Respuesta' => $Respuesta, 'msg' => $msg, 'response' => $response));
}*/
?>