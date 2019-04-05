<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliMirrorSlaveCategories extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_mirror_slave_categories';
    protected $primaryKey = 'meli_mirror_slave_categorie_id';
    public $timestamps = false;
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliMirrorSlaveCategories::where('meli_mirror_slave_categorie_name','=',$this->meli_mirror_slave_categorie_name)->get(); 
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
            $rs = MeliMirrorSlaveCategories::where('meli_mirror_slave_categorie_name','=',$this->meli_mirror_slave_categorie_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_mirror_slave_categorie_id;
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
