<?php

$current_label = $this->view->diary[0]->acronym_series . $this->view->diary[0]->ballot . $this->view->diary[0]->course . ' - ' . $this->view->diary[0]->shift;

?>

<form id="formDiary<?= $this->view->diary[0]->diary_id ?>" class="col-lg-11 mx-auto mb-4" action="">

    <div class="col-lg-12">

        <div class="row modal-header d-flex justify-content-between">
            <h5 discipline class="col-lg-8 font-weight-bold pl-0"><?= $this->view->diary[0]->discipline_name ?></h5>
            <div class="col-lg-4 d-flex justify-content-end pr-0">

                <span idElement="#formDiary<?= $this->view->diary[0]->diary_id ?>" class="mr-2 edit-data-icon" data-toggle="tooltip" data-placement="left" title="Editar">
                    <i class="fas fa-edit"></i>
                </span>

                <span idElement="#formDiary<?= $this->view->diary[0]->diary_id ?>" routeUpdate="/portal-docente/diario/atualizar" toastData="Lançamento atualizado" container="containerListDiary" routeList="/portal-docente/diario/lista" class="mr-2 update-data-icon" data-toggle="tooltip" data-placement="top" title="Atualizar">
                    <i class="fas fa-check"></i>
                </span>

                <span idElement="#formDiary<?= $this->view->diary[0]->diary_id ?>" routeDelete="/portal-docente/diario/deletar" toastData="Lançamento deletado" container="containerListDiary" routeList="/portal-docente/diario/lista" class="mr-2 delete-data-icon" data-toggle="tooltip" data-placement="right" title="Deletar">
                    <i class="fas fa-trash-alt"></i>
                </span>

            </div>
        </div>

        <div class="form-row mb-2 mt-3">

            <input type="hidden" name="diaryId" value="<?= $this->view->diary[0]->diary_id ?>">

            <div class="form-group col-lg-8">
                <label for="">Turma:</label>
                <input class="form-control" disabled readonly value="<?= $current_label ?>" type="text" id="">
            </div>

            <div class="form-group col-lg-4">
                <label for="">Data da aula:</label>
                <input class="form-control" disabled value="<?= $this->view->diary[0]->class_date ?>" type="date" name="classDate" id="">
            </div>

        </div>

        <div class="form-row mb-2">

            <div class="form-group col-lg-6">
                <label for="">Conteúdo:</label>
                <textarea class="form-control" disabled rows="3" name="content"><?= $this->view->diary[0]->content ?></textarea>
            </div>

            <div class="form-group col-lg-6">
                <label for="">Observações:</label>
                <textarea class="form-control" disabled rows="3" name="observationDiary"><?= $this->view->diary[0]->observation ?></textarea>
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

                            <a href="/assets/uploads/diarioProfessor/<?= $attachment->file_name ?>" target="_blank"><i class="fas fa-paperclip mr-2"></i><?= $attachment->original_name ?></a>

                            <span attachmentId="<?= $attachment->attachment_id ?>" class="delete-diary-attachment-icon text-danger" data-toggle="tooltip" data-placement="left" title="Remover">
                                <i class="fas fa-trash-alt"></i>
                            </span>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <p class="text-muted">Nenhum anexo adicionado</p>

                <?php } ?>

            </div>

            <div class="col-lg-9 mt-2">
                <input class="form-control-file" type="file" name="anexos[]" accept=".jpg,.jpeg,.png,.pdf" id="inputNewDiaryAttachment<?= $this->view->diary[0]->diary_id ?>" multiple>
            </div>

            <div class="col-lg-3 mt-2">
                <a diaryId="<?= $this->view->diary[0]->diary_id ?>" id="buttonAddDiaryAttachment" class="btn btn-success w-100 text-center" href="#">Anexar</a>
            </div>

        </div>

        <div class="form-row d-flex justify-content-end modal-links-alternativos mt-3 mb-3">

            <a class="btn main-button text-white" data-dismiss="modal" href="">Retornar a sessão</a>

        </div>

    </div>

</form>
