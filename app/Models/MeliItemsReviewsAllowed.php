<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliItemsReviewsAllowed extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_items_reviews_allowed';
    protected $primaryKey = 'meli_items_reviews_allowed_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_items_reviews_allowed_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliItemsReviewsAllowed::where('meli_items_reviews_allowed_name','=',$this->meli_items_reviews_allowed_name)->get(); 
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
            $rs = MeliItemsReviewsAllowed::where('meli_items_reviews_allowed_name','=',$this->meli_items_reviews_allowed_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_items_reviews_allowed_id;
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
