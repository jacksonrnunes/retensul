<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliCatSetCur extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_cat_set_cur';
    protected $primaryKey = 'meli_cat_set_cur_id';
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
            $rs = MeliCatSetCur::where('meli_categorie_setting_id','=',$this->meli_categorie_setting_id)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    if($each_rs->meli_currencie_id == $this->meli_currencie_id)
                    {
                        $return = true;
                    }
                }
            }
            return $return;
        }
        catch (Doctrine_Exception $e)
        {
            echo $e->getMessage();
        }
    }
    /*public function returnId()
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
    }*/
}
