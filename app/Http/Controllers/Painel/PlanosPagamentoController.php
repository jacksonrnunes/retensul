<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\PlanosPagamento;

class PlanosPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $PlanosPagamento;

    public function __construct(PlanosPagamento $PlanosPagamento) {

        $this->PlanosPagamento = $PlanosPagamento;
    }
    public function index()
    {
        $PlanosPagamento = PlanosPagamento::select('ID', 'Descricao' )->get()->sortBy('Descricao');
        //echo $PlanosPagamento;
        return view('site.PlanosPagamento', compact('PlanosPagamento'));
    }
    public function buscar(Request $request, $tipo, $json)
    {
        $json = json_decode($json, true);
        if($tipo == 'pesquisa')
        {
            $PlanosPagamento = PlanosPagamento::select('ID', 'Descricao' )->get()->sortBy('Descricao');
            //echo $PlanosPagamento;
            $div = $request->div;
            return view('site.PlanosPagamento', compact('PlanosPagamento', 'div', 'tipo'));
        }
        else if($tipo == 'blur')
        {
            if(isset($json))
            {
                $id = $json;
                $PlanosPagamento = DB::connection('odbc')->select("select ID, Descricao from planos where id = $id");
                return view ('site.PlanosPagamento', compact('tipo', 'PlanosPagamento'));
            }            
        }
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
