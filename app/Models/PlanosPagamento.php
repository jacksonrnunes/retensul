<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class PlanosPagamento extends Model
{
    //
    protected $connection = 'odbc';
    protected $table = 'planos';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
