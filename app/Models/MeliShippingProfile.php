<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliShippingProfile extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_shipping_profile';
    protected $primaryKey = 'meli_shipping_profile_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_shipping_profile_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliShippingProfile::where('meli_shipping_profile_name','=',$this->meli_shipping_profile_name)->get(); 
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
            $rs = MeliShippingProfile::where('meli_shipping_profile_name','=',$this->meli_shipping_profile_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_shipping_profile_id;
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
