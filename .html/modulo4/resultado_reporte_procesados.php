<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Reporte</title>
    </head>
    <body>
        <table class="table table-condensed tbl-resultado" style="font-size: smaller;" id="tblReporteResultado">
            <thead>
            <tr>
                <th colspan="9">RESULTADO DEL REPORTE DE DOCUMENTOS RECIBIDOS</th>
            </tr>
            <tr>
                <th>Nro</th>
                <th>Tipo</th>
                <th>Doc</th>
                <th>Ofi. Remitente</th>
                <th>Recepción</th>
                <th>Fec. Recepción</th>
                <th>Estado</th>
                <th>Doc. de salida</th>
                <th>Nota o mensaje</th>
                <th>Destino</th>
                <th>Fec. Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($ListaReporte as $i => $Fila) { ?>
                <tr>
                    <td><?= ($i+1) ?></td>
                    <td><?= $Fila['docTipo'] ?></td>
                    <td><?= $Fila['arcCodExp'] ?></td>
                    <td><?= $Fila['ofiRemitente'] ?></td>
                    <td><?= $Fila['hisFlagR']==1?'Recibido':'No recibido' ?></td>
                    <td><?= $Fila['hisDateTimeR'] ?></td>
                    <td><?= $Fila['hisEstado'] ?></td>
                    <td><?= $Fila['derDoc'] ?></td>
                    <td><?= $Fila['hisEstadoMensaje'] ?></td>
                    <td><?= $Fila['hisDestino'] ?></td>
                    <td><?= $Fila['hisEstadoFecha'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>