<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class Planning extends Model
{

    private $planningId;
    private $fk_id_class_discipline;
    private $startDate;
    private $endDate;
    private $observationPlanning;
    private $seekName;


    public function __get($att)
    {
        return $this->$att;
    }


    public function __set($att, $newValue)
    {
        return $this->$att = $newValue;
    }


    /**
     * Cria um planejamento vinculando uma disciplina/turma/professor a um período
     *
     * @return void
     */
    public function insert()
    {

        $query =

            "INSERT INTO planejamento

                (fk_id_turma_disciplina, data_inicio, data_fim, observacao_planejamento)

            VALUES

                (:fk_id_class_discipline, :startDate, :endDate, :observationPlanning)

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':fk_id_class_discipline', $this->__get('fk_id_class_discipline'));
        $stmt->bindValue(':startDate', $this->__get('startDate'));
        $stmt->bindValue(':endDate', $this->__get('endDate'));
        $stmt->bindValue(':observationPlanning', $this->__get('observationPlanning'));

        $stmt->execute();
    }


    /**
     * Retorna todos os planejamentos cadastrados
     *
     * @return array
     */
    public function readAll()
    {

        return $this->speedingUp(

            "SELECT

            planejamento.id_planejamento AS planning_id ,
            planejamento.fk_id_turma_disciplina AS fk_id_class_discipline ,
            professor.nome_professor AS teacher_name ,
            disciplina.nome_disciplina AS discipline_name ,
            serie.sigla AS acronym_series ,
            cedula_turma.cedula AS ballot ,
            curso.sigla AS course ,
            turno.nome_turno AS shift ,
            planejamento.data_inicio AS start_date ,
            planejamento.data_fim AS end_date ,
            planejamento.observacao_planejamento AS observation

            FROM planejamento

            INNER JOIN turma_disciplina ON(planejamento.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)
            INNER JOIN professor ON(turma_disciplina.fk_id_professor = professor.id_professor)
            INNER JOIN disciplina ON(turma_disciplina.fk_id_disciplina = disciplina.id_disciplina)
            INNER JOIN turma ON(turma_disciplina.fk_id_turma = turma.id_turma)
            INNER JOIN serie ON(turma.fk_id_serie = serie.id_serie)
            INNER JOIN cedula_turma ON(turma.fk_id_cedula = cedula_turma.id_cedula_turma)
            INNER JOIN curso ON(turma.fk_id_curso = curso.id_curso)
            INNER JOIN turno ON(turma.fk_id_turno = turno.id_turno)

            ORDER BY planejamento.data_inicio DESC"
        );
    }


    /**
     * Retorna os dados de um planejamento específico
     *
     * @return array
     */
    public function dataGeneral()
    {

        $query =

            "SELECT

            planejamento.id_planejamento AS planning_id ,
            planejamento.fk_id_turma_disciplina AS fk_id_class_discipline ,
            professor.nome_professor AS teacher_name ,
            disciplina.nome_disciplina AS discipline_name ,
            serie.sigla AS acronym_series ,
            cedula_turma.cedula AS ballot ,
            curso.sigla AS course ,
            turno.nome_turno AS shift ,
            planejamento.data_inicio AS start_date ,
            planejamento.data_fim AS end_date ,
            planejamento.observacao_planejamento AS observation

            FROM planejamento

            INNER JOIN turma_disciplina ON(planejamento.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)
            INNER JOIN professor ON(turma_disciplina.fk_id_professor = professor.id_professor)
            INNER JOIN disciplina ON(turma_disciplina.fk_id_disciplina = disciplina.id_disciplina)
            INNER JOIN turma ON(turma_disciplina.fk_id_turma = turma.id_turma)
            INNER JOIN serie ON(turma.fk_id_serie = serie.id_serie)
            INNER JOIN cedula_turma ON(turma.fk_id_cedula = cedula_turma.id_cedula_turma)
            INNER JOIN curso ON(turma.fk_id_curso = curso.id_curso)
            INNER JOIN turno ON(turma.fk_id_turno = turno.id_turno)

            WHERE planejamento.id_planejamento = :planningId

        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':planningId', $this->__get('planningId'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Atualiza os dados de um planejamento
     *
     * @return void
     */
    public function update()
    {

        $query =

            "UPDATE planejamento SET

            fk_id_turma_disciplina = :fk_id_class_discipline ,
            data_inicio = :startDate ,
            data_fim = :endDate ,
            observacao_planejamento = :observationPlanning

            WHERE planejamento.id_planejamento = :planningId

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':fk_id_class_discipline', $this->__get('fk_id_class_discipline'));
        $stmt->bindValue(':startDate', $this->__get('startDate'));
        $stmt->bindValue(':endDate', $this->__get('endDate'));
        $stmt->bindValue(':observationPlanning', $this->__get('observationPlanning'));
        $stmt->bindValue(':planningId', $this->__get('planningId'));

        $stmt->execute();
    }


    /**
     * Busca planejamentos por professor, turma ou disciplina
     *
     * @return array
     */
    public function seek()
    {

        $query =

            "SELECT

            planejamento.id_planejamento AS planning_id ,
            planejamento.fk_id_turma_disciplina AS fk_id_class_discipline ,
            professor.nome_professor AS teacher_name ,
            disciplina.nome_disciplina AS discipline_name ,
            serie.sigla AS acronym_series ,
            cedula_turma.cedula AS ballot ,
            curso.sigla AS course ,
            turno.nome_turno AS shift ,
            planejamento.data_inicio AS start_date ,
            planejamento.data_fim AS end_date ,
            planejamento.observacao_planejamento AS observation

            FROM planejamento

            INNER JOIN turma_disciplina ON(planejamento.fk_id_turma_disciplina = turma_disciplina.id_turma_disciplina)
            INNER JOIN professor ON(turma_disciplina.fk_id_professor = professor.id_professor)
            INNER JOIN disciplina ON(turma_disciplina.fk_id_disciplina = disciplina.id_disciplina)
            INNER JOIN turma ON(turma_disciplina.fk_id_turma = turma.id_turma)
            INNER JOIN serie ON(turma.fk_id_serie = serie.id_serie)
            INNER JOIN cedula_turma ON(turma.fk_id_cedula = cedula_turma.id_cedula_turma)
            INNER JOIN curso ON(turma.fk_id_curso = curso.id_curso)
            INNER JOIN turno ON(turma.fk_id_turno = turno.id_turno)

            WHERE CONCAT(professor.nome_professor, disciplina.nome_disciplina, serie.sigla, cedula_turma.cedula, curso.sigla) LIKE :seekName

            ORDER BY planejamento.data_inicio DESC

        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':seekName', '%' . $this->__get('seekName') . '%');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Deleta um planejamento
     *
     * @return void
     */
    public function delete()
    {

        $query = "DELETE FROM planejamento WHERE planejamento.id_planejamento = :planningId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':planningId', $this->__get('planningId'));
        $stmt->execute();
    }
}
