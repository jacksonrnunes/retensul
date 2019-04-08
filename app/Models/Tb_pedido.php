<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_pedido extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'tb_pedido';
    protected $primaryKey = 'tb_pedido_id';
    public $timestamps = false;
}
