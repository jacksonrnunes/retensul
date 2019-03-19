<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\MeliCategories;
use Vcoud\Mercadolibre\Meli;

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
}
