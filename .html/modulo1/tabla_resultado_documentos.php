<table class="table table-condensed tbl-resultado" style="font-size: smaller;">
    <thead>
    <tr>
        <th colspan="9">DOCUMENTOS</th>
    </tr>
    <tr>
        <th>Tipo Doc</th>
        <th>Doc</th>
        <th>Num. Doc.</th>
        <th>Fec. Doc.</th>
        <th>Remitente</th>
        <th>Fec. Registro</th>
        <th>Asunto</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($ListaEmitidos as $Fila) {
    ?>
        <tr>
            <td><?= $Fila['docTipo'] ?></td>
            <td>
                <a href="javascript:void(0)" onclick="mostrar_documento('<?= $Fila['arcCodExp'] ?>','<?= $_POST['origen'] ?>')">
                <?= $Fila['arcCodExp'] ?>
                </a>
            </td>
            <td><?= $Fila['arcControlPersonal'] ?></td>
            <td><?= $Fila['docFecha'] ?></td>
            <td><?= $Fila['remFullName'] ?></td>
            <td><?= $Fila['arcFechaReg'] ?></td>
            <td><?= $Fila['docAsunto'] ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>