<section id="diary">

    <div class="row main-container">

        <div class="col-lg-11 mx-auto accordion" id="diary-accordion">

            <div class="row mt-3 page-header">

                <div class="col-11 col-lg-12 mx-auto">

                    <div class="row">

                        <h5 class="col-sm-6">Diário eletrônico</h5>

                        <div class="col-sm-6">

                            <div class="row collapse-options-container">

                                <a class="font-weight-bold" id="collapseListDiary" aria-expanded="true" data-toggle="collapse" data-target="#list-diary"><span class="mr-2"><i class="fas fa-grip-vertical mr-2"></i> Lançamentos</span></a>

                                <a class="collapsed font-weight-bold" id="collapseAddDiary" aria-expanded="false" data-toggle="collapse" data-target="#add-diary"><span class=""><i class="fas fa-plus mr-2"></i> Lançar aula</span></a>

                            </div>

                        </div>

                        <nav class="col-lg-12 p-0" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/portal-docente/home">Portal do docente</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Diário eletrônico</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-11 mx-auto card mb-4">

                <div class="collapse show" id="list-diary" data-parent="#diary-accordion">

                    <div class="table-responsive mt-3">

                        <table class="table table-hover col-lg-11 mx-auto table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Turma</th>
                                    <th scope="col">Disciplina</th>
                                    <th scope="col">Conteúdo</th>
                                    <th scope="col">Anexos</th>
                                </tr>
                            </thead>
                            <tbody containerListDiary>
                                <?php require 'App/Views/teacherPortal/management/components/diaryList.php' ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade simple-modal" id="modalDiary" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg mt-5">
                            <div class="modal-content">
                                <div class="row">
                                    <div class="col-lg-12"> <button type="button" class="close text-rig" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true"><i class="fas fa-times-circle text-info mr-3 mt-2"></i></span>
                                        </button></div>
                                </div>
                                <div class="modal-body">
                                    <div containerModal class="row"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="collapse" id="add-diary" data-parent="#diary-accordion">

                    <div class="row">

                        <div class="col-lg-12">

                            <form id="addDiary" class="was-validated" action="" enctype="multipart/form-data">

                                <div class="font-weight-bold col-lg-11 mt-3">Lançar aula no diário</div>

                                <hr class="">

                                <div class="form-row mt-1 mb-2 col-lg-12">

                                    <div class="form-group col-lg-8">

                                        <label for="">Turma:</label>

                                        <select name="classDisciplineAdd" id="classDisciplineAdd" class="form-control custom-select is-valid" required>

                                            <option value="" disabled selected>Selecione a turma</option>

                                            <?php foreach ($this->view->listAvailableClassDiscipline as $key => $classDiscipline) { ?>

                                                <option value="<?= $classDiscipline->option_value ?>"><?= $classDiscipline->option_text ?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="">Data da aula:</label>
                                        <input class="form-control is-valid" value="" type="date" name="classDate" id="" required>
                                    </div>

                                </div>

                                <div class="form-row mb-2 col-lg-12">

                                    <div class="form-group col-lg-6">
                                        <label for="">Conteúdo:</label>
                                        <textarea class="form-control" id="content" rows="3" name="content" placeholder="Selecione a turma para sugestão automática com base na grade curricular" required></textarea>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="">Observações:</label>
                                        <textarea class="form-control" rows="3" name="observationDiary"></textarea>
                                    </div>

                                </div>

                                <div class="form-row mb-2 col-lg-12">

                                    <div class="form-group col-lg-12">
                                        <label for="">Anexar fotos ou PDF:</label>
                                        <input class="form-control-file" type="file" name="anexos[]" accept=".jpg,.jpeg,.png,.pdf" multiple>
                                    </div>

                                </div>

                                <div class="form-row d-flex justify-content-end col-lg-12 mb-3">

                                    <a id="buttonAddDiary" class="btn btn-success text-center" href="#">Lançar</a>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</section>
