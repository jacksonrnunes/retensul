<?php

namespace retensul;

use Illuminate\Database\Eloquent\Model;

class Tb_orcamento_itens_resposta extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_orcamento_itens_resposta';
    protected $primaryKey = 'tb_orcamento_itens_resposta_id';
    public $timestamps = false;
}
