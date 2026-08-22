<?php

namespace App\Controllers\Admin;

use MF\Controller\Action;
use MF\Model\Container;

class AdminFinanceController extends Action
{

    public function financeManagement()
    {

        $Cobranca = Container::getModel('GeneralManagement\\Cobranca');

        $this->view->listCobranca = $Cobranca->list();
        $this->view->totals = $Cobranca->totals()[0];
        $this->view->availableStudents = $Cobranca->availableStudents();

        $this->render('finance/pages/financeManagement', 'AdminLayout');
    }


    public function financeInsert()
    {

        $Cobranca = Container::getModel('GeneralManagement\\Cobranca');

        $Cobranca->__set('fk_id_student', $_POST['student']);
        $Cobranca->__set('competency', $_POST['competency']);
        $Cobranca->__set('amount', $_POST['amount']);
        $Cobranca->__set('dueDate', $_POST['dueDate']);

        $Cobranca->insert();
    }


    public function financeList()
    {

        $Cobranca = Container::getModel('GeneralManagement\\Cobranca');

        $this->view->listCobranca = $Cobranca->list();

        $this->render('finance/components/financeList', 'SimpleLayout');
    }


    public function financeData()
    {

        $Cobranca = Container::getModel('GeneralManagement\\Cobranca');

        $Cobranca->__set('chargeId', $_GET['id']);

        $this->view->cobranca = $Cobranca->data();

        $this->render('finance/components/financeModal', 'SimpleLayout');
    }


    public function financeMarkAsPaid()
    {

        $Cobranca = Container::getModel('GeneralManagement\\Cobranca');

        $Cobranca->__set('chargeId', $_POST['chargeId']);

        $Cobranca->markAsPaid();
    }


    public function availableStudents()
    {

        $Cobranca = Container::getModel('GeneralManagement\\Cobranca');

        echo json_encode($Cobranca->availableStudents());
    }
}
