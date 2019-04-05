<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliShippingOptions extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_shipping_options';
    protected $primaryKey = 'meli_shipping_options_id';
    public $timestamps = false;
    /*public function MeliCatSetBuyMod()
    {
        return $this->belongsTo(MeliCatSetBuyMod::class, 'meli_buying_options_id');
    }*/
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliShippingOptions::where('meli_shipping_options_name','=',$this->meli_shipping_options_name)->get(); 
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
            $rs = MeliShippingOptions::where('meli_shipping_options_name','=',$this->meli_shipping_options_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_shipping_options_id;
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
