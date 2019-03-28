<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\MeliCategories;
use Vcoud\Mercadolibre\Meli;
use retensul\Models\MeliBuyingModes;
use retensul\Models\MeliItemsReviewsAllowed;
use retensul\Models\MeliCategoriesSettings;
use retensul\Models\MeliListingAllowed;
use retensul\Models\MeliCoverageAreas;
use retensul\Models\MeliImmediatePayment;
use retensul\Models\MeliReservationAllowed;
use retensul\Models\MeliSellerContact;
use retensul\Models\MeliShippingProfile;
use retensul\Models\MeliSimpleShipping;
use retensul\Models\MeliVipSubdomain;

class MeliCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $MeliCategories;

    public function __construct(MeliCategories $MeliCategories) {

        $this->MeliCategories = $MeliCategories;
    }
    public function index()
    {
        $MeliCategories = MeliCategories::orderBy('melicategories_descricao')->get();
        return view('site.MeliCategories');
    }
    public function buscarPrincipal()
    {
        $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
        $result = $meli->get('https://api.mercadolibre.com/sites/MLB/categories'); 
        $result = $result["body"];
        $result = json_decode(json_encode($result), True);
        $MeliCategoriesPrincipal = MeliCategories::where('meli_categorie_id_parent','=','')->orderBy('meli_categorie_name')->get();
        return view('site.MeliCategories', compact('result', 'MeliCategoriesPrincipal'));
    }
    public function buscar($id_categorie)
    {
        $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
        $result = $meli->get("https://api.mercadolibre.com/categories/".$id_categorie); 
        //print_r($result);
        $result = $result["body"];
        
        //$result = $result[0];
        $result = json_decode(json_encode($result), True);
        $result = $result["children_categories"];
        //$result = objectToArray($result);
        //$result = $result["name"];
        //print_r($result);
        $tipo = 'retorno';
        return view('site.MeliCategories', compact('result', 'tipo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function salvar(Request $request)
    {
        $cont=0;
        for ($i=0;$i<count($request->id_categorie);$i++)
        {
            $MeliCategorie = new MeliCategories;
            //echo ($i)."<br/>";
            //echo $request."<br/>";
            $MeliCategorie->meli_categorie_id_original = $request->id_categorie[$i];
            $MeliCategorie->meli_categorie_name = $request->descricao_categorie[$i];
            $MeliCategorie->meli_categorie_url_api = "https://api.mercadolibre.com/categories/".$request->id_categorie[$i];
            
            $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
            $result = $meli->get($MeliCategorie->meli_categorie_url_api);
            $result = $result["body"];
            $result = json_decode(json_encode($result), True);
            print_r($result);
            echo $result['id']."<br/>";
            echo $result['name']."<br/>";
            echo $result['settings']['items_reviews_allowed']."<br/>";
            $MeliCategorie->meli_categorie_picture = $result['picture'];
            $MeliCategorie->meli_categorie_permalink = $result['permalink'];
            $MeliCategorie->meli_categorie_total_items_in_this_category = $result['total_items_in_this_category'];
            $MeliCategorie->meli_categorie_attribute_types = $result['attribute_types'];
            $MeliCategorie->meli_categorie_meta_categ_id = $result['meta_categ_id'];
            $MeliCategorie->meli_categorie_attributable =  $result['attributable'];
            
            $verifica = $MeliCategorie->conferir();
            if($verifica == false)
            {
                $MeliCategorie->save();
            }
            
            $meliCategorieSettings = new MeliCategoriesSettings();
            $meliCategorieSettings->meli_categorie_setting_adult_content = $result['settings']['adult_content'];
            $meliCategorieSettings->meli_categorie_setting_buying_allowed = $result['settings']['buying_allowed'];
            $meliCategorieSettings->meli_categorie_setting_catalog_domain = $result['settings']['catalog_domain'];
            $meliCategorieSettings->meli_categorie_setting_fragile = $result['settings']['fragile'];
            
            //Salvar Meli Items Reviews Allowed
            $meliItemsReviewsAllowed = new MeliItemsReviewsAllowed();
            $meliItemsReviewsAllowed->meli_items_reviews_allowed_name = $result['settings']['items_reviews_allowed'];
            if(empty($meliItemsReviewsAllowed->meli_items_reviews_allowed_name))
            {
                $meliItemsReviewsAllowed->meli_items_reviews_allowed_name = 'Não Especificado';
            }
            $verifica = $meliItemsReviewsAllowed->conferir();
            if(($verifica == false) && (!empty($meliItemsReviewsAllowed->meli_items_reviews_allowed_name)))
            {
                $meliItemsReviewsAllowed->save();
            }
            else
            {
                $meliItemsReviewsAllowed->meli_items_reviews_allowed_id = $meliItemsReviewsAllowed->returnId();
            }
            
            $meliCategorieSettings->meli_items_reviews_allowed_id = $meliItemsReviewsAllowed->meli_items_reviews_allowed_id; 
            
            // Salvar Meli Listing Allowed
            $meliListingAllowed = new MeliListingAllowed();
            $meliListingAllowed->meli_listing_allowed_name = $result['settings']['listing_allowed'];
            if(empty($meliListingAllowed->meli_listing_allowed_name))
            {
                $meliListingAllowed->meli_listing_allowed_name = 'Não Especificado';
            }
            $verifica = $meliListingAllowed->conferir();
            if(($verifica == false) && (!empty($meliListingAllowed->meli_listing_allowed_name)))
            {
                $meliListingAllowed->save();
            }
            else
            {
                $meliListingAllowed->meli_listing_allowed_id = $meliListingAllowed->returnId();
            }
            $meliCategorieSettings->meli_listing_allowed_id = $meliListingAllowed->meli_listing_allowed_id;
            
            //Salvar Meli Coverage Areas
            $meliCoverageAreas = new MeliCoverageAreas();
            $meliCoverageAreas->meli_coverage_areas_name = $result['settings']['coverage_areas'];
            if(empty($meliCoverageAreas->meli_coverage_areas_name))
            {
                $meliCoverageAreas->meli_coverage_areas_name = 'Não Especificado';
            }
            $verifica = $meliCoverageAreas->conferir();
            if(($verifica == false) && (!empty($meliCoverageAreas->meli_coverage_areas_name)))
            {
                $meliCoverageAreas->save();
            }
            else
            {
                $meliCoverageAreas->meli_coverage_areas_id = $meliCoverageAreas->returnId();
            }
            $meliCategorieSettings->meli_coverage_areas_id = $meliCoverageAreas->meli_coverage_areas_id;
            
            //Salvar Meli Immediate Payment
            $meliImmediatePayment = new MeliImmediatePayment();
            $meliImmediatePayment->meli_immediate_payment_name = $result['settings']['immediate_payment'];
            if(empty($meliImmediatePayment->meli_immediate_payment_name))
            {
                $meliImmediatePayment->meli_immediate_payment_name = 'Não Especificado';
            }
            $verifica = $meliImmediatePayment->conferir();
            if(($verifica == false) && (!empty($meliImmediatePayment->meli_immediate_payment_name)))
            {
                $meliImmediatePayment->save();
            }
            else
            {
                $meliImmediatePayment->meli_immediate_payment_id = $meliImmediatePayment->returnId();
            }
            $meliCategorieSettings->meli_immediate_payment_id = $meliImmediatePayment->meli_immediate_payment_id;
            
            //Salvar Meli Reservation Allowed
            $meliReservationAllowed = new MeliReservationAllowed();
            $meliReservationAllowed->meli_reservation_allowed_name = $result['settings']['reservation_allowed'];
            if(empty($meliReservationAllowed->meli_reservation_allowed_name))
            {
                $meliReservationAllowed->meli_reservation_allowed_name = 'Não Especificado';
            }
            $verifica = $meliReservationAllowed->conferir();
            if(($verifica == false) && (!empty($meliReservationAllowed->meli_reservation_allowed_name)))
            {
                $meliReservationAllowed->save();
            }
            else
            {
                $meliReservationAllowed->meli_reservation_allowed_id = $meliReservationAllowed->returnId();
            }
            $meliCategorieSettings->meli_reservation_allowed_id = $meliReservationAllowed->meli_reservation_allowed_id;
            
            //Salvar Meli Seller Contact
            $meliSellerContact = new MeliSellerContact();
            $meliSellerContact->meli_seller_contact_name = $result['settings']['seller_contact'];;
            if(empty($meliSellerContact->meli_seller_contact_name))
            {
                $meliSellerContact->meli_seller_contact_name = 'Não Especificado';
            }
            $verifica = $meliSellerContact->conferir();
            if(($verifica == false) && (!empty($meliSellerContact->meli_seller_contact_name)))
            {
                $meliSellerContact->save();
            }
            else
            {
                $meliSellerContact->meli_seller_contact_id = $meliSellerContact->returnId();
            }
            $meliCategorieSettings->meli_seller_contact_id = $meliSellerContact->meli_seller_contact_id;
            
            //Salvar Shipping Profile
            $meliShippingProfile = new MeliShippingProfile();
            $meliShippingProfile->meli_shipping_profile_name = $result['settings']['shipping_profile'];
            if(empty($meliShippingProfile->meli_shipping_profile_name))
            {
                $meliShippingProfile->meli_shipping_profile_name = 'Não Especificado';
            }
            $verifica = $meliShippingProfile->conferir();
            if(($verifica == false) && (!empty($meliShippingProfile->meli_shipping_profile_name)))
            {
                $meliShippingProfile->save();
            }
            else
            {
                $meliShippingProfile->meli_shipping_profile_id = $meliShippingProfile->returnId();
            }
            $meliCategorieSettings->meli_shipping_profile_id = $meliShippingProfile->meli_shipping_profile_id;
            
            //Salvar Simple Shipping
            $meliSimpleShipping = new MeliSimpleShipping();
            $meliSimpleShipping->meli_simple_shipping_name = $result['settings']['simple_shipping'];
            if(empty($meliSimpleShipping->meli_simple_shipping_name))
            {
                $meliSimpleShipping->meli_simple_shipping_name = 'Não Especificado';
            }
            $verifica = $meliSimpleShipping->conferir();
            if(($verifica == false) && (!empty($meliSimpleShipping->meli_simple_shipping_name)))
            {
                $meliSimpleShipping->save();
            }
            else
            {
                $meliSimpleShipping->meli_simple_shipping_id = $meliSimpleShipping->returnId();
            }
            $meliCategorieSettings->meli_simple_shipping_id = $meliSimpleShipping->meli_simple_shipping_id;
            
            //Salvar VIP Subdomain
            $meliVipSubdomain = new MeliVipSubdomain();
            $meliVipSubdomain->meli_vip_subdomain_name = $result['settings']['vip_subdomain'];
            if(empty($meliVipSubdomain->meli_vip_subdomain_name))
            {
                $meliVipSubdomain->meli_vip_subdomain_name = 'Não Especificado';
            }
            $verifica = $meliVipSubdomain->conferir();
            if(($verifica == false) && (!empty($meliVipSubdomain->meli_vip_subdomain_name)))
            {
                $meliVipSubdomain->save();
            }
            else
            {
                $meliVipSubdomain->meli_vip_subdomain_id = $meliVipSubdomain->returnId();
            }
            $meliCategorieSettings->meli_vip_subdomain_id = $meliVipSubdomain->meli_vip_subdomain_id;
           
            //echo $meliVipSubdomain->meli_vip_subdomain_id."<br/>";
            //echo $meliCategorieSettings->meli_vip_subdomain_id."<br/>";
            //echo $meliVipSubdomain->meli_vip_subdomain_name."<br/>";
            //$MeliCategorie->Settings()->buying_allowed = $result['settings']['buying_allowed'];
            //$MeliCategorie->Settings()-> = $result['settings']['buying_modes'][0]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['currencies'][0]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['item_conditions'][0]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['item_conditions'][1]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['item_conditions'][2]."<br/>";
            //echo $result['settings']['mirror_slave_categories']."<br/>";
            //echo $result['settings']['restrictions']."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['shipping_modes'][0]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['shipping_modes'][1]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['shipping_modes'][2]."<br/>";
            //$MeliCategorie->Settings()-> $result['settings']['shipping_options'][0]."<br/>";
            //echo $result['settings']['tags']."<br/>";
            
            
            
            $meliCategorieSettings->meli_categorie_setting_max_description_length = $result['settings']['max_description_length'];
            $meliCategorieSettings->meli_categorie_setting_max_pictures_per_item = $result['settings']['max_pictures_per_item'];
            $meliCategorieSettings->meli_categorie_setting_max_pictures_per_item_var = $result['settings']['max_pictures_per_item_var'];
            $meliCategorieSettings->meli_categorie_setting_max_sub_title_length = $result['settings']['max_sub_title_length'];
            $meliCategorieSettings->meli_categorie_setting_max_title_length = $result['settings']['max_title_length'];
            if(empty($result['settings']['maximum_price']))
            {
                $meliCategorieSettings->meli_categorie_setting_maximum_price = "Não especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_maximum_price = $result['settings']['maximum_price'];
            }
            
            $meliCategorieSettings->meli_categorie_setting_minimum_price = $result['settings']['minimum_price'];
            if(empty($result['settings']['mirror_category']))
            {
                $meliCategorieSettings->meli_categorie_setting_mirror_category = "Não especificado";
            }
            else 
            {
                $meliCategorieSettings->meli_categorie_setting_mirror_category = $result['settings']['mirror_category'];
            }
            
            if(empty($result['settings']['mirror_master_category']))
            {
                $meliCategorieSettings->meli_categorie_setting_mirror_master_category = "Não especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_mirror_master_category = $result['settings']['mirror_master_category'];
            }
            
            if($result['settings']['price'] == 'required')
            {
                $meliCategorieSettings->meli_categorie_setting_price = true;
                echo $result['settings']['price']." true<br/>";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_price = false;
                echo $result['settings']['price']." false<br/>";
            }
            echo $result['settings']['price']." nada<br/>";
            $meliCategorieSettings->meli_categorie_setting_rounded_address = $result['settings']['rounded_address'];
            if(empty($result['settings']['show_contact_information']))
            {
                $meliCategorieSettings->meli_categorie_setting_show_contact_information = "Não especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_show_contact_information = $result['settings']['show_contact_information'];
            }
            $meliCategorieSettings->meli_categorie_setting_stock = $result['settings']['stock'];
            if(empty($result['settings']['sub_vertical']))
            {
                $meliCategorieSettings->meli_categorie_setting_sub_vertical = 'Não especificado';
            }
            else 
            {
                $meliCategorieSettings->meli_categorie_setting_sub_vertical = $result['settings']['sub_vertical'];
            }
            
            $meliCategorieSettings->meli_categorie_setting_subscribable = $result['settings']['subscribable'];
            if(empty($result['settings']['vertical']))
            {
                $meliCategorieSettings->meli_categorie_setting_vertical = 'não especificado';
            }
            else
            {
                $meliCategorieSettings->vertical = $result['settings']['vertical'];
            }
            $meliCategorieSettings->save();
            
            
            
            print_r($MeliCategorie);        
            $cont++;
        }
        //return redirect(route('MeliSuperCategories.buscar'));
        //return redirect()->action('Painel\MeliSuperCategoriesController@buscar')->with('mesage', 'Salvo Com Sucesso');
        //View::make('/Painel/MeliSuperCategoriesController@buscar');
    }
}
