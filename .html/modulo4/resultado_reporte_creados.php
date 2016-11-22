<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Reporte</title>
    </head>
    <body>
        <table class="table table-condensed tbl-resultado" style="font-size: smaller" id="tblReporteResultado">
                <thead>
                <tr>
                    <th colspan="7">RESULTADO DEL REPORTE DE DOCUMENTOS EMITIDOS</th>
                </tr>
                <tr>
                    <th>Nro</th>
                    <th>Tipo</th>
                    <th>Doc</th>
                    <th>Estado</th>
                    <th>Nota o mensaje</th>
                    <th>Destino</th>
                    <th>Fec. Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($ListaReporte as $i => $Fila) {
                ?>
                    <tr>
                        <td><?= ($i+1) ?></td>
                        <td><?= $Fila['docTipo'] ?></td>
                        <td><?= $Fila['arcCodExp'] ?></td>
                        <td><?= $Fila['hisEstado']=='RECIBIDO'?'PENDIENTE':$Fila['hisEstado'] ?></td>
                        <td><?= $Fila['hisEstadoMensaje'] ?></td>
                        <td><?= $Fila['hisDestino'] ?></td>
                        <td><?= $Fila['hisEstadoFecha'] ?></td>
                    </tr>
                <?php }?>
                </tbody>
        </table>
    </body>
</html>