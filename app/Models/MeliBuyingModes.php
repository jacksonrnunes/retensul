<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliBuyingModes extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_buying_modes';
    protected $primaryKey = 'meli_buying_mode_id';
    public $timestamps = false;
    /*public function MeliCatSetBuyMod()
    {
        return $this->belongsTo(MeliCatSetBuyMod::class, 'meli_buying_mode_id');
    }*/
}
