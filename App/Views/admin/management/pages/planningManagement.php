<section id="planning">

    <div class="row main-container">

        <div class="col-lg-11 mx-auto accordion" id="planning-accordion">

            <div class="row mt-3 page-header">

                <div class="col-11 col-lg-12 mx-auto">

                    <div class="row">

                        <h5 class="col-sm-6">Gestão do planejamento</h5>

                        <div class="col-sm-6">

                            <div class="row collapse-options-container">

                                <a class="font-weight-bold" id="collapseListPlanning" aria-expanded="true" data-toggle="collapse" data-target="#list-planning"><span class="mr-2"><i class="fas fa-grip-vertical mr-2"></i> Planejamento</span></a>

                                <a class="collapsed font-weight-bold" id="collapseAddPlanning" aria-expanded="false" data-toggle="collapse" data-target="#add-planning"><span class=""><i class="fas fa-plus mr-2"></i> Adicionar</span></a>

                            </div>

                        </div>

                        <nav class="col-lg-12 p-0" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin/gestao">Gestão geral</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Planejamento</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-11 mx-auto card mb-4">

                <div class="collapse show" id="list-planning" data-parent="#planning-accordion">

                    <form class="mb-3 mt-3 text-dark col-lg-11 mx-auto" id="seekPlanning" action="">

                        <div class="form-row">

                            <div class="form-group col-lg-12">
                                <label for="seekName">Professor, turma ou matéria:</label>
                                <input type="text" name="seekName" value="" id="seekName" placeholder="Buscar planejamento" class="form-control">
                            </div>

                        </div>

                    </form>

                    <hr class="col-10 mx-auto">

                    <div class="table-responsive">

                        <table class="table table-hover col-lg-11 mx-auto table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Professor</th>
                                    <th scope="col">Turma</th>
                                    <th scope="col">Matéria</th>
                                    <th scope="col">Início</th>
                                    <th scope="col">Fim</th>
                                </tr>
                            </thead>
                            <tbody containerListPlanning>
                                <?php require '../App/Views/admin/management/components/planningList.php' ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade simple-modal" id="modalPlanning" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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


                <div class="collapse" id="add-planning" data-parent="#planning-accordion">

                    <div class="row">

                        <div class="col-lg-12">

                            <form id="addPlanning" class="was-validated" action="">

                                <div class="font-weight-bold col-lg-11 mt-3">Adicionar novo planejamento</div>

                                <hr class="">

                                <div class="form-row mt-1 mb-2 col-lg-12">

                                    <div class="form-group col-lg-12">

                                        <label for="">Professor / Turma / Matéria:</label>

                                        <select name="classDisciplineAdd" class="form-control custom-select is-valid" required>

                                            <?php foreach ($this->view->listAvailableSubjects as $key => $subject) { ?>

                                                <option value="<?= $subject->option_value ?>"><?= $subject->option_text ?></option>

                                            <?php } ?>

                                        </select>

                                    </div>

                                </div>

                                <div class="form-row mb-2 col-lg-12">

                                    <div class="form-group col-lg-3">
                                        <label for="">Início:</label>
                                        <input class="form-control is-valid" value="" type="date" name="startDate" id="" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="">Fim:</label>
                                        <input class="form-control is-valid" value="" type="date" name="endDate" id="" required>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="">Observação:</label>
                                        <textarea class="form-control" rows="1" name="observationPlanning"></textarea>
                                    </div>

                                </div>

                                <div class="form-row d-flex justify-content-end col-lg-12 mb-3">

                                    <a id="buttonAddPlanning" class="btn btn-success text-center" href="#">Adicionar</a>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</section>
