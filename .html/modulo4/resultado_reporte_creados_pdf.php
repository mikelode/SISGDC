<!DOCTYPE html>
<html>
    <head lang="en">
        <meta charset="UTF-8">
        <title>Reporte</title>
        <style>
            @page { margin: 20px 50px 50px 50px; }
            .header {
                height: auto;
                position: relative;
            }
            .logo{
                float: left;
            }
            .sign{
                font-size: 11px;
                font-family: Courier, "Courier new", monospace;
                width: 28%;
                text-align: center;
                float: left;
                display: inline-block;
            }
            .slogan{
                position: relative;
                height: auto;
                top: 0;
                left: 0;
            }
            .datehead{
                position: absolute;
                height: auto;
                top: 25px;
                right: 90px;
            }
            .datehead thead tr td, .datehead tbody tr td{
                font-size: 12px;
                padding: 2px;
            }
            .title{
                margin-top: 30px;
                margin-left: 180px;
            }
            .title h3{
                box-shadow: 30px 10px 20px #aaa;
                border: solid 1px #000000;
                border-radius: 15px;
                width: 380px;
                height: 48px;
                background-color: #eaeaea;
            }
            .pagenum:before {
                content: counter(page);
            }
            table, th, td {
                border: 1px solid black;
                font-size: 8px;
                border-collapse: collapse;
                text-align: left;
                /*height: 40px;*/
            }
            thead{
                display: table-header-group;

            }
            thead th{
                background-color: #eaeaea;
                text-align: center;
            }
            thead td{
                border-top: hidden;
                border-left: hidden;
                border-right: hidden;
            }
            tfoot{
                display: table-row-group
            }
            tr{
                page-break-inside: avoid
            }
            .footer {
                position: fixed;
                bottom: 0;
                border-top: solid 1px;
                width: 100%;
                font-family: "Courier New", Courier, monospace;
                font-size: 12px;
                font-weight: bold;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="slogan">
                <div class="logo">
                    <img src="../../.res/images/muni_yarabamba_logo.png" style="height: 80px; width: 150px;">
                </div>
            </div>
            <div class="title" style="text-align: center">
                <h3>REPORTE DE DOCUMENTOS<br> <?= $tipoReporte ?></h3>
            </div>
            <table class="datehead">
                <thead>
                    <tr>
                        <td>Día</td>
                        <td>Mes</td>
                        <td>Año</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $dia ?></td>
                        <td><?= $mes ?></td>
                        <td><?= $anio ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            Página <span class="pagenum"></span>
        </div>
        <div class="content">
            <table class="table" style="font-size: smaller; width: 100%; page-break-inside: auto;">
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
        </div>
    </body>
</html>