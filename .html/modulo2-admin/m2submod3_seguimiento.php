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
            <td>
                <?php if($Fila['hisDateTimeR'] != ''){ ?>
                <a href="#" class="editDatetime" data-type="combodate" data-name="rece" data-pk="<?= $Fila['hisId'] ?>" data-title="Nueva Fecha y Hora de Recepción"><?= $Fila['hisDateTimeR'] ?></a>
                <?php }else{ echo 'No Recepcionado'; } ?>
            </td>
            <?php
                if($Fila['hisFlagA'] == 1) {
                    echo '<td>Atendido</td>';
                    echo '<td><a href="#" class="editDatetime" data-type="combodate" data-name="aten" data-pk="'.$Fila['hisId'].'" data-title="Nueva Fecha y Hora de Atención">'.$Fila['hisDateTimeA'].'</a></td>';
                }
                else if($Fila['hisFlagD'] == 1)
                {
                    echo '<td>Derivado</td>';
                    echo '<td><a href="#" class="editDatetime" data-type="combodate" data-name="deri" data-pk="'.$Fila['hisId'].'" data-title="Nueva Fecha y Hora de Derivación">'.$Fila['hisDateTimeD'].'</a></td>';
                }
                else
                {
                    echo '<td>Sin Acción</td><td>Sin Acción</td>';
                }
            ?>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('.editDatetime').editable({
            url: '.lib/modulo2/linkModulo2-admin.php',
            params: {editdateoperacion: 1},
            template: "D MMM YYYY HH:mm",
            format: "YYYY-MM-DD HH:mm:ss",
            placement: 'left',
            combodate: {
                firstItem: 'name',
                maxYear: new Date().getFullYear(),
                minYear: 2015,
                minuteStep: 1
            },
            success: function(response){
                var res = $.parseJSON(response);
                if(res.Respuesta == 200)
                {
                    alert(res.msg);
                    cargar_seguimiento();
                }
                else
                {
                    alert(res.msg);
                    cargarSubmodulo(13,'.html/modulo2-admin/m2submod3.html');
                }
            }
        });
    });
</script>