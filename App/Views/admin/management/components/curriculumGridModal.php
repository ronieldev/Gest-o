

<form id="formCurriculumGrid<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>" class="col-lg-11 mx-auto mb-4" action="">

    <div class="col-lg-12">

        <div class="row modal-header d-flex justify-content-between">
            <h5 discipline class="col-lg-6 font-weight-bold pl-0"><?= $this->view->curriculumGrid[0]->discipline_name ?></h5>
            <div class="col-lg-6 d-flex justify-content-end pr-0">

                <span idElement="#formCurriculumGrid<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>" class="mr-2 edit-data-icon" data-toggle="tooltip" data-placement="left" title="Editar">
                    <i class="fas fa-edit"></i>
                </span>

                <span idElement="#formCurriculumGrid<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>" routeUpdate="/admin/gestao/grade-curricular/atualizar" toastData="Grade curricular atualizada" container="containerListCurriculumGrid" routeList="/admin/gestao/grade-curricular/lista" class="mr-2 update-data-icon" data-toggle="tooltip" data-placement="bottom" title="Atualizar">
                    <i class="fas fa-check"></i>
                </span>

            </div>
        </div>

        <div class="form-row mb-2 mt-3">

            <input type="hidden" name="curriculumGridId" value="<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>">
            <input type="hidden" name="disciplineId" value="<?= $this->view->curriculumGrid[0]->discipline_id ?>">

            <div class="form-group col-lg-5">
                <label for="">Nome da aula:</label>
                <input class="form-control" disabled value="<?= $this->view->curriculumGrid[0]->discipline_name ?>" type="text" name="disciplineName" id="">
            </div>

            <div class="form-group col-lg-2">
                <label for="">Sigla:</label>
                <input class="form-control" onkeyup="this.value = this.value.toUpperCase()" maxlength="10" disabled value="<?= $this->view->curriculumGrid[0]->acronym ?>" type="text" name="acronym" id="">
            </div>

            <div class="form-group col-lg-3">

                <label for="">Modalidade:</label>

                <select disabled name="modality" class="form-control custom-select" required>

                    <option value="<?= $this->view->curriculumGrid[0]->modality_id ?>"><?= $this->view->curriculumGrid[0]->discipline_modality ?></option>

                    <?php foreach ($this->view->listDisciplineModality as $key => $modality) { ?>

                        <?php if ($this->view->curriculumGrid[0]->modality_id != $modality->option_value) { ?>
                            <option value="<?= $modality->option_value ?>"><?= $modality->option_text ?></option>
                        <?php } ?>

                    <?php } ?>

                </select>

            </div>

            <div class="form-group col-lg-2">
                <label for="">Carga horária:</label>
                <input class="form-control" disabled value="<?= $this->view->curriculumGrid[0]->workload ?>" type="number" min="1" name="cargaHoraria" id="">
            </div>

        </div>

        <div class="form-row mb-2">

            <div class="form-group col-lg-12">
                <label for="">Observação:</label>
                <textarea class="form-control" disabled rows="2" name="observacaoGrade"><?= $this->view->curriculumGrid[0]->observation ?></textarea>
            </div>

        </div>

        <hr>

        <div class="form-row mb-2">

            <div class="col-lg-12">
                <label class="font-weight-bold">Anexos</label>
            </div>

            <div class="col-lg-12" containerAttachmentList>

                <?php if (count($this->view->listAttachment) >= 1) { ?>

                    <?php foreach ($this->view->listAttachment as $key => $attachment) { ?>

                        <div class="d-flex justify-content-between align-items-center mb-1" id="attachment<?= $attachment->attachment_id ?>">

                            <a href="/assets/uploads/gradeCurricular/<?= $attachment->file_name ?>" target="_blank"><i class="fas fa-paperclip mr-2"></i><?= $attachment->original_name ?></a>

                            <span attachmentId="<?= $attachment->attachment_id ?>" class="delete-attachment-icon text-danger" data-toggle="tooltip" data-placement="left" title="Remover">
                                <i class="fas fa-trash-alt"></i>
                            </span>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <p class="text-muted">Nenhum anexo adicionado</p>

                <?php } ?>

            </div>

            <div class="col-lg-9 mt-2">
                <input type="hidden" name="attachmentCurriculumGridId" value="<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>">
                <input class="form-control-file" type="file" name="anexos[]" id="inputNewAttachment<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>" multiple>
            </div>

            <div class="col-lg-3 mt-2">
                <a curriculumGridId="<?= $this->view->curriculumGrid[0]->curriculum_grid_id ?>" id="buttonAddAttachment" class="btn btn-success w-100 text-center" href="#">Anexar</a>
            </div>

        </div>

        <div class="form-row d-flex justify-content-end modal-links-alternativos mt-3 mb-3">

            <a class="btn main-button text-white" data-dismiss="modal" href="">Retornar a sessão</a>

        </div>

    </div>

</form>
