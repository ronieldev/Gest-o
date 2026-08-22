<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class Cobranca extends Model
{

    private $chargeId;
    private $fk_id_student;
    private $competency;
    private $amount;
    private $dueDate;
    private $fk_id_charge_situation;
    private $asaasChargeId;
    private $paymentLink;


    public function __get($att)
    {
        return $this->$att;
    }


    public function __set($att, $newValue)
    {
        return $this->$att = $newValue;
    }


    /**
     * Gerar uma cobrança (mensalidade) para um aluno
     *
     * @return int
     */
    public function insert()
    {

        $query =

            "INSERT INTO cobranca

                (fk_id_aluno, competencia, valor, data_vencimento, fk_id_situacao_cobranca)

            VALUES

                (:studentId, :competency, :amount, :dueDate, 1)

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':studentId', $this->__get('fk_id_student'));
        $stmt->bindValue(':competency', $this->__get('competency'));
        $stmt->bindValue(':amount', $this->__get('amount'));
        $stmt->bindValue(':dueDate', $this->__get('dueDate'));

        $stmt->execute();

        return $this->db->lastInsertId();
    }


    /**
     * Marcar uma cobrança como paga manualmente (fallback antes/fora do webhook do Asaas)
     *
     * @return void
     */
    public function markAsPaid()
    {

        $query =

            "UPDATE cobranca SET

            fk_id_situacao_cobranca = 2 ,
            data_pagamento = NOW()

            WHERE id_cobranca = :chargeId

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':chargeId', $this->__get('chargeId'));

        $stmt->execute();
    }


    /**
     * Lista as cobranças com os dados do aluno/responsável e status
     *
     * @return array
     */
    public function list()
    {

        return $this->speedingUp(

            "SELECT

            cobranca.id_cobranca AS charge_id ,
            cobranca.competencia AS competency ,
            cobranca.valor AS amount ,
            cobranca.data_vencimento AS due_date ,
            cobranca.data_pagamento AS payment_date ,
            cobranca.link_pagamento AS payment_link ,
            aluno.id_aluno AS student_id ,
            aluno.nome_aluno AS student_name ,
            responsavel_financeiro.nome_responsavel_financeiro AS responsible_name ,
            situacao_cobranca.id_situacao_cobranca AS situation_id ,
            situacao_cobranca.situacao_cobranca AS situation_name

            FROM cobranca

            INNER JOIN aluno ON (cobranca.fk_id_aluno = aluno.id_aluno)
            INNER JOIN situacao_cobranca ON (cobranca.fk_id_situacao_cobranca = situacao_cobranca.id_situacao_cobranca)
            LEFT JOIN responsavel_financeiro ON (aluno.fk_id_responsavel_financeiro = responsavel_financeiro.id_responsavel_financeiro)

            ORDER BY cobranca.data_vencimento DESC"

        );
    }


    /**
     * Dados de uma única cobrança, para o modal de detalhe
     *
     * @return array
     */
    public function data()
    {

        $query =

            "SELECT

            cobranca.id_cobranca AS charge_id ,
            cobranca.competencia AS competency ,
            cobranca.valor AS amount ,
            cobranca.data_vencimento AS due_date ,
            cobranca.data_pagamento AS payment_date ,
            cobranca.link_pagamento AS payment_link ,
            aluno.nome_aluno AS student_name ,
            responsavel_financeiro.nome_responsavel_financeiro AS responsible_name ,
            responsavel_financeiro.email_responsavel_financeiro AS responsible_email ,
            situacao_cobranca.situacao_cobranca AS situation_name

            FROM cobranca

            INNER JOIN aluno ON (cobranca.fk_id_aluno = aluno.id_aluno)
            INNER JOIN situacao_cobranca ON (cobranca.fk_id_situacao_cobranca = situacao_cobranca.id_situacao_cobranca)
            LEFT JOIN responsavel_financeiro ON (aluno.fk_id_responsavel_financeiro = responsavel_financeiro.id_responsavel_financeiro)

            WHERE cobranca.id_cobranca = :chargeId

        ";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':chargeId', $this->__get('chargeId'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * Alunos com responsável financeiro cadastrado, para o formulário de cobrança avulsa
     *
     * @return array
     */
    public function availableStudents()
    {

        return $this->speedingUp(

            "SELECT aluno.id_aluno AS option_value , aluno.nome_aluno AS option_text

            FROM aluno

            WHERE aluno.fk_id_responsavel_financeiro IS NOT NULL"

        );
    }


    /**
     * Totais para os cards do painel financeiro (pendente, pago no mês, vencido)
     *
     * @return array
     */
    public function totals()
    {

        return $this->speedingUp(

            "SELECT

            (SELECT COALESCE(SUM(valor), 0) FROM cobranca WHERE fk_id_situacao_cobranca = 1) AS total_pending ,
            (SELECT COALESCE(SUM(valor), 0) FROM cobranca WHERE fk_id_situacao_cobranca = 2 AND MONTH(data_pagamento) = MONTH(CURDATE()) AND YEAR(data_pagamento) = YEAR(CURDATE())) AS total_paid_month ,
            (SELECT COALESCE(SUM(valor), 0) FROM cobranca WHERE fk_id_situacao_cobranca = 1 AND data_vencimento < CURDATE()) AS total_overdue"

        );
    }
}
