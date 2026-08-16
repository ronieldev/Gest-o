<?php

if (count($this->view->listCurriculumGrid) >= 1) {

    foreach ($this->view->listCurriculumGrid as $i => $curriculumGrid) { ?>

        <tr id="gradeCurricular<?= $curriculumGrid->curriculum_grid_id ?>">
            <td><?= $curriculumGrid->discipline_name ?></td>
            <td><?= $curriculumGrid->acronym ?></td>
            <td><?= $curriculumGrid->discipline_modality ?></td>
            <td><?= $curriculumGrid->workload ?>h</td>
            <td><span class="badge badge-pill p-2 badge-info"><?= $curriculumGrid->total_attachment ?></span></td>
        </tr>

    <?php } ?>

    <tr class="mt-4">
        <td class="font-weight-bold" colspan="5" style="pointer-events:none"><?= count($this->view->listCurriculumGrid) ?> aulas listadas <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } else { ?>

    <tr class="mt-4">
        <td colspan="5" style="pointer-events:none">Nenhuma aula adicionada na grade curricular <i class="fas fa-history ml-2"></i></td>
    </tr>

<?php } ?>
