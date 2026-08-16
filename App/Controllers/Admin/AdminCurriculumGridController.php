<?php

namespace App\Controllers\Admin;

use MF\Controller\Action;
use MF\Model\Container;

class AdminCurriculumGridController extends Action
{

    public function curriculumGridManagement()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $this->view->listCurriculumGrid = $CurriculumGrid->readAll();
        $this->view->listModality = $CurriculumGrid->disciplineModality();

        $this->render('management/pages/curriculumGridManagement', 'AdminLayout');
    }


    public function curriculumGridInsert()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $CurriculumGrid->__set('disciplineName', $_POST['disciplineName']);
        $CurriculumGrid->__set('acronym', $_POST['acronym']);
        $CurriculumGrid->__set('fk_id_modality', $_POST['modalityAdd']);
        $CurriculumGrid->__set('cargaHoraria', $_POST['cargaHoraria']);
        $CurriculumGrid->__set('observacaoGrade', $_POST['observacaoGrade']);

        $curriculumGridId = $CurriculumGrid->insert();

        $CurriculumGrid->__set('curriculumGridId', $curriculumGridId);

        $this->uploadAttachment($CurriculumGrid);
    }


    public function curriculumGridList()
    {
        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');
        $this->view->listCurriculumGrid = $CurriculumGrid->readAll();
        $this->render('management/components/curriculumGridList', 'SimpleLayout');
    }


    public function curriculumGridUpdate()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $CurriculumGrid->__set('curriculumGridId', $_POST['curriculumGridId']);
        $CurriculumGrid->__set('disciplineId', $_POST['disciplineId']);
        $CurriculumGrid->__set('disciplineName', $_POST['disciplineName']);
        $CurriculumGrid->__set('acronym', $_POST['acronym']);
        $CurriculumGrid->__set('fk_id_modality', $_POST['modality']);
        $CurriculumGrid->__set('cargaHoraria', $_POST['cargaHoraria']);
        $CurriculumGrid->__set('observacaoGrade', $_POST['observacaoGrade']);

        $CurriculumGrid->update();

        $this->uploadAttachment($CurriculumGrid);
    }


    public function curriculumGridSeek()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $CurriculumGrid->__set('disciplineName', $_GET['seekName']);
        $CurriculumGrid->__set('fk_id_modality', $_GET['seekModality']);

        $this->view->listCurriculumGrid = $CurriculumGrid->seek();

        $this->render('management/components/curriculumGridList', 'SimpleLayout');
    }


    public function curriculumGridData()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $CurriculumGrid->__set('curriculumGridId', $_GET['id']);

        $this->view->curriculumGrid = $CurriculumGrid->dataGeneral();
        $this->view->listAttachment = $CurriculumGrid->listAttachment();
        $this->view->listDisciplineModality = $CurriculumGrid->disciplineModality();

        $this->render('management/components/curriculumGridModal', 'SimpleLayout');
    }


    public function curriculumGridDelete()
    {
        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');
        $CurriculumGrid->__set('curriculumGridId', $_POST['curriculumGridId']);
        $CurriculumGrid->delete();
    }


    public function curriculumGridAttachmentInsert()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $CurriculumGrid->__set('curriculumGridId', $_POST['curriculumGridId']);

        $this->uploadAttachment($CurriculumGrid);
    }


    public function curriculumGridAttachmentDelete()
    {

        $CurriculumGrid = Container::getModel('GeneralManagement\\CurriculumGrid');

        $attachment = $CurriculumGrid->attachmentData($_POST['attachmentId']);

        if (count($attachment) == 1) {

            $filePath = '../public/assets/uploads/gradeCurricular/' . $attachment[0]->file_name;

            if (file_exists($filePath)) unlink($filePath);
        }

        $CurriculumGrid->deleteAttachment($_POST['attachmentId']);
    }


    private function uploadAttachment($CurriculumGrid)
    {

        if (!isset($_FILES['anexos']) || empty($_FILES['anexos']['name'][0])) return;

        $dir = '../public/assets/uploads/gradeCurricular/';

        foreach ($_FILES['anexos']['name'] as $key => $originalName) {

            if ($_FILES['anexos']['error'][$key] != 0) continue;

            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $newName = uniqid(time()) . '.' . $ext;

            move_uploaded_file($_FILES['anexos']['tmp_name'][$key], $dir . $newName);

            $CurriculumGrid->insertAttachment($originalName, $newName);
        }
    }
}
