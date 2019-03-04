<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_pedido_itens extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'tb_pedido_itens';
    protected $primaryKey = 'tb_pedido_itens_id';
    public $timestamps = false;
}
