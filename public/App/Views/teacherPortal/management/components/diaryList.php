<?php

if (count($this->view->listDiary) >= 1) {

    foreach ($this->view->listDiary as $i => $diary) { ?>

        <tr id="diary<?= $diary->diary_id ?>">
            <td><?= date('d/m/Y', strtotime($diary->class_date)) ?></td>
            <td><?= $diary->acronym_series ?>ª <?= $diary->ballot ?>-<?= $diary->course ?>-<?= $diary->shift ?></td>
            <td><?= $diary->discipline_name ?></td>
            <td><?= mb_strimwidth(strip_tags($diary->content), 0, 60, '...') ?></td>
            <td><span class="badge badge-pill p-2 badge-info"><?= $diary->total_attachment ?></span></td>
        </tr>

    <?php } ?>

    <tr class="mt-4">
        <td class="font-weight-bold" colspan="5" style="pointer-events:none"><?= count($this->view->listDiary) ?> lançamentos listados <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } else { ?>

    <tr class="mt-4">
        <td colspan="5" style="pointer-events:none">Nenhum lançamento adicionado no diário <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } ?>
