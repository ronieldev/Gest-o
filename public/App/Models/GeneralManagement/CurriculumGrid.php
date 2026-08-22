<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class CurriculumGrid extends Model
{

    private $curriculumGridId;
    private $disciplineId;
    private $disciplineName;
    private $acronym;
    private $cargaHoraria;
    private $observacaoGrade;


    public function __get($att)
    {
        return $this->$att;
    }


    public function __set($att, $newValue)
    {
        return $this->$att = $newValue;
    }


    /**
     * Cria a disciplina correspondente e a grade curricular vinculada a ela
     *
     * @return int
     */
    public function insert()
    {

        $query = "INSERT INTO disciplina (nome_disciplina, sigla_disciplina, fk_id_modalidade_disciplina) VALUES (:disciplineName, :acronym, (SELECT id_modalidade_disciplina FROM modalidade_disciplina ORDER BY id_modalidade_disciplina LIMIT 1))";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineName", $this->__get("disciplineName"));
        $stmt->bindValue(":acronym", $this->__get("acronym"));

        $stmt->execute();

        $disciplineId = $this->db->lastInsertId();

        $query = "INSERT INTO grade_curricular (fk_id_disciplina, carga_horaria, observacao_grade) VALUES (:disciplineId, :cargaHoraria, :observacaoGrade)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineId", $disciplineId);
        $stmt->bindValue(":cargaHoraria", $this->__get("cargaHoraria"));
        $stmt->bindValue(":observacaoGrade", $this->__get("observacaoGrade"));

        $stmt->execute();

        return $this->db->lastInsertId();
    }


    /**
     * Retorna todas as grades curriculares cadastradas
     *
     * @return array
     */
    public function readAll()
    {

        return $this->speedingUp(

            "SELECT

            grade_curricular.id_grade_curricular AS curriculum_grid_id ,
            disciplina.id_disciplina AS discipline_id ,
            disciplina.nome_disciplina AS discipline_name ,
            disciplina.sigla_disciplina AS acronym ,
            grade_curricular.carga_horaria AS workload ,
            grade_curricular.observacao_grade AS observation ,
            (SELECT COUNT(*) FROM grade_curricular_anexo WHERE grade_curricular_anexo.fk_id_grade_curricular = grade_curricular.id_grade_curricular) AS total_attachment

            FROM grade_curricular

            INNER JOIN disciplina ON(grade_curricular.fk_id_disciplina = disciplina.id_disciplina)

            ORDER BY disciplina.nome_disciplina ASC"

        );
    }


    /**
     * Retorna os dados gerais de uma grade curricular
     *
     * @return array
     */
    public function dataGeneral()
    {

        $query =

            "SELECT

            grade_curricular.id_grade_curricular AS curriculum_grid_id ,
            disciplina.id_disciplina AS discipline_id ,
            disciplina.nome_disciplina AS discipline_name ,
            disciplina.sigla_disciplina AS acronym ,
            grade_curricular.carga_horaria AS workload ,
            grade_curricular.observacao_grade AS observation

            FROM grade_curricular

            INNER JOIN disciplina ON(grade_curricular.fk_id_disciplina = disciplina.id_disciplina)

            WHERE grade_curricular.id_grade_curricular = :curriculumGridId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":curriculumGridId", $this->__get("curriculumGridId"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Retorna os anexos vinculados a uma grade curricular
     *
     * @return array
     */
    public function listAttachment()
    {

        $query = "SELECT id_anexo AS attachment_id, nome_original_arquivo AS original_name, nome_arquivo AS file_name FROM grade_curricular_anexo WHERE fk_id_grade_curricular = :curriculumGridId ORDER BY data_upload DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":curriculumGridId", $this->__get("curriculumGridId"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Atualiza os dados da disciplina e da grade curricular vinculada
     *
     * @return void
     */
    public function update()
    {

        $query = "UPDATE disciplina SET nome_disciplina = :disciplineName, sigla_disciplina = :acronym WHERE disciplina.id_disciplina = :disciplineId";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineId", $this->__get("disciplineId"));
        $stmt->bindValue(":disciplineName", $this->__get("disciplineName"));
        $stmt->bindValue(":acronym", $this->__get("acronym"));

        $stmt->execute();

        $query = "UPDATE grade_curricular SET carga_horaria = :cargaHoraria, observacao_grade = :observacaoGrade WHERE grade_curricular.id_grade_curricular = :curriculumGridId";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":curriculumGridId", $this->__get("curriculumGridId"));
        $stmt->bindValue(":cargaHoraria", $this->__get("cargaHoraria"));
        $stmt->bindValue(":observacaoGrade", $this->__get("observacaoGrade"));

        $stmt->execute();
    }


    /**
     * Cadastra um anexo vinculado a uma grade curricular
     *
     * @return void
     */
    public function insertAttachment($originalName, $fileName)
    {

        $query = "INSERT INTO grade_curricular_anexo (fk_id_grade_curricular, nome_original_arquivo, nome_arquivo) VALUES (:curriculumGridId, :originalName, :fileName)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":curriculumGridId", $this->__get("curriculumGridId"));
        $stmt->bindValue(":originalName", $originalName);
        $stmt->bindValue(":fileName", $fileName);

        $stmt->execute();
    }


    /**
     * Deleta um anexo vinculado a uma grade curricular
     *
     * @return void
     */
    public function deleteAttachment($attachmentId)
    {

        $query = "DELETE FROM grade_curricular_anexo WHERE grade_curricular_anexo.id_anexo = :attachmentId";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":attachmentId", $attachmentId);
        $stmt->execute();
    }


    /**
     * Retorna um anexo específico (usado para localizar o arquivo físico antes de excluir)
     *
     * @return array
     */
    public function attachmentData($attachmentId)
    {

        $query = "SELECT id_anexo AS attachment_id, nome_arquivo AS file_name FROM grade_curricular_anexo WHERE id_anexo = :attachmentId";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":attachmentId", $attachmentId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Busca grades curriculares por nome da disciplina
     *
     * @return array
     */
    public function seek()
    {

        $query =

            "SELECT

            grade_curricular.id_grade_curricular AS curriculum_grid_id ,
            disciplina.id_disciplina AS discipline_id ,
            disciplina.nome_disciplina AS discipline_name ,
            disciplina.sigla_disciplina AS acronym ,
            grade_curricular.carga_horaria AS workload ,
            grade_curricular.observacao_grade AS observation ,
            (SELECT COUNT(*) FROM grade_curricular_anexo WHERE grade_curricular_anexo.fk_id_grade_curricular = grade_curricular.id_grade_curricular) AS total_attachment

            FROM grade_curricular

            INNER JOIN disciplina ON(grade_curricular.fk_id_disciplina = disciplina.id_disciplina)

            WHERE disciplina.nome_disciplina LIKE :disciplineName

            ORDER BY disciplina.nome_disciplina ASC
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineName", "%" . $this->__get("disciplineName") . "%", \PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Deleta uma grade curricular. A disciplina vinculada permanece intacta, pois pode já estar em uso em turmas.
     *
     * @return void
     */
    public function delete()
    {

        $query = "DELETE FROM grade_curricular WHERE grade_curricular.id_grade_curricular = :curriculumGridId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":curriculumGridId", $this->__get("curriculumGridId"));
        $stmt->execute();
    }
}
