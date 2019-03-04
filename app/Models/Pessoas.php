<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoas extends Model
{
    //
    protected $connection = 'odbc';
    protected $table = 'pessoas';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
