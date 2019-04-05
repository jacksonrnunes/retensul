<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliSimpleShipping extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_simple_shipping';
    protected $primaryKey = 'meli_simple_shipping_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_simple_shipping_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliSimpleShipping::where('meli_simple_shipping_name','=',$this->meli_simple_shipping_name)->get(); 
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
            $rs = MeliSimpleShipping::where('meli_simple_shipping_name','=',$this->meli_simple_shipping_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_simple_shipping_id;
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
