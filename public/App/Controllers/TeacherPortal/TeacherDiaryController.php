<?php

namespace App\Controllers\TeacherPortal;

use MF\Controller\Action;
use MF\Model\Container;

class TeacherDiaryController extends Action
{

    private $allowedMimeTypes = [

        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'

    ];


    public function diaryManagement()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('fk_id_class', 0);

        $this->view->listDiary = $Diary->readAll();
        $this->view->listAvailableClassDiscipline = $Diary->availableClassDiscipline();

        $this->render('management/pages/diaryManagement', 'TeacherPortalLayout', 'teacherPortal');
    }


    public function diaryInsert()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('fk_id_class_discipline', $_POST['classDisciplineAdd']);
        $Diary->__set('classDate', $_POST['classDate']);
        $Diary->__set('content', $_POST['content']);
        $Diary->__set('observationDiary', $_POST['observationDiary']);

        $diaryId = $Diary->insert();

        if ($diaryId === false) {

            http_response_code(403);
            return;
        }

        $Diary->__set('diaryId', $diaryId);

        $this->uploadAttachment($Diary);
    }


    public function diaryList()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('fk_id_class', $_GET['classFilter'] ?? 0);

        $this->view->listDiary = $Diary->readAll();

        $this->render('management/components/diaryList', 'SimpleLayout', 'teacherPortal');
    }


    public function diaryContentSuggestion()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('fk_id_class_discipline', $_GET['classDiscipline']);

        echo json_encode($Diary->contentSuggestion());
    }


    public function diaryData()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('diaryId', $_GET['id']);

        $this->view->diary = $Diary->dataGeneral();
        $this->view->listAttachment = $Diary->listAttachment();

        $this->render('management/components/diaryModal', 'SimpleLayout', 'teacherPortal');
    }


    public function diaryUpdate()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('diaryId', $_POST['diaryId']);
        $Diary->__set('classDate', $_POST['classDate']);
        $Diary->__set('content', $_POST['content']);
        $Diary->__set('observationDiary', $_POST['observationDiary']);

        $Diary->update();
    }


    public function diaryDelete()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('diaryId', $_POST['diaryId']);

        $Diary->delete();
    }


    public function diaryAttachmentInsert()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);
        $Diary->__set('diaryId', $_POST['diaryId']);

        $this->uploadAttachment($Diary);
    }


    public function diaryAttachmentDelete()
    {

        $Diary = Container::getModel('GeneralManagement\\Diary');

        if (!isset($_SESSION)) session_start();

        $Diary->__set('fk_id_teacher', $_SESSION['Teacher']['id']);

        $attachment = $Diary->attachmentData($_POST['attachmentId']);

        if (count($attachment) == 1) {

            $filePath = 'assets/uploads/diarioProfessor/' . $attachment[0]->file_name;

            if (file_exists($filePath)) unlink($filePath);

            $Diary->deleteAttachment($_POST['attachmentId']);
        }
    }


    private function uploadAttachment($Diary)
    {

        if (!isset($_FILES['anexos']) || empty($_FILES['anexos']['name'][0])) return;

        $dir = 'assets/uploads/diarioProfessor/';

        foreach ($_FILES['anexos']['name'] as $key => $originalName) {

            if ($_FILES['anexos']['error'][$key] != 0) continue;

            $tmpName = $_FILES['anexos']['tmp_name'][$key];
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            if (!array_key_exists($ext, $this->allowedMimeTypes)) continue;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $realMimeType = finfo_file($finfo, $tmpName);
            finfo_close($finfo);

            if ($realMimeType !== $this->allowedMimeTypes[$ext]) continue;

            $newName = uniqid(time()) . '.' . $ext;

            move_uploaded_file($tmpName, $dir . $newName);

            $Diary->insertAttachment($originalName, $newName);
        }
    }
}
