<section id="finance-management">

    <div class="row main-container">

        <div class="col-lg-11 mx-auto accordion" id="finance-accordion">

            <div class="row mt-3 page-header">

                <div class="col-11 col-lg-12 mx-auto">

                    <div class="row">

                        <h5 class="col-sm-6">Financeiro</h5>

                        <div class="col-sm-6">

                            <div class="row collapse-options-container">

                                <a class="font-weight-bold" id="collapseListFinance" aria-expanded="true" data-toggle="collapse" data-target="#list-finance"><span class="mr-2"><i class="fas fa-file-invoice-dollar mr-2"></i> Cobranças</span></a>

                                <a class="collapsed font-weight-bold" id="collapseAddFinance" aria-expanded="false" data-toggle="collapse" data-target="#add-finance"><span class=""><i class="fas fa-plus mr-2"></i> Gerar cobrança avulsa</span></a>

                            </div>

                        </div>

                        <nav class="col-lg-12 p-0" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Financeiro</li>
                            </ol>
                        </nav>

                    </div>
                </div>
            </div>

            <div class="row col-lg-12 mx-auto mb-3">

                <div class="col-lg-4">
                    <div class="card p-3">
                        <span class="text-muted">Pendente</span>
                        <strong class="text-warning">R$ <?= number_format($this->view->totals->total_pending, 2, ',', '.') ?></strong>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card p-3">
                        <span class="text-muted">Recebido no mês</span>
                        <strong class="text-success">R$ <?= number_format($this->view->totals->total_paid_month, 2, ',', '.') ?></strong>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card p-3">
                        <span class="text-muted">Vencido</span>
                        <strong class="text-danger">R$ <?= number_format($this->view->totals->total_overdue, 2, ',', '.') ?></strong>
                    </div>
                </div>

            </div>

            <div class="col-lg-12 col-11 mx-auto card mb-4">

                <div class="collapse show" id="list-finance" data-parent="#finance-accordion">

                    <div class="table-responsive">

                        <table class="table table-hover col-lg-11 mx-auto table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Aluno</th>
                                    <th scope="col">Responsável</th>
                                    <th scope="col">Competência</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Vencimento</th>
                                    <th scope="col">Situação</th>
                                </tr>
                            </thead>
                            <tbody containerListFinance>
                                <?php require 'App/Views/admin/finance/components/financeList.php' ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade simple-modal" id="modalFinance" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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


                <div class="collapse" id="add-finance" data-parent="#finance-accordion">

                    <div class="row">

                        <div class="col-lg-12">

                            <form id="addFinance" class="was-validated" action="">

                                <div class="font-weight-bold col-lg-11 mt-3">Gerar cobrança avulsa</div>

                                <hr class="">

                                <div class="form-row mt-1 mb-2 col-lg-12">

                                    <div class="form-group col-lg-4">
                                        <label for="">Aluno:</label>
                                        <select class="form-control is-valid" name="student" required>
                                            <option value="">Selecione</option>
                                            <?php foreach ($this->view->availableStudents as $student) { ?>
                                                <option value="<?= $student->option_value ?>"><?= $student->option_text ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="">Competência:</label>
                                        <input class="form-control is-valid" value="" type="date" name="competency" required>
                                    </div>

                                    <div class="form-group col-lg-2">
                                        <label for="">Valor (R$):</label>
                                        <input class="form-control is-valid" value="" type="number" step="0.01" min="0" name="amount" required>
                                    </div>

                                    <div class="form-group col-lg-3">
                                        <label for="">Vencimento:</label>
                                        <input class="form-control is-valid" value="" type="date" name="dueDate" required>
                                    </div>

                                </div>

                                <?php if (count($this->view->availableStudents) == 0) { ?>
                                    <p class="col-lg-11 text-muted">Nenhum aluno com responsável financeiro cadastrado. Cadastre o responsável no perfil do aluno antes de gerar uma cobrança.</p>
                                <?php } ?>

                                <div class="form-row d-flex justify-content-end col-lg-12 mb-3">

                                    <a id="buttonAddFinance" class="btn btn-success text-center" href="#">Gerar cobrança</a>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


</section>
