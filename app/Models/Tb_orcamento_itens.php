<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_orcamento_itens extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'tb_orcamento_itens';
    protected $primaryKey = 'tb_orcamento_itens_id';
    public $timestamps = false;
}
