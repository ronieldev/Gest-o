<?php

if (count($this->view->listCobranca) >= 1) {

    foreach ($this->view->listCobranca as $cobranca) {

        $isOverdue = $cobranca->situation_id == 1 && strtotime($cobranca->due_date) < strtotime(date('Y-m-d'));

        $badgeClass = $cobranca->situation_id == 2 ? 'badge-success' : ($isOverdue ? 'badge-danger' : 'badge-warning');
        $situationLabel = $isOverdue ? 'Vencido' : $cobranca->situation_name;

    ?>

        <tr id="cobranca<?= $cobranca->charge_id ?>">
            <td><?= $cobranca->student_name ?></td>
            <td><?= $cobranca->responsible_name ?? '-' ?></td>
            <td><?= date('m/Y', strtotime($cobranca->competency)) ?></td>
            <td>R$ <?= number_format($cobranca->amount, 2, ',', '.') ?></td>
            <td><?= date('d/m/Y', strtotime($cobranca->due_date)) ?></td>
            <td><span class="badge badge-pill p-2 <?= $badgeClass ?>"><?= $situationLabel ?></span></td>
        </tr>

    <?php } ?>

    <tr class="mt-4">
        <td class="font-weight-bold" colspan="6" style="pointer-events:none"><?= count($this->view->listCobranca) ?> cobranças listadas <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } else { ?>

    <tr class="mt-4">
        <td colspan="6" style="pointer-events:none">Nenhuma cobrança gerada <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } ?>
