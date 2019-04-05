<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedores extends Model
{
    //
    protected $connection = 'odbc';
    protected $table = 'vendedores';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
