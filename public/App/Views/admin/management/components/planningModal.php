<?php

$current_label = $this->view->planning[0]->teacher_name . ' - ' . $this->view->planning[0]->acronym_series . $this->view->planning[0]->ballot . $this->view->planning[0]->course . ' ' . $this->view->planning[0]->shift . ' - ' . $this->view->planning[0]->discipline_name;

?>

<form id="formPlanning<?= $this->view->planning[0]->planning_id ?>" class="col-lg-11 mx-auto mb-4" action="">

    <div class="col-lg-12">

        <div class="row modal-header d-flex justify-content-between">
            <h5 discipline class="col-lg-8 font-weight-bold pl-0"><?= $this->view->planning[0]->discipline_name ?></h5>
            <div class="col-lg-4 d-flex justify-content-end pr-0">

                <span idElement="#formPlanning<?= $this->view->planning[0]->planning_id ?>" class="mr-2 edit-data-icon" data-toggle="tooltip" data-placement="left" title="Editar">
                    <i class="fas fa-edit"></i>
                </span>

                <span idElement="#formPlanning<?= $this->view->planning[0]->planning_id ?>" routeUpdate="/admin/gestao/planejamento/atualizar" toastData="Planejamento atualizado" container="containerListPlanning" routeList="/admin/gestao/planejamento/lista" class="mr-2 update-data-icon" data-toggle="tooltip" data-placement="top" title="Atualizar">
                    <i class="fas fa-check"></i>
                </span>

                <span idElement="#formPlanning<?= $this->view->planning[0]->planning_id ?>" routeDelete="/admin/gestao/planejamento/deletar" toastData="Planejamento deletado" container="containerListPlanning" routeList="/admin/gestao/planejamento/lista" class="mr-2 delete-data-icon" data-toggle="tooltip" data-placement="right" title="Deletar">
                    <i class="fas fa-trash-alt"></i>
                </span>

            </div>
        </div>

        <div class="form-row mb-2 mt-3">

            <input type="hidden" name="planningId" value="<?= $this->view->planning[0]->planning_id ?>">

            <div class="form-group col-lg-12">

                <label for="">Professor / Turma / Matéria:</label>

                <select disabled name="classDiscipline" class="form-control custom-select" required>

                    <option value="<?= $this->view->planning[0]->fk_id_class_discipline ?>"><?= $current_label ?></option>

                    <?php foreach ($this->view->listAvailableSubjects as $key => $subject) { ?>

                        <?php if ($this->view->planning[0]->fk_id_class_discipline != $subject->option_value) { ?>
                            <option value="<?= $subject->option_value ?>"><?= $subject->option_text ?></option>
                        <?php } ?>

                    <?php } ?>

                </select>

            </div>

        </div>

        <div class="form-row mb-2">

            <div class="form-group col-lg-3">
                <label for="">Início:</label>
                <input class="form-control" disabled value="<?= $this->view->planning[0]->start_date ?>" type="date" name="startDate" id="">
            </div>

            <div class="form-group col-lg-3">
                <label for="">Fim:</label>
                <input class="form-control" disabled value="<?= $this->view->planning[0]->end_date ?>" type="date" name="endDate" id="">
            </div>

            <div class="form-group col-lg-6">
                <label for="">Observação:</label>
                <textarea class="form-control" disabled rows="1" name="observationPlanning"><?= $this->view->planning[0]->observation ?></textarea>
            </div>

        </div>

        <div class="form-row d-flex justify-content-end modal-links-alternativos mt-3 mb-3">

            <a class="btn main-button text-white" data-dismiss="modal" href="">Retornar a sessão</a>

        </div>

    </div>

</form>
