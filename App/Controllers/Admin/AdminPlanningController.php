<?php

namespace App\Controllers\Admin;

use MF\Controller\Action;
use MF\Model\Container;

class AdminPlanningController extends Action
{

    public function planningManagement()
    {

        $Planning = Container::getModel('GeneralManagement\\Planning');
        $ClassDiscipline = Container::getModel('GeneralManagement\\ClassDiscipline');

        $this->view->listPlanning = $Planning->readAll();
        $this->view->listAvailableSubjects = $ClassDiscipline->subjectsAvailablePlanning();

        $this->render('management/pages/planningManagement', 'AdminLayout');
    }


    public function planningInsert()
    {

        $Planning = Container::getModel('GeneralManagement\\Planning');
        $ClassDiscipline = Container::getModel('GeneralManagement\\ClassDiscipline');
        $ClasseWarning = Container::getModel('GeneralManagement\\ClasseWarning');

        $Planning->__set('fk_id_class_discipline', $_POST['classDisciplineAdd']);
        $Planning->__set('startDate', $_POST['startDate']);
        $Planning->__set('endDate', $_POST['endDate']);
        $Planning->__set('observationPlanning', $_POST['observationPlanning']);

        $Planning->insert();

        $ClassDiscipline->__set('classDisciplineId', $_POST['classDisciplineAdd']);
        $details = $ClassDiscipline->readDetails();

        if ($details) {

            $warning =

                'Você foi designado(a) para lecionar ' . $details->discipline_name .
                ' na turma ' . $details->acronym_series . $details->ballot . $details->course . ' - ' . $details->shift .
                ' de ' . date('d/m/Y', strtotime($_POST['startDate'])) . ' até ' . date('d/m/Y', strtotime($_POST['endDate']));

            $ClasseWarning->__set('warning', $warning);
            $ClasseWarning->__set('fk_id_discipline_class', $_POST['classDisciplineAdd']);

            $ClasseWarning->insert();
        }
    }


    public function planningList()
    {
        $Planning = Container::getModel('GeneralManagement\\Planning');
        $this->view->listPlanning = $Planning->readAll();
        $this->render('management/components/planningList', 'SimpleLayout');
    }


    public function planningUpdate()
    {

        $Planning = Container::getModel('GeneralManagement\\Planning');

        $Planning->__set('planningId', $_POST['planningId']);
        $Planning->__set('fk_id_class_discipline', $_POST['classDiscipline']);
        $Planning->__set('startDate', $_POST['startDate']);
        $Planning->__set('endDate', $_POST['endDate']);
        $Planning->__set('observationPlanning', $_POST['observationPlanning']);

        $Planning->update();
    }


    public function planningSeek()
    {

        $Planning = Container::getModel('GeneralManagement\\Planning');

        $Planning->__set('seekName', $_GET['seekName']);

        $this->view->listPlanning = $Planning->seek();

        $this->render('management/components/planningList', 'SimpleLayout');
    }


    public function planningData()
    {

        $Planning = Container::getModel('GeneralManagement\\Planning');
        $ClassDiscipline = Container::getModel('GeneralManagement\\ClassDiscipline');

        $Planning->__set('planningId', $_GET['id']);

        $this->view->planning = $Planning->dataGeneral();
        $this->view->listAvailableSubjects = $ClassDiscipline->subjectsAvailablePlanning();

        $this->render('management/components/planningModal', 'SimpleLayout');
    }


    public function planningDelete()
    {
        $Planning = Container::getModel('GeneralManagement\\Planning');
        $Planning->__set('planningId', $_POST['planningId']);
        $Planning->delete();
    }
}
