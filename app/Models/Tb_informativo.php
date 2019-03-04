<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_informativo extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'tb_informativo';
    protected $primaryKey = 'tb_informativo_id';
    public $timestamps = false;
}
