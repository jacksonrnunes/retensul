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
use retensul\Models\MeliCatSetBuyMod;
use retensul\Models\MeliCatSetCur;
use retensul\Models\MeliCurrencies;
use retensul\Models\MeliItemConditions;
use retensul\Models\MeliCatSetIteCon;
use retensul\Models\MeliMirrorSlaveCategories;
use retensul\Models\MeliCatSetMirSlaCat;
use retensul\Models\MeliRestrictions;
use retensul\Models\MeliCatSetRes;
use retensul\Models\MeliShippingModes;
use retensul\Models\MeliCatSetShiMod;
use retensul\Models\MeliShippingOptions;
use retensul\Models\MeliCatSetShiOpt;
use retensul\Models\MeliTags;
use retensul\Models\MeliCatSetTag;

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
        $MeliCategoriesPrincipal = MeliCategories::where('meli_categorie_id_parent','=',null)->orderBy('meli_categorie_name')->get();
        $tipo = 'principal';
        return view('site.MeliCategories', compact('result', 'MeliCategoriesPrincipal', 'tipo'));
    }
    public function buscar($id_categorie, $nivel)
    {
        $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
        $result = $meli->get("https://api.mercadolibre.com/categories/".$id_categorie);
        //$result = $meli->get("https://api.mercadolibre.com/categories/MLB116500");        
        $result = $result["body"];
        $result = json_decode(json_encode($result), True);
        $result = $result["children_categories"];
        $MeliCategories = new MeliCategories();
        //MLB116500
        $MeliCategories->meli_categorie_id_original = $id_categorie;
        $idPrincipal = $MeliCategories->returnId();
        $SubCategorias = MeliCategories::where('meli_categorie_id_parent', '=', $idPrincipal)->get();
        if(empty($result))
        {
            $tipo = 'vazio';
        }
        else
        {
            $tipo = 'retorno';
        }
        
        return view('site.MeliSubCategories', compact('result', 'tipo', 'nivel', 'SubCategorias'));
    }
    public function arvoreRecursiva($id_categorie)
    {
        $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
        $arvore = $meli->get("https://api.mercadolibre.com/categories/".$id_categorie);
        $arvore = $arvore["body"];
        $arvore = json_decode(json_encode($arvore), True);
        if(isset($arvore["children_categories"]))
        {
            $arvore = $arvore["children_categories"];
            if(count($arvore)>0)
            {
                /*if(count($arvore)>2)
                {
                    for($i=0;$i<2;$i++)
                    {
                        echo $arvore[$i]['name']."<br/>";
                        $this->salvarArvore($arvore);
                        $arvore[$i]['childrens'] = $this->arvoreRecursiva($arvore[$i]['id']);
                        
                    }
                }
                else
                {*/
                    for($i=0;$i<count($arvore);$i++)
                    {
                        echo $arvore[$i]['name']."<br/>";
                        $this->salvarArvore($arvore);
                        $arvore[$i]['childrens'] = $this->arvoreRecursiva($arvore[$i]['id']);
                        
                    }
               // }
            }
        }
        //print_r($arvore);
        
        
        return $arvore;
        
    }
    public function buscarArvore($id_categorie, $nivel)
    {
        
        
        
        $result = $this->arvoreRecursiva($id_categorie);
        
        //print_r($result);
        
        $SubCategorias = null;
        
        
        if(empty($result))
        {
            $tipo = 'vazio';
        }
        else
        {
            $tipo = 'retorno';
        }
        //print_r($result);
        return view('site.MeliSubCategories', compact('result', 'tipo', 'nivel', 'SubCategorias'));
    }
    public function buscarSistema($id_categorie, $nivel)
    {
        $MeliCategories = new MeliCategories();
        $result= null;
        $MeliCategories->meli_categorie_id_original = $id_categorie;
        $idPrincipal = $MeliCategories->returnId();
        $SubCategorias = MeliCategories::where('meli_categorie_id_parent', '=', $idPrincipal)->get();
        //echo $SubCategorias."<br/>";
        if($SubCategorias == '[]')
        {
            $tipo = 'vazio';
        }
        else
        {
            $tipo = 'sistema';
        }
        return view('site.MeliSubCategories', compact('result',  'tipo', 'nivel', 'SubCategorias'));
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
        echo $request;
        //echo "<br/>".count($request->id_categorie)."<br/>";
        for ($i=0;$i<count($request->id_categorie);$i++)
        {   
            $MeliCategorie = new MeliCategories;
            $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
            $MeliCategorie->meli_categorie_id_original = $request->id_categorie[$i];
            $MeliCategorie->meli_categorie_name = $request->descricao_categorie[$i];
            $MeliCategorie->meli_categorie_url_api = "https://api.mercadolibre.com/categories/".$request->id_categorie[$i];
            $result = $meli->get($MeliCategorie->meli_categorie_url_api);
            $result = $result["body"];
            //print_r($result);
            $result = json_decode(json_encode($result), True);
            if(isset($result['picture']))
            {
                $MeliCategorie->meli_categorie_picture = $result['picture'];
            }
            else
            {
                $MeliCategorie->meli_categorie_picture = 'Não possui';
            }
            if(isset($result['permalink']))
            {
                $MeliCategorie->meli_categorie_permalink = $result['permalink'];
            }
            else
            {
                $MeliCategorie->meli_categorie_permalink = 'Não possui';
            }
            if(isset($result['total_items_in_this_category']))
            {
                $MeliCategorie->meli_categorie_total_items_in_this_category = $result['total_items_in_this_category'];
            }
            else
            {
                $MeliCategorie->meli_categorie_total_items_in_this_category = null;
            }
            if(isset($result['attribute_types']))
            {
                $MeliCategorie->meli_categorie_attribute_types = $result['attribute_types'];
            }
            else
            {
                $MeliCategorie->meli_categorie_attribute_types = 'Não possui';
            }
            if(isset($result['meta_categ_id']))
            {
                $MeliCategorie->meli_categorie_meta_categ_id = $result['meta_categ_id'];
            }
            else
            {
                $MeliCategorie->meli_categorie_meta_categ_id = 'Não possui';
            }
            if(isset($result['attributable']))
            {
                $MeliCategorie->meli_categorie_attributable = $result['attributable'];
            }
            else
            {
                $MeliCategorie->meli_categorie_attributable = 'Não Possui';
            }
            
            if(isset($result['path_from_root']))
            {
                if(count($result['path_from_root']) > 1)
                {
                    $j = count($result['path_from_root'])-2;
                    $MeliParent = new MeliCategories;
                    $MeliParent->meli_categorie_id_original = $result['path_from_root'][$j]['id'];
                    $parentId = $MeliParent->returnId();
                    //echo '<br/> parent Id = '.$parentId.'<br/>';
                    //echo '<br/> parent Id result = '.$result['path_from_root'][$j]['id'].'<br/>';
                    //echo '<br/>'.$result['path_from_root'][$j]['id'].' - '.$result['path_from_root'][$j]['name'].'<br/>';
                    $MeliCategorie->meli_categorie_id_parent = $parentId;
                }
            }
            
            $verifica = $MeliCategorie->conferir();
            if($verifica == false)
            {
                $MeliCategorie->save();
            }
            $meliCategorieSettings = new MeliCategoriesSettings();
            
            //Salvar Meli Categorie ID
            if(empty($MeliCategorie->meli_categorie_id))
            {
                $meliCategorieSettings->meli_categorie_id = $MeliCategorie->returnId();
            }
            else
            {
                $meliCategorieSettings->meli_categorie_id = $MeliCategorie->meli_categorie_id;
            }
            $meliCategorieSettings->meli_categorie_setting_adult_content = $result['settings']['adult_content'];
            $meliCategorieSettings->meli_categorie_setting_buying_allowed = $result['settings']['buying_allowed'];
            if(empty($result['settings']['catalog_domain']))
            {
                $meliCategorieSettings->meli_categorie_setting_catalog_domain = "Não Especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_catalog_domain = $result['settings']['catalog_domain'];
            }
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
            if(empty($result['settings']['minimum_price']))
            {
                $meliCategorieSettings->meli_categorie_setting_minimum_price = "Não especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_minimum_price = $result['settings']['minimum_price'];
            }
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
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_price = false;
            }
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
                $meliCategorieSettings->meli_categorie_setting_vertical = $result['settings']['vertical'];
            }
            $confereCategorieId = $meliCategorieSettings->Confere_Categorie_Id();
            if($confereCategorieId == TRUE)
            {
                $meliCategorieSettings->update();
            }
            else
            {
                $meliCategorieSettings->save();
            }
            //Salvar Meli Buying Modes
            for($j=0;$j<count($result['settings']['buying_modes']);$j++)
            {
                $meliBuyingModes = new MeliBuyingModes();
                $meliBuyingModes->meli_buying_mode_name = $result['settings']['buying_modes'][$j];
                $confereBuyigModes = $meliBuyingModes->conferir();
                if($confereBuyigModes == TRUE)
                {
                    $meliBuyingModes->meli_buying_mode_id = $meliBuyingModes->returnId();
                }
                else
                {
                    $meliBuyingModes->save();
                }
                $meliCatSetBuyMod = new MeliCatSetBuyMod();
                $meliCatSetBuyMod->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetBuyMod->meli_buying_mode_id = $meliBuyingModes->meli_buying_mode_id;
                $confereMeliCatSetBuyMod = $meliCatSetBuyMod->conferir();
                if($confereMeliCatSetBuyMod == false)
                {
                    $meliCatSetBuyMod->save();
                }
            }
            //Salvar Currencies
            for($j=0;$j<count($result['settings']['currencies']);$j++)
            {
                $meliCurrencies = new MeliCurrencies();
                $meliCurrencies->meli_currencie_name = $result['settings']['currencies'][$j];
                $confereCurrencie = $meliCurrencies->conferir();
                if($confereCurrencie == TRUE)
                {
                    $meliCurrencies->meli_currencie_id = $meliCurrencies->returnId();
                }
                else
                {
                    $meliCurrencies->save();
                }
                $meliCatSetCur = new MeliCatSetCur();
                $meliCatSetCur->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetCur->meli_currencie_id = $meliCurrencies->meli_currencie_id;
                $confereMeliCatSetCur = $meliCatSetCur->conferir();
                if($confereMeliCatSetCur == false)
                {
                    $meliCatSetCur->save();
                }
            }
            //Salvar Item Conditions
            for($j=0;$j<count($result['settings']['item_conditions']);$j++)
            {
                $meliItemConditions = new MeliItemConditions();
                $meliItemConditions->meli_item_condition_name = $result['settings']['item_conditions'][$j];
                $confereItemConditions = $meliItemConditions->conferir();
                if($confereItemConditions == TRUE)
                {
                    $meliItemConditions->meli_item_condition_id = $meliItemConditions->returnId();
                }
                else
                {
                    $meliItemConditions->save();
                }
                $meliCatSetIteCon = new MeliCatSetIteCon();
                $meliCatSetIteCon->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetIteCon->meli_item_condition_id = $meliItemConditions->meli_item_condition_id;
                $confereCatSetIteCon = $meliCatSetIteCon->conferir();
                if($confereCatSetIteCon == false)
                {
                    $meliCatSetIteCon->save();
                }   
            }
            //Salvar Mirror Slave Categorie
            for($j=0;$j<count($result['settings']['mirror_slave_categories']);$j++)
            {
                $meliMirrorSlaveCategories = new MeliMirrorSlaveCategories();
                $meliMirrorSlaveCategories->meli_mirror_slave_categorie_name = $result['settings']['mirror_slave_categories'][$j];
                $confereMirrorSlaveCategories = $meliMirrorSlaveCategories->conferir();
                if($confereMirrorSlaveCategories == TRUE)
                {
                    $meliMirrorSlaveCategories->meli_mirror_slave_categorie_id = $meliMirrorSlaveCategories->returnId();
                }
                else
                {
                    $meliMirrorSlaveCategories->save();
                }
                $meliCatSetMirSlaCat = new MeliCatSetMirSlaCat();
                $meliCatSetMirSlaCat->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetMirSlaCat->meli_mirror_slave_categorie_id = $meliMirrorSlaveCategories->meli_mirror_slave_categorie_id;
                $confereCatSetMirSlaCat = $meliCatSetMirSlaCat->conferir();
                if($confereCatSetMirSlaCat == false)
                {
                    $meliCatSetMirSlaCat->save();
                }
            }
            //Salvar Restrictions
            for($j=0;$j<count($result['settings']['restrictions']);$j++)
            {
                $meliRestrictions = new MeliRestrictions();
                $meliRestrictions->meli_restriction_name = $result['settings']['restrictions'][$j];
                $confereRestrictions = $meliRestrictions->conferir();
                if($confereRestrictions == TRUE)
                {
                    $meliRestrictions->meli_restriction_id = $meliRestrictions->returnId();
                }
                else
                {
                    $meliRestrictions->save();
                }
                $meliCatSetRes = new MeliCatSetRes();
                $meliCatSetRes->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetRes->meli_restriction_id = $meliRestrictions->meli_restriction_id;
                $confereCatSetRes = $meliCatSetRes->conferir();
                if($confereCatSetRes == false)
                {
                    $meliCatSetRes->save();
                }
            }
            //Salvar Shipping Modes
            for($j=0;$j<count($result['settings']['shipping_modes']);$j++)
            {
                $meliShippingModes = new MeliShippingModes();
                $meliShippingModes->meli_shipping_mode_name = $result['settings']['shipping_modes'][$j];
                $confereShippingModes = $meliShippingModes->conferir();
                if($confereShippingModes == TRUE)
                {
                    $meliShippingModes->meli_shipping_mode_id = $meliShippingModes->returnId();
                }
                else
                {
                    $meliShippingModes->save();
                }
                $meliCatSetShiMod = new MeliCatSetShiMod();
                $meliCatSetShiMod->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetShiMod->meli_shipping_mode_id = $meliShippingModes->meli_shipping_mode_id;
                $confereCatSetShiMod = $meliCatSetShiMod->conferir();
                if($confereCatSetShiMod == false)
                {
                    $meliCatSetShiMod->save();
                }
            }
            //Salvar Shipping Options
            for($j=0;$j<count($result['settings']['shipping_options']);$j++)
            {
                $meliShippingOptions = new MeliShippingOptions();
                $meliShippingOptions->meli_shipping_options_name = $result['settings']['shipping_options'][$j];
                $confereShippingOptions = $meliShippingOptions->conferir();
                if($confereShippingOptions == TRUE)
                {
                    $meliShippingOptions->meli_shipping_options_id = $meliShippingOptions->returnId();
                }
                else
                {
                    $meliShippingOptions->save();
                }
                $meliCatSetShiOpt = new MeliCatSetShiOpt();
                $meliCatSetShiOpt->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetShiOpt->meli_shipping_options_id = $meliShippingOptions->meli_shipping_options_id;
                $confereCatSetShiOpt = $meliCatSetShiOpt->conferir();
                if($confereCatSetShiOpt == false)
                {
                    $meliCatSetShiOpt->save();
                }
            }
            //Salvar Tags
            for($j=0;$j<count($result['settings']['tags']);$j++)
            {
                $meliTags = new MeliTags();
                $meliTags->meli_tag_name = $result['settings']['tags'][$j];
                $confereTags = $meliTags->conferir();
                if($confereTags == TRUE)
                {
                    $meliTags->meli_tag_id = $meliTags->returnId();
                }
                else
                {
                    $meliTags->save();
                }
                $meliCatSetTag = new MeliCatSetTag();
                $meliCatSetTag->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetTag->meli_tag_id = $meliTags->meli_tag_id;
                $confereCatSetTag = $meliCatSetTag->conferir();
                if($confereCatSetTag == false)
                {
                    $meliCatSetTag->save();
                }
            }
            $cont++;
        }
        $success = $cont.' categorias Salvas Com Sucesso!';
        return redirect()->action('Painel\MeliCategoriesController@buscarPrincipal')->with(compact('success'));
    }
    public function salvarArvore($request)
    {
        $cont=0;
        //print_r($request);
        //echo "<br/>".count($request->id_categorie)."<br/>";
        for ($i=0;$i<count($request);$i++)
        {   
            $MeliCategorie = new MeliCategories;
            $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
            $MeliCategorie->meli_categorie_id_original = $request[$i]['id'];
            $MeliCategorie->meli_categorie_name = $request[$i]['name'];
            $MeliCategorie->meli_categorie_url_api = "https://api.mercadolibre.com/categories/".$request[$i]['id'];
            $result = $meli->get($MeliCategorie->meli_categorie_url_api);
            $result = $result["body"];
            //print_r($result);
            $result = json_decode(json_encode($result), True);
            if(isset($result['picture']))
            {
                $MeliCategorie->meli_categorie_picture = $result['picture'];
            }
            else
            {
                $MeliCategorie->meli_categorie_picture = 'Não possui';
            }
            if(isset($result['permalink']))
            {
                $MeliCategorie->meli_categorie_permalink = $result['permalink'];
            }
            else
            {
                $MeliCategorie->meli_categorie_permalink = 'Não possui';
            }
            if(isset($result['total_items_in_this_category']))
            {
                $MeliCategorie->meli_categorie_total_items_in_this_category = $result['total_items_in_this_category'];
            }
            else
            {
                $MeliCategorie->meli_categorie_total_items_in_this_category = null;
            }
            if(isset($result['attribute_types']))
            {
                $MeliCategorie->meli_categorie_attribute_types = $result['attribute_types'];
            }
            else
            {
                $MeliCategorie->meli_categorie_attribute_types = 'Não possui';
            }
            if(isset($result['meta_categ_id']))
            {
                $MeliCategorie->meli_categorie_meta_categ_id = $result['meta_categ_id'];
            }
            else
            {
                $MeliCategorie->meli_categorie_meta_categ_id = 'Não possui';
            }
            if(isset($result['attributable']))
            {
                $MeliCategorie->meli_categorie_attributable = $result['attributable'];
            }
            else
            {
                $MeliCategorie->meli_categorie_attributable = 'Não Possui';
            }
            
            if(isset($result['path_from_root']))
            {
                if(count($result['path_from_root']) > 1)
                {
                    $j = count($result['path_from_root'])-2;
                    $MeliParent = new MeliCategories;
                    $MeliParent->meli_categorie_id_original = $result['path_from_root'][$j]['id'];
                    $parentId = $MeliParent->returnId();
                    //echo '<br/> parent Id = '.$parentId.'<br/>';
                    //echo '<br/> parent Id result = '.$result['path_from_root'][$j]['id'].'<br/>';
                    //echo '<br/>'.$result['path_from_root'][$j]['id'].' - '.$result['path_from_root'][$j]['name'].'<br/>';
                    $MeliCategorie->meli_categorie_id_parent = $parentId;
                }
            }
            
            $verifica = $MeliCategorie->conferir();
            if($verifica == false)
            {
                $MeliCategorie->save();
            }
            $meliCategorieSettings = new MeliCategoriesSettings();
            
            //Salvar Meli Categorie ID
            if(empty($MeliCategorie->meli_categorie_id))
            {
                $meliCategorieSettings->meli_categorie_id = $MeliCategorie->returnId();
            }
            else
            {
                $meliCategorieSettings->meli_categorie_id = $MeliCategorie->meli_categorie_id;
            }
            $meliCategorieSettings->meli_categorie_setting_adult_content = $result['settings']['adult_content'];
            $meliCategorieSettings->meli_categorie_setting_buying_allowed = $result['settings']['buying_allowed'];
            if(empty($result['settings']['catalog_domain']))
            {
                $meliCategorieSettings->meli_categorie_setting_catalog_domain = "Não Especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_catalog_domain = $result['settings']['catalog_domain'];
            }
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
            if(empty($result['settings']['minimum_price']))
            {
                $meliCategorieSettings->meli_categorie_setting_minimum_price = "Não especificado";
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_minimum_price = $result['settings']['minimum_price'];
            }
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
            }
            else
            {
                $meliCategorieSettings->meli_categorie_setting_price = false;
            }
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
                $meliCategorieSettings->meli_categorie_setting_vertical = $result['settings']['vertical'];
            }
            $confereCategorieId = $meliCategorieSettings->Confere_Categorie_Id();
            if($confereCategorieId == TRUE)
            {
                $meliCategorieSettings->update();
            }
            else
            {
                $meliCategorieSettings->save();
            }
            //Salvar Meli Buying Modes
            for($j=0;$j<count($result['settings']['buying_modes']);$j++)
            {
                $meliBuyingModes = new MeliBuyingModes();
                $meliBuyingModes->meli_buying_mode_name = $result['settings']['buying_modes'][$j];
                $confereBuyigModes = $meliBuyingModes->conferir();
                if($confereBuyigModes == TRUE)
                {
                    $meliBuyingModes->meli_buying_mode_id = $meliBuyingModes->returnId();
                }
                else
                {
                    $meliBuyingModes->save();
                }
                $meliCatSetBuyMod = new MeliCatSetBuyMod();
                $meliCatSetBuyMod->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetBuyMod->meli_buying_mode_id = $meliBuyingModes->meli_buying_mode_id;
                $confereMeliCatSetBuyMod = $meliCatSetBuyMod->conferir();
                if($confereMeliCatSetBuyMod == false)
                {
                    $meliCatSetBuyMod->save();
                }
            }
            //Salvar Currencies
            for($j=0;$j<count($result['settings']['currencies']);$j++)
            {
                $meliCurrencies = new MeliCurrencies();
                $meliCurrencies->meli_currencie_name = $result['settings']['currencies'][$j];
                $confereCurrencie = $meliCurrencies->conferir();
                if($confereCurrencie == TRUE)
                {
                    $meliCurrencies->meli_currencie_id = $meliCurrencies->returnId();
                }
                else
                {
                    $meliCurrencies->save();
                }
                $meliCatSetCur = new MeliCatSetCur();
                $meliCatSetCur->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetCur->meli_currencie_id = $meliCurrencies->meli_currencie_id;
                $confereMeliCatSetCur = $meliCatSetCur->conferir();
                if($confereMeliCatSetCur == false)
                {
                    $meliCatSetCur->save();
                }
            }
            //Salvar Item Conditions
            for($j=0;$j<count($result['settings']['item_conditions']);$j++)
            {
                $meliItemConditions = new MeliItemConditions();
                $meliItemConditions->meli_item_condition_name = $result['settings']['item_conditions'][$j];
                $confereItemConditions = $meliItemConditions->conferir();
                if($confereItemConditions == TRUE)
                {
                    $meliItemConditions->meli_item_condition_id = $meliItemConditions->returnId();
                }
                else
                {
                    $meliItemConditions->save();
                }
                $meliCatSetIteCon = new MeliCatSetIteCon();
                $meliCatSetIteCon->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetIteCon->meli_item_condition_id = $meliItemConditions->meli_item_condition_id;
                $confereCatSetIteCon = $meliCatSetIteCon->conferir();
                if($confereCatSetIteCon == false)
                {
                    $meliCatSetIteCon->save();
                }   
            }
            //Salvar Mirror Slave Categorie
            for($j=0;$j<count($result['settings']['mirror_slave_categories']);$j++)
            {
                $meliMirrorSlaveCategories = new MeliMirrorSlaveCategories();
                $meliMirrorSlaveCategories->meli_mirror_slave_categorie_name = $result['settings']['mirror_slave_categories'][$j];
                $confereMirrorSlaveCategories = $meliMirrorSlaveCategories->conferir();
                if($confereMirrorSlaveCategories == TRUE)
                {
                    $meliMirrorSlaveCategories->meli_mirror_slave_categorie_id = $meliMirrorSlaveCategories->returnId();
                }
                else
                {
                    $meliMirrorSlaveCategories->save();
                }
                $meliCatSetMirSlaCat = new MeliCatSetMirSlaCat();
                $meliCatSetMirSlaCat->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetMirSlaCat->meli_mirror_slave_categorie_id = $meliMirrorSlaveCategories->meli_mirror_slave_categorie_id;
                $confereCatSetMirSlaCat = $meliCatSetMirSlaCat->conferir();
                if($confereCatSetMirSlaCat == false)
                {
                    $meliCatSetMirSlaCat->save();
                }
            }
            //Salvar Restrictions
            for($j=0;$j<count($result['settings']['restrictions']);$j++)
            {
                $meliRestrictions = new MeliRestrictions();
                $meliRestrictions->meli_restriction_name = $result['settings']['restrictions'][$j];
                $confereRestrictions = $meliRestrictions->conferir();
                if($confereRestrictions == TRUE)
                {
                    $meliRestrictions->meli_restriction_id = $meliRestrictions->returnId();
                }
                else
                {
                    $meliRestrictions->save();
                }
                $meliCatSetRes = new MeliCatSetRes();
                $meliCatSetRes->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetRes->meli_restriction_id = $meliRestrictions->meli_restriction_id;
                $confereCatSetRes = $meliCatSetRes->conferir();
                if($confereCatSetRes == false)
                {
                    $meliCatSetRes->save();
                }
            }
            //Salvar Shipping Modes
            for($j=0;$j<count($result['settings']['shipping_modes']);$j++)
            {
                $meliShippingModes = new MeliShippingModes();
                $meliShippingModes->meli_shipping_mode_name = $result['settings']['shipping_modes'][$j];
                $confereShippingModes = $meliShippingModes->conferir();
                if($confereShippingModes == TRUE)
                {
                    $meliShippingModes->meli_shipping_mode_id = $meliShippingModes->returnId();
                }
                else
                {
                    $meliShippingModes->save();
                }
                $meliCatSetShiMod = new MeliCatSetShiMod();
                $meliCatSetShiMod->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetShiMod->meli_shipping_mode_id = $meliShippingModes->meli_shipping_mode_id;
                $confereCatSetShiMod = $meliCatSetShiMod->conferir();
                if($confereCatSetShiMod == false)
                {
                    $meliCatSetShiMod->save();
                }
            }
            //Salvar Shipping Options
            for($j=0;$j<count($result['settings']['shipping_options']);$j++)
            {
                $meliShippingOptions = new MeliShippingOptions();
                $meliShippingOptions->meli_shipping_options_name = $result['settings']['shipping_options'][$j];
                $confereShippingOptions = $meliShippingOptions->conferir();
                if($confereShippingOptions == TRUE)
                {
                    $meliShippingOptions->meli_shipping_options_id = $meliShippingOptions->returnId();
                }
                else
                {
                    $meliShippingOptions->save();
                }
                $meliCatSetShiOpt = new MeliCatSetShiOpt();
                $meliCatSetShiOpt->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetShiOpt->meli_shipping_options_id = $meliShippingOptions->meli_shipping_options_id;
                $confereCatSetShiOpt = $meliCatSetShiOpt->conferir();
                if($confereCatSetShiOpt == false)
                {
                    $meliCatSetShiOpt->save();
                }
            }
            //Salvar Tags
            for($j=0;$j<count($result['settings']['tags']);$j++)
            {
                $meliTags = new MeliTags();
                $meliTags->meli_tag_name = $result['settings']['tags'][$j];
                $confereTags = $meliTags->conferir();
                if($confereTags == TRUE)
                {
                    $meliTags->meli_tag_id = $meliTags->returnId();
                }
                else
                {
                    $meliTags->save();
                }
                $meliCatSetTag = new MeliCatSetTag();
                $meliCatSetTag->meli_categorie_setting_id = $meliCategorieSettings->returnId();
                $meliCatSetTag->meli_tag_id = $meliTags->meli_tag_id;
                $confereCatSetTag = $meliCatSetTag->conferir();
                if($confereCatSetTag == false)
                {
                    $meliCatSetTag->save();
                }
            }
            $cont++;
        }
        $success = $cont.' categorias Salvas Com Sucesso!';
        return redirect()->action('Painel\MeliCategoriesController@buscarPrincipal')->with(compact('success'));
    }
}

