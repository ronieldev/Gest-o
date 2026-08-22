<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class ResponsavelFinanceiro extends Model
{

    private $responsibleId;
    private $responsibleName;
    private $cpf;
    private $email;
    private $fk_id_telephone;
    private $fk_id_address;
    private $asaasCustomerId;


    public function __get($att)
    {
        return $this->$att;
    }


    public function __set($att, $newValue)
    {
        return $this->$att = $newValue;
    }


    /**
     * Cadastrar responsável financeiro
     *
     * @return int
     */
    public function insert()
    {

        $query =

            "INSERT INTO responsavel_financeiro

                (nome_responsavel_financeiro, cpf_responsavel_financeiro, email_responsavel_financeiro, fk_id_telefone_responsavel_financeiro, fk_id_endereco_responsavel_financeiro)

            VALUES

                (:responsibleName, :cpf, :email, :fk_id_telephone, :fk_id_address)

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':responsibleName', $this->__get('responsibleName'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':fk_id_telephone', $this->__get('fk_id_telephone'));
        $stmt->bindValue(':fk_id_address', $this->__get('fk_id_address'));

        $stmt->execute();

        return $this->db->lastInsertId();
    }


    /**
     * Atualizar dados do responsável financeiro
     *
     * @return void
     */
    public function update()
    {

        $query =

            "UPDATE responsavel_financeiro SET

            nome_responsavel_financeiro = :responsibleName ,
            cpf_responsavel_financeiro = :cpf ,
            email_responsavel_financeiro = :email

            WHERE id_responsavel_financeiro = :responsibleId

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':responsibleName', $this->__get('responsibleName'));
        $stmt->bindValue(':cpf', $this->__get('cpf'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':responsibleId', $this->__get('responsibleId'));

        $stmt->execute();
    }


    /**
     * Busca o responsável financeiro vinculado a um aluno
     *
     * @return array
     */
    public function findByStudent($studentId)
    {

        $query =

            "SELECT

            responsavel_financeiro.id_responsavel_financeiro AS responsible_id ,
            responsavel_financeiro.nome_responsavel_financeiro AS responsible_name ,
            responsavel_financeiro.cpf_responsavel_financeiro AS cpf ,
            responsavel_financeiro.email_responsavel_financeiro AS email ,
            responsavel_financeiro.asaas_customer_id AS asaas_customer_id ,
            telefone.numero_telefone AS telephone_number

            FROM responsavel_financeiro

            INNER JOIN aluno ON (aluno.fk_id_responsavel_financeiro = responsavel_financeiro.id_responsavel_financeiro)
            INNER JOIN telefone ON (responsavel_financeiro.fk_id_telefone_responsavel_financeiro = telefone.id_telefone)

            WHERE aluno.id_aluno = :studentId

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':studentId', $studentId);

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
