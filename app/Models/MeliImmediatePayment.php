<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliImmediatePayment extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_immediate_payment';
    protected $primaryKey = 'meli_immediate_payment_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_immediate_payment_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliImmediatePayment::where('meli_immediate_payment_name','=',$this->meli_immediate_payment_name)->get(); 
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
    public function returnID()
    {
        try
        {
            $return = false;
            $rs = MeliImmediatePayment::where('meli_immediate_payment_name','=',$this->meli_immediate_payment_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_immediate_payment_name;
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
