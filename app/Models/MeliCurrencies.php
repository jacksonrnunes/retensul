<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliCurrencies extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_currencies';
    protected $primaryKey = 'meli_currencie_id';
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
            $rs = MeliCurrencies::where('meli_currencie_name','=',$this->meli_currencie_name)->get(); 
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
            $rs = MeliCurrencies::where('meli_currencie_name','=',$this->meli_currencie_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_currencie_id;
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
