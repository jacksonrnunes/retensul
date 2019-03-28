<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliVipSubdomain extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_vip_subdomain';
    protected $primaryKey = 'meli_vip_subdomain_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_vip_subdomain_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliVipSubdomain::where('meli_vip_subdomain_name','=',$this->meli_vip_subdomain_name)->get(); 
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
            $rs = MeliVipSubdomain::where('meli_vip_subdomain_name','=',$this->meli_vip_subdomain_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_vip_subdomain_id;
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
