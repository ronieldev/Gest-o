<?php $cobranca = $this->view->cobranca[0]; ?>

<form id="formCobranca<?= $cobranca->charge_id ?>" class="col-lg-11 mx-auto mb-4" action="">

    <div class="col-lg-12">

        <div class="row modal-header d-flex justify-content-between">
            <h5 class="col-lg-8 font-weight-bold pl-0"><?= $cobranca->student_name ?></h5>
        </div>

        <div class="form-row mb-2 mt-3">

            <div class="form-group col-lg-6">
                <label>Responsável financeiro:</label>
                <input class="form-control" disabled value="<?= $cobranca->responsible_name ?? '-' ?>" type="text">
            </div>

            <div class="form-group col-lg-6">
                <label>E-mail do responsável:</label>
                <input class="form-control" disabled value="<?= $cobranca->responsible_email ?? '-' ?>" type="text">
            </div>

        </div>

        <div class="form-row mb-2">

            <div class="form-group col-lg-3">
                <label>Competência:</label>
                <input class="form-control" disabled value="<?= date('m/Y', strtotime($cobranca->competency)) ?>" type="text">
            </div>

            <div class="form-group col-lg-3">
                <label>Valor:</label>
                <input class="form-control" disabled value="R$ <?= number_format($cobranca->amount, 2, ',', '.') ?>" type="text">
            </div>

            <div class="form-group col-lg-3">
                <label>Vencimento:</label>
                <input class="form-control" disabled value="<?= date('d/m/Y', strtotime($cobranca->due_date)) ?>" type="text">
            </div>

            <div class="form-group col-lg-3">
                <label>Situação:</label>
                <input class="form-control" disabled value="<?= $cobranca->situation_name ?>" type="text">
            </div>

        </div>

        <?php if ($cobranca->payment_link) { ?>
            <div class="form-row mb-2">
                <div class="col-lg-12">
                    <a href="<?= $cobranca->payment_link ?>" target="_blank">Ver fatura no Asaas</a>
                </div>
            </div>
        <?php } ?>

        <input type="hidden" name="chargeId" value="<?= $cobranca->charge_id ?>">

        <div class="form-row d-flex justify-content-end modal-links-alternativos mt-3 mb-3">

            <?php if ($cobranca->situation_name == 'Pendente') { ?>
                <a idElement="#formCobranca<?= $cobranca->charge_id ?>" id="buttonMarkAsPaid" class="btn btn-success mr-2" href="#">Marcar como pago</a>
            <?php } ?>

            <a class="btn main-button text-white" data-dismiss="modal" href="">Retornar a sessão</a>

        </div>

    </div>

</form>
