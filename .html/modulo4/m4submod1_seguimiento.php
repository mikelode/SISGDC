<table class="table table-condensed tbl-resultado" style="font-size: smaller;">
    <thead>
        <tr>
            <th colspan="9">SEGUIMIENTO DEL DOCUMENTO SELECCIONADO</th>
        </tr>
        <tr>
            <th>Nro</th>
            <th>Tipo Doc</th>
            <th>Doc</th>
            <th>Ofi. Origen</th>
            <th>Fec. Envío</th>
            <th>Ofi Destino</th>
            <th>Fec. Recepción</th>
            <th>Atender/Derivar</th>
            <th>Fecha Atend/Deriv</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($ListaSeguimiento as $i => $Fila) { ?>
        <tr>
            <td><?= ($i+1) ?></td>
            <td><?= $Fila['docTipo'] ?></td>
            <td><?= $Fila['codExp'] ?></td>
            <td><?= $Fila['ofiOrigen'] ?></td>
            <td><?= $Fila['fecEnvio'] ?></td>
            <td><?= $Fila['ofiDestino'] ?></td>
            <td><?= $Fila['hisDateTimeR'] ?></td>
            <?php
                if($Fila['hisFlagA'] == 1) {
                    echo '<td>Atendido</td>';
                    echo '<td>'.$Fila['hisDateTimeA'].'</td>';
                }
                else if($Fila['hisFlagD'] == 1)
                {
                    echo '<td>Derivado</td>';
                    echo '<td>'.$Fila['hisDateTimeD'].'</td>';
                }
            ?>
        </tr>
    <?php } ?>
    </tbody>
</table>