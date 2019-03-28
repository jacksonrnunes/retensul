<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliCategories extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_categories';
    protected $primaryKey = 'meli_categorie_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_categorie_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliCategories::where('meli_categorie_id_original','=',$this->meli_categorie_id_original)->get(); 
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
}
