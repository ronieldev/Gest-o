<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class Discipline extends Model
{

    private $disciplineId;
    private $disciplineName;
    private $acronym;


    public function __get($att)
    {
        return $this->$att;
    }


    public function __set($att, $newValue)
    {
        return $this->$att = $newValue;
    }


    /**
     * Criar disciplina
     * 
     * @return void
     */
    public function insert()
    {

        $query =

            "INSERT INTO disciplina

                (nome_disciplina, sigla_disciplina, fk_id_modalidade_disciplina)

            VALUES

                (:disciplineName, :acronym, (SELECT id_modalidade_disciplina FROM modalidade_disciplina ORDER BY id_modalidade_disciplina LIMIT 1))

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineName", $this->__get("disciplineName"));
        $stmt->bindValue(":acronym", $this->__get("acronym"));

        $stmt->execute();
    }


    /**
     * Retorna todas as disciplinas
     *
     * @return array
     */
    public function readAll()
    {

        return $this->speedingUp(

            "SELECT

            disciplina.id_disciplina AS discipline_id ,
            disciplina.nome_disciplina AS discipline_name ,
            disciplina.sigla_disciplina AS acronym

            FROM disciplina

            ORDER BY disciplina.nome_disciplina ASC"

        );
    }


    /**
     * Retorna os dados gerais de uma disciplina
     *
     * @return array
     */
    public function dataGeneral()
    {

        $query =

            "SELECT

            disciplina.id_disciplina AS discipline_id ,
            disciplina.nome_disciplina AS discipline_name ,
            disciplina.sigla_disciplina AS acronym

            FROM disciplina

            WHERE disciplina.id_disciplina = :disciplineId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":disciplineId", $this->__get("disciplineId"));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Atualizar dados de uma disciplina
     *
     * @return void
     */
    public function update()
    {

        $query =

            "UPDATE disciplina SET

            nome_disciplina = :disciplineName ,
            sigla_disciplina = :acronym

            WHERE disciplina.id_disciplina = :disciplineId

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineId", $this->__get("disciplineId"));
        $stmt->bindValue(":disciplineName", $this->__get("disciplineName"));
        $stmt->bindValue(":acronym", $this->__get("acronym"));

        $stmt->execute();
    }


    /**
     * Buscar disciplina
     *
     * @return array
     */
    public function seek()
    {

        $query =

            "SELECT

            disciplina.id_disciplina AS discipline_id ,
            disciplina.nome_disciplina AS discipline_name ,
            disciplina.sigla_disciplina AS acronym

            FROM disciplina

            WHERE disciplina.nome_disciplina LIKE :disciplineName

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(":disciplineName", "%" . $this->__get("disciplineName") . "%", \PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Deletar disciplina
     * 
     * @return void
     */
    public function delete()
    {

        $query = "DELETE FROM disciplina WHERE disciplina.id_disciplina = :disciplineId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":disciplineId", $this->__get("disciplineId"));
        $stmt->execute();
    }
}
