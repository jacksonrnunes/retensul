<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    //
    protected $connection = 'odbc';
    protected $table = 'produtosprincipal';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
