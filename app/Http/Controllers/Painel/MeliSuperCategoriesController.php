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
