<?php if (count($this->view->chamadaList) >= 1) { ?>

    <tr class="mt-4">
        <td colspan="3" style="pointer-events:none">

            <span class="badge badge-pill p-2 badge-success mr-2"><?= $this->view->totalPresenca ?> presenças</span>
            <span class="badge badge-pill p-2 badge-danger mr-2"><?= $this->view->totalFalta ?> faltas</span>
            <span class="badge badge-pill p-2 badge-warning"><?= $this->view->totalJustificada ?> justificadas</span>

        </td>
    </tr>

    <?php foreach ($this->view->chamadaList as $key => $chamada) {

        $situacaoLabel = ['P' => 'Presente', 'F' => 'Falta', 'J' => 'Justificada'][$chamada->situacao] ?? $chamada->situacao;
        $situacaoBadge = ['P' => 'badge-success', 'F' => 'badge-danger', 'J' => 'badge-warning'][$chamada->situacao] ?? 'badge-secondary';
    ?>

        <tr id="chamada<?= $chamada->id_chamada ?>">

            <td class="text-left"><?= date('d/m/Y', strtotime($chamada->data_aula)) ?></td>
            <td><span class="badge badge-pill p-2 <?= $situacaoBadge ?>"><?= $situacaoLabel ?></span></td>
            <td class="text-left"><?= $chamada->justificativa ?? '-' ?></td>

        </tr>

    <?php } ?>

    <tr class="mt-4">
        <td class="font-weight-bold" colspan="3" style="pointer-events:none"><?= count($this->view->chamadaList) ?> registros listados <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } else { ?>

    <tr class="mt-4">
        <td colspan="3" style="pointer-events:none">Nenhum registro de frequência encontrado <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } ?>
