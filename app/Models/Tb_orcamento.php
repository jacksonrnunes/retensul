<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_orcamento extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'tb_orcamento';
    protected $primaryKey = 'tb_orcamento_id';
    public $timestamps = false;
    public function Cliente()
    {
        return $this->belongsTo(Pessoas::class, 'tb_orcamento_id_cliente');
    }
}
