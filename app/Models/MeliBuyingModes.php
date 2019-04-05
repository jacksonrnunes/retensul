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
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliBuyingModes::where('meli_buying_mode_name','=',$this->meli_buying_mode_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = true;
                }
            }
            return $return;
        }
        catch (Doctrine_Exception $e)
        {
            echo $e->getMessage();
        }
    }
    public function returnId()
    {
        try
        {
            $return = false;
            $rs = MeliBuyingModes::where('meli_buying_mode_name','=',$this->meli_buying_mode_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_buying_mode_id;
                }
            }
            return $return;
        }
        catch (Doctrine_Exception $e)
        {
            echo $e->getMessage();
        }
    }
}
