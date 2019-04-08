<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_pedido_itens_fornecedores extends Model
{
    protected $connection = 'mysql';
    protected $table = 'Tb_pedido_itens_fornecedores';
    protected $primaryKey = 'Tb_pedido_itens_fornecedores_id';
    public $timestamps = false;
}
