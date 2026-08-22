<section id="curriculum-grid">

    <div class="row main-container">

        <div class="col-lg-11 mx-auto accordion" id="curriculum-grid-accordion">

            <div class="row mt-3 page-header">

                <div class="col-11 col-lg-12 mx-auto">

                    <div class="row">

                        <h5 class="col-sm-6">Gestão da grade curricular</h5>

                        <div class="col-sm-6">

                            <div class="row collapse-options-container">

                                <a class="font-weight-bold" id="collapseListCurriculumGrid" aria-expanded="true" data-toggle="collapse" data-target="#list-curriculum-grid"><span class="mr-2"><i class="fas fa-grip-vertical mr-2"></i> Grade curricular</span></a>

                                <a class="collapsed font-weight-bold" id="collapseAddCurriculumGrid" aria-expanded="false" data-toggle="collapse" data-target="#add-curriculum-grid"><span class=""><i class="fas fa-plus mr-2"></i> Adicionar</span></a>

                            </div>

                        </div>

                        <nav class="col-lg-12 p-0" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/admin/gestao">Gestão geral</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Grade curricular</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-11 mx-auto card mb-4">

                <div class="collapse show" id="list-curriculum-grid" data-parent="#curriculum-grid-accordion">

                    <form class="mb-3 mt-3 text-dark col-lg-11 mx-auto" id="seekCurriculumGrid" action="">

                        <div class="form-row">

                            <div class="form-group col-lg-12">
                                <label for="seekName">Nome da aula:</label>
                                <input type="text" name="seekName" value="" id="seekName" placeholder="Nome da aula" class="form-control">
                            </div>

                        </div>

                    </form>

                    <hr class="col-10 mx-auto">

                    <div class="table-responsive">

                        <table class="table table-hover col-lg-11 mx-auto table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Nome da aula</th>
                                    <th scope="col">Sigla</th>
                                    <th scope="col">Carga horária</th>
                                    <th scope="col">Anexos</th>
                                </tr>
                            </thead>
                            <tbody containerListCurriculumGrid>
                                <?php require 'App/Views/admin/management/components/curriculumGridList.php' ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade simple-modal" id="modalCurriculumGrid" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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


                <div class="collapse" id="add-curriculum-grid" data-parent="#curriculum-grid-accordion">

                    <div class="row">

                        <div class="col-lg-12">

                            <form id="addCurriculumGrid" class="was-validated" action="" enctype="multipart/form-data">

                                <div class="font-weight-bold col-lg-11 mt-3">Adicionar nova aula na grade curricular</div>

                                <hr class="">

                                <div class="form-row mt-1 mb-2 col-lg-12">

                                    <div class="form-group col-lg-5">
                                        <label for="">Nome da aula:</label>
                                        <input class="form-control is-valid" value="" type="text" name="disciplineName" id="" placeholder="Ex: Classroom Vocabulary" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="">Sigla:</label>
                                        <input class="form-control is-valid" maxlength="10" value="" type="text" name="acronym" id="" required>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="">Carga horária (horas):</label>
                                        <input class="form-control is-valid" value="" type="number" min="1" name="cargaHoraria" id="" required>
                                    </div>

                                </div>

                                <div class="form-row mb-2 col-lg-12">

                                    <div class="form-group col-lg-8">
                                        <label for="">Observação:</label>
                                        <textarea class="form-control" rows="2" name="observacaoGrade"></textarea>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="">Anexos:</label>
                                        <input class="form-control-file" type="file" name="anexos[]" multiple>
                                    </div>

                                </div>

                                <div class="form-row d-flex justify-content-end col-lg-12 mb-3">

                                    <a id="buttonAddCurriculumGrid" class="btn btn-success text-center" href="#">Adicionar</a>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</section>
