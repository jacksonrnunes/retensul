<?php

namespace retensul\Models;

use Illuminate\Database\Eloquent\Model;

class MeliCoverageAreas extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'meli_coverage_areas';
    protected $primaryKey = 'meli_coverage_areas_id';
    public $timestamps = false;
    public function Settings()
    {
        return $this->hasOne(MeliCategoriesSettings::class, 'meli_coverage_areas_id');
    }
    public function conferir()
    {
        try
        {
            $return = false;
            $rs = MeliCoverageAreas::where('meli_coverage_areas_name','=',$this->meli_coverage_areas_name)->get(); 
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
            $rs = MeliCoverageAreas::where('meli_coverage_areas_name','=',$this->meli_coverage_areas_name)->get(); 
            foreach ($rs as $each_rs)
            {
                if(!empty($each_rs))
                {
                    $return = $each_rs->meli_coverage_areas_id;
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
