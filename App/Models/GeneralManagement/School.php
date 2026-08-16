<?php

namespace App\Models\GeneralManagement;

use MF\Model\Model;

class School extends Model
{

    /**
     * Retorna todas as escolas para popular select
     *
     * @return array
     */
    public function listAll()
    {

        return $this->speedingUp(

            "SELECT

            id_escola AS option_value ,
            nome_escola AS option_text

            FROM escola

            ORDER BY nome_escola"

        );
    }
}
