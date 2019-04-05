<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliCategoriesSettings extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_categories_setting';
    protected $primaryKey = 'meli_categorie_setting_id';
    public $timestamps = false;
    public function Categories()
    {
        return $this->belongsTo(MeliCategories::class, 'meli_categorie_id');
    }
    public function Items_reviews_allowed()
    {
        return $this->belongsTo(MeliItemsReviewsAllowed::class, 'meli_items_reviews_allowed_id');
    }
    public function Listing_allowed()
    {
        return $this->belongsTo(MeliListingAllowed::class, 'meli_ilisting_allowed_id');
    }
    public function Coverage_areas()
    {
        return $this->belongsTo(MeliCoverageAreas::class, 'meli_coverage_areas_id');
    }
    public function Immediate_payment()
    {
        return $this->belongsTo(MeliImmediatePayment::class, 'meli_immediate_payment_id');
    }
    public function Confere_Categorie_Id()
    {
        try
        {
            $return = false;
            $rs = MeliCategoriesSettings::where('meli_categorie_id','=',$this->meli_categorie_id)->get(); 
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
            $rs = MeliCategoriesSettings::where('meli_categorie_id','=',$this->meli_categorie_id)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_categorie_setting_id;
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
