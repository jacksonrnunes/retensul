<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliCategories extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'melicategories';
    protected $primaryKey = 'melicategories_id';
    public $timestamps = false;
}
