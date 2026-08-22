

<form id="formDiscipline<?= $this->view->discipline[0]->discipline_id ?>" class="col-lg-11 mx-auto mb-4" action="">

        <div class="col-lg-12">

            <div class="row modal-header d-flex justify-content-between">
                <h5 discipline class="col-lg-6 font-weight-bold pl-0"><?= $this->view->discipline[0]->discipline_name ?></h5>
                <div class="col-lg-6 d-flex justify-content-end pr-0">

                    <span idElement="#formDiscipline<?= $this->view->discipline[0]->discipline_id ?>" class="mr-2 edit-data-icon" data-toggle="tooltip" data-placement="left" title="Editar">
                        <i class="fas fa-edit"></i>
                    </span>

                    <span  idElement="#formDiscipline<?= $this->view->discipline[0]->discipline_id ?>" routeUpdate="/admin/gestao/disciplina/atualizar" toastData="Disciplina Atualizada" container="containerListDiscipline" routeList="/admin/gestao/disciplina/lista" class="mr-2 update-data-icon" data-toggle="tooltip" data-placement="bottom" title="Atualizar">
                        <i class="fas fa-check"></i>
                    </span>

                    </div>
                </div>              
               

                <div class="form-row mb-2 mt-3">

                <input type="hidden" name="disciplineId" value="<?= $this->view->discipline[0]->discipline_id ?>">

                    <div class="form-group col-lg-8">
                        <label for="">Nome da disciplina:</label>
                        <input class="form-control" disabled value="<?= $this->view->discipline[0]->discipline_name ?>" type="text" name="disciplineName" id="">
                    </div>

                    <div class="form-group col-lg-4">
                        <label for="">Sigla:</label>
                        <input class="form-control" onkeyup="this.value = this.value.toUpperCase()" maxlength="4" disabled value="<?= $this->view->discipline[0]->acronym ?>" type="text" name="acronym" id="">
                    </div>

                </div>

                <div class="form-row d-flex justify-content-end modal-links-alternativos mt-3 mb-3">

                <a class="btn main-button text-white" data-dismiss="modal" href="">Retornar a sessão</a>

            </div>
                
</form> 

