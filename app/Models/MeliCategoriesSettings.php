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
    
}
