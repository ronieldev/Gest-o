<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class Diary extends Model
{

    private $diaryId;
    private $fk_id_class_discipline;
    private $classDate;
    private $content;
    private $observationDiary;
    private $fk_id_teacher;
    private $fk_id_class;


    public function __get($att)
    {
        return $this->$att;
    }


    public function __set($att, $newValue)
    {
        return $this->$att = $newValue;
    }


    /**
     * Cria um lançamento no diário do professor. A inserção só ocorre se a turma/disciplina
     * informada realmente pertencer ao professor logado (evita lançar diário em turma alheia).
     *
     * @return int|false
     */
    public function insert()
    {

        $query =

            "INSERT INTO diario_professor (fk_id_turma_disciplina, data_aula, conteudo, observacao_diario)

            SELECT turma_disciplina.id_turma_disciplina, :classDate, :content, :observationDiary

            FROM turma_disciplina

            WHERE turma_disciplina.id_turma_disciplina = :fk_id_class_discipline

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":fk_id_class_discipline", $this->__get("fk_id_class_discipline"));
        $stmt->bindValue(":classDate", $this->__get("classDate"));
        $stmt->bindValue(":content", $this->__get("content"));
        $stmt->bindValue(":observationDiary", $this->__get("observationDiary"));
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));

        $stmt->execute();

        if ($stmt->rowCount() === 0) return false;

        return $this->db->lastInsertId();
    }


    /**
     * Retorna as turmas/disciplinas do professor logado, restritas ao período letivo ativo,
     * usadas para preencher a tag select de turma na View
     *
     * @return array
     */
    public function availableClassDiscipline()
    {

        $query =

            "SELECT

            turma_disciplina.id_turma_disciplina AS option_value ,

            CONCAT(serie.sigla, cedula_turma.cedula, curso.sigla, ' - ', turno.nome_turno, ' (', disciplina.nome_disciplina, ')') AS option_text

            FROM turma_disciplina

            INNER JOIN turma ON(turma_disciplina.fk_id_turma = turma.id_turma)
            INNER JOIN disciplina ON(turma_disciplina.fk_id_disciplina = disciplina.id_disciplina)
            INNER JOIN serie ON(turma.fk_id_serie = serie.id_serie)
            INNER JOIN cedula_turma ON(turma.fk_id_cedula = cedula_turma.id_cedula_turma)
            INNER JOIN curso ON(turma.fk_id_curso = curso.id_curso)
            INNER JOIN turno ON(turma.fk_id_turno = turno.id_turno)
            INNER JOIN periodo_letivo ON(turma.fk_id_periodo_letivo = periodo_letivo.id_ano_letivo)
            INNER JOIN situacao_periodo_letivo ON(periodo_letivo.fk_id_situacao_periodo_letivo = situacao_periodo_letivo.id_situacao_periodo_letivo)

            WHERE turma_disciplina.fk_id_professor = :fk_id_teacher

            AND situacao_periodo_letivo.id_situacao_periodo_letivo = 1

            ORDER BY serie.sigla ASC, disciplina.nome_disciplina ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Busca a observação cadastrada na grade curricular da disciplina vinculada à turma/disciplina
     * selecionada, usada para sugerir o conteúdo ao professor. Só retorna dado se a turma/disciplina
     * pertencer ao professor logado.
     *
     * @return object|false
     */
    public function contentSuggestion()
    {

        $query =

            "SELECT

            grade_curricular.observacao_grade AS content_suggestion

            FROM turma_disciplina

            INNER JOIN grade_curricular ON(grade_curricular.fk_id_disciplina = turma_disciplina.fk_id_disciplina)

            WHERE turma_disciplina.id_turma_disciplina = :fk_id_class_discipline

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":fk_id_class_discipline", $this->__get("fk_id_class_discipline"));
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }


    /**
     * Retorna os lançamentos do diário do professor logado, podendo ser filtrados por turma
     *
     * @return array
     */
    public function readAll()
    {

        $query =

            "SELECT

            diario_professor.id_diario AS diary_id ,
            diario_professor.fk_id_turma_disciplina AS fk_id_class_discipline ,
            diario_professor.data_aula AS class_date ,
            diario_professor.conteudo AS content ,
            diario_professor.observacao_diario AS observation ,
            disciplina.nome_disciplina AS discipline_name ,
            serie.sigla AS acronym_series ,
            cedula_turma.cedula AS ballot ,
            curso.sigla AS course ,
            turno.nome_turno AS shift ,
            turma_disciplina.fk_id_turma AS class_id ,
            (SELECT COUNT(*) FROM diario_professor_anexo WHERE diario_professor_anexo.fk_id_diario = diario_professor.id_diario) AS total_attachment

            FROM diario_professor

            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)
            INNER JOIN disciplina ON(turma_disciplina.fk_id_disciplina = disciplina.id_disciplina)
            INNER JOIN turma ON(turma_disciplina.fk_id_turma = turma.id_turma)
            INNER JOIN serie ON(turma.fk_id_serie = serie.id_serie)
            INNER JOIN cedula_turma ON(turma.fk_id_cedula = cedula_turma.id_cedula_turma)
            INNER JOIN curso ON(turma.fk_id_curso = curso.id_curso)
            INNER JOIN turno ON(turma.fk_id_turno = turno.id_turno)

            WHERE turma_disciplina.fk_id_professor = :fk_id_teacher

            AND CASE WHEN :fk_id_class = 0 THEN turma.id_turma <> 0 ELSE turma.id_turma = :fk_id_class END

            ORDER BY diario_professor.data_aula DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->bindValue(":fk_id_class", $this->__get("fk_id_class"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Retorna os dados de um lançamento específico do diário, somente se pertencer ao professor logado
     *
     * @return array
     */
    public function dataGeneral()
    {

        $query =

            "SELECT

            diario_professor.id_diario AS diary_id ,
            diario_professor.fk_id_turma_disciplina AS fk_id_class_discipline ,
            diario_professor.data_aula AS class_date ,
            diario_professor.conteudo AS content ,
            diario_professor.observacao_diario AS observation ,
            disciplina.nome_disciplina AS discipline_name ,
            serie.sigla AS acronym_series ,
            cedula_turma.cedula AS ballot ,
            curso.sigla AS course ,
            turno.nome_turno AS shift

            FROM diario_professor

            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)
            INNER JOIN disciplina ON(turma_disciplina.fk_id_disciplina = disciplina.id_disciplina)
            INNER JOIN turma ON(turma_disciplina.fk_id_turma = turma.id_turma)
            INNER JOIN serie ON(turma.fk_id_serie = serie.id_serie)
            INNER JOIN cedula_turma ON(turma.fk_id_cedula = cedula_turma.id_cedula_turma)
            INNER JOIN curso ON(turma.fk_id_curso = curso.id_curso)
            INNER JOIN turno ON(turma.fk_id_turno = turno.id_turno)

            WHERE diario_professor.id_diario = :diaryId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":diaryId", $this->__get("diaryId"));
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Atualiza os dados de um lançamento do diário, somente se pertencer ao professor logado.
     * A turma/disciplina vinculada não é alterável aqui (evita reatribuir o lançamento a outra turma).
     *
     * @return void
     */
    public function update()
    {

        $query =

            "UPDATE diario_professor

            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)

            SET

            diario_professor.data_aula = :classDate ,
            diario_professor.conteudo = :content ,
            diario_professor.observacao_diario = :observationDiary

            WHERE diario_professor.id_diario = :diaryId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":classDate", $this->__get("classDate"));
        $stmt->bindValue(":content", $this->__get("content"));
        $stmt->bindValue(":observationDiary", $this->__get("observationDiary"));
        $stmt->bindValue(":diaryId", $this->__get("diaryId"));
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));

        $stmt->execute();
    }


    /**
     * Deleta um lançamento do diário, somente se pertencer ao professor logado.
     * Os anexos vinculados são removidos em cascata pelo banco.
     *
     * @return void
     */
    public function delete()
    {

        $query =

            "DELETE diario_professor FROM diario_professor

            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)

            WHERE diario_professor.id_diario = :diaryId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":diaryId", $this->__get("diaryId"));
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();
    }


    /**
     * Retorna os anexos vinculados a um lançamento do diário, somente se pertencer ao professor logado
     *
     * @return array
     */
    public function listAttachment()
    {

        $query =

            "SELECT

            diario_professor_anexo.id_anexo AS attachment_id ,
            diario_professor_anexo.nome_original_arquivo AS original_name ,
            diario_professor_anexo.nome_arquivo AS file_name

            FROM diario_professor_anexo

            INNER JOIN diario_professor ON(diario_professor_anexo.fk_id_diario = diario_professor.id_diario)
            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)

            WHERE diario_professor_anexo.fk_id_diario = :diaryId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher

            ORDER BY diario_professor_anexo.data_upload DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":diaryId", $this->__get("diaryId"));
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Cadastra um anexo vinculado a um lançamento do diário. Só insere se o lançamento
     * pertencer ao professor logado.
     *
     * @return void
     */
    public function insertAttachment($originalName, $fileName)
    {

        $query =

            "INSERT INTO diario_professor_anexo (fk_id_diario, nome_original_arquivo, nome_arquivo)

            SELECT diario_professor.id_diario, :originalName, :fileName

            FROM diario_professor

            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)

            WHERE diario_professor.id_diario = :diaryId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":diaryId", $this->__get("diaryId"));
        $stmt->bindValue(":originalName", $originalName);
        $stmt->bindValue(":fileName", $fileName);
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));

        $stmt->execute();
    }


    /**
     * Retorna um anexo específico (usado para localizar o arquivo físico antes de excluir),
     * somente se pertencer ao professor logado
     *
     * @return array
     */
    public function attachmentData($attachmentId)
    {

        $query =

            "SELECT

            diario_professor_anexo.id_anexo AS attachment_id ,
            diario_professor_anexo.nome_arquivo AS file_name

            FROM diario_professor_anexo

            INNER JOIN diario_professor ON(diario_professor_anexo.fk_id_diario = diario_professor.id_diario)
            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)

            WHERE diario_professor_anexo.id_anexo = :attachmentId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":attachmentId", $attachmentId);
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Deleta um anexo vinculado a um lançamento do diário, somente se pertencer ao professor logado
     *
     * @return void
     */
    public function deleteAttachment($attachmentId)
    {

        $query =

            "DELETE diario_professor_anexo FROM diario_professor_anexo

            INNER JOIN diario_professor ON(diario_professor_anexo.fk_id_diario = diario_professor.id_diario)
            INNER JOIN turma_disciplina ON(diario_professor.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)

            WHERE diario_professor_anexo.id_anexo = :attachmentId

            AND turma_disciplina.fk_id_professor = :fk_id_teacher
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":attachmentId", $attachmentId);
        $stmt->bindValue(":fk_id_teacher", $this->__get("fk_id_teacher"));
        $stmt->execute();
    }
}
