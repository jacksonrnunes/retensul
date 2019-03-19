<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\MeliSuperCategories;
use Vcoud\Mercadolibre\Meli;

class MeliSuperCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $MeliSuperCategories;

    public function __construct(MeliSuperCategories $MeliSuperCategories) {

        $this->MeliSuperCategories = $MeliSuperCategories;
    }
    public function index()
    {
        $MeliSuperCategories = MeliSuperCategories::orderBy('melisupercategories_descricao')->get();
        return view('site.MeliSuperCategories');
    }
    public function buscar()
    {
        $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
        $result = $meli->get('https://api.mercadolibre.com/sites/MLB/categories'); 
        $result = $result["body"];
        $result = json_decode(json_encode($result), True);
        $MeliSuperCategories = MeliSuperCategories::orderBy('melisupercategories_descricao')->get();
        return view('site.MeliSuperCategories', compact('result', 'MeliSuperCategories'));
    }
    public function create()
    {
        //
    }
    
    public function salvar(Request $request)
    {
        $cont=0;
        for ($i=0;$i<count($request->id_categorie);$i++)
        {
            $MeliSuperCategorie = new MeliSuperCategories;
            //echo ($i)."<br/>";
            $MeliSuperCategorie->melisupercategories_id_original = $request->id_categorie[$i];
            $MeliSuperCategorie->melisupercategories_descricao = $request->descricao_categorie[$i];
            $MeliSuperCategorie->melisupercategories_url = "https://api.mercadolibre.com/categories/".$request->id_categorie[$i];
            
            $meli = new Meli('5147268795692492', 'hZ9XuZJnAStRnmoIATKTInw7JCo8HHkn');
            $result = $meli->get($MeliSuperCategorie->melisupercategories_url);
            $result = $result["body"];
            $result = json_decode(json_encode($result), True);
            print_r($result);
            echo $result['id']."<br/>";
            echo $result['name']."<br/>";
            echo $result['picture']."<br/>";
            echo $result['permalink']."<br/>";
            echo $result['total_items_in_this_category']."<br/>";
            echo $result['attribute_types']."<br/>";
            echo $result['settings']['adult_content']."<br/>";
            echo $result['settings']['buying_allowed']."<br/>";
            echo $result['settings']['buying_modes'][0]."<br/>";
            echo $result['settings']['buying_modes'][1]."<br/>";
            echo $result['settings']['catalog_domain']."<br/>";
            echo $result['settings']['coverage_areas']."<br/>";
            echo $result['settings']['currencies'][0]."<br/>";
            echo $result['settings']['fragile']."<br/>";
            echo $result['settings']['immediate_payment']."<br/>";
            echo $result['settings']['item_conditions'][0]."<br/>";
            echo $result['settings']['item_conditions'][1]."<br/>";
            echo $result['settings']['item_conditions'][2]."<br/>";
            echo $result['settings']['items_reviews_allowed']."<br/>";
            echo $result['settings']['listing_allowed']."<br/>";
            echo $result['settings']['max_description_length']."<br/>";
            echo $result['settings']['max_pictures_per_item']."<br/>";
            echo $result['settings']['max_pictures_per_item_var']."<br/>";
            echo $result['settings']['max_sub_title_length']."<br/>";
            echo $result['settings']['max_title_length']."<br/>";
            echo $result['settings']['maximum_price']."<br/>";
            echo $result['settings']['minimum_price']."<br/>";
            echo $result['settings']['mirror_category']."<br/>";
            echo $result['settings']['mirror_master_category']."<br/>";
            //echo $result['settings']['mirror_slave_categories']."<br/>";
            echo $result['settings']['price']."<br/>";
            echo $result['settings']['reservation_allowed']."<br/>";
            //echo $result['settings']['restrictions']."<br/>";
            echo $result['settings']['rounded_address']."<br/>";
            echo $result['settings']['seller_contact']."<br/>";
            echo $result['settings']['shipping_modes'][0]."<br/>";
            echo $result['settings']['shipping_modes'][1]."<br/>";
            echo $result['settings']['shipping_modes'][2]."<br/>";
            echo $result['settings']['shipping_options'][0]."<br/>";
            echo $result['settings']['shipping_profile']."<br/>";
            echo $result['settings']['show_contact_information']."<br/>";
            echo $result['settings']['simple_shipping']."<br/>";
            echo $result['settings']['stock']."<br/>";
            echo $result['settings']['sub_vertical']."<br/>";
            echo $result['settings']['subscribable']."<br/>";
            //echo $result['settings']['tags']."<br/>";
            echo $result['settings']['vertical']."<br/>";
            echo $result['settings']['vip_subdomain']."<br/>";
            echo $result['meta_categ_id']."<br/>";
            echo $result['attributable']."<br/>";
            
            
            //echo $MeliSuperCategorie->melisupercategories_id_original."<br/>";
            //echo $MeliSuperCategorie->melisupercategories_descricao."<br/>";
            //echo $MeliSuperCategorie->melisupercategories_url."<br/>";
            //$MeliSuperCategorie->save();
            //echo($MeliSuperCategorie);        
            $cont++;
        }
        //return redirect(route('MeliSuperCategories.buscar'));
        //return redirect()->action('Painel\MeliSuperCategoriesController@buscar')->with('mesage', 'Salvo Com Sucesso');
        //View::make('/Painel/MeliSuperCategoriesController@buscar');
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
}
