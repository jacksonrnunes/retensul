<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliSuperCategories extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'melisupercategories';
    protected $primaryKey = 'melisupercategories_id';
    public $timestamps = true;
}
