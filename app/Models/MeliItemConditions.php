<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliItemConditions extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_item_conditions';
    protected $primaryKey = 'meli_item_condition_id';
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
            $rs = MeliItemConditions::where('meli_item_condition_name','=',$this->meli_item_condition_name)->get(); 
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
            $rs = MeliItemConditions::where('meli_item_condition_name','=',$this->meli_item_condition_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_item_condition_id;
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
