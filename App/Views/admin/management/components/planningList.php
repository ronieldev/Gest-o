<?php

if (count($this->view->listPlanning) >= 1) {

    foreach ($this->view->listPlanning as $i => $planning) { ?>

        <tr id="planning<?= $planning->planning_id ?>">
            <td><?= $planning->teacher_name ?></td>
            <td><?= $planning->acronym_series ?>ª <?= $planning->ballot ?>-<?= $planning->course ?>-<?= $planning->shift ?></td>
            <td><?= $planning->discipline_name ?></td>
            <td><?= date('d/m/Y', strtotime($planning->start_date)) ?></td>
            <td><?= date('d/m/Y', strtotime($planning->end_date)) ?></td>
        </tr>

    <?php } ?>

    <tr class="mt-4">
        <td class="font-weight-bold" colspan="5" style="pointer-events:none"><?= count($this->view->listPlanning) ?> planejamentos listados <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } else { ?>

    <tr class="mt-4">
        <td colspan="5" style="pointer-events:none">Nenhum planejamento adicionado <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } ?>
