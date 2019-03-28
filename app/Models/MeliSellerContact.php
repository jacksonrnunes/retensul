<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliSellerContact extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_seller_contact';
    protected $primaryKey = 'meli_seller_contact_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_seller_contact_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliSellerContact::where('meli_seller_contact_name','=',$this->meli_seller_contact_name)->get(); 
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
            $rs = MeliSellerContact::where('meli_seller_contact_name','=',$this->meli_seller_contact_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_seller_contact_id;
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
