<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\Pessoas;

class PessoasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Pessoas;

    public function __construct(Pessoas $Pessoas) {

        $this->Pessoas = $Pessoas;
    }
    public function index()
    {
        $pessoas = Pessoas::all();
        return view('site.Pessoas');
    }
    public function buscar(Request $request, $tipo, $json)
    {
        $json = json_decode($json, true); 
        if($tipo=='pesquisa')
        {
            $tipo = $request->tipo;
            $div = $request->div;
            return view ('site.Pessoas', compact('tipo', 'div'));
        }
        else if ($tipo =='resultado')
        {
            if($json[0]['value'] <> '')
            {
                $id = $json[0]['value'];
                $resul_clientes = DB::connection('odbc')->select("select * from pessoas where id = $id");
                $div = $json[7]['value'];
                return view ('site.Pessoas', compact('tipo', 'resul_clientes', 'div'));
            }
            else
            {
                $nome = strtoupper($json[1]['value']);
                $fantasia = strtoupper($json[2]['value']);
                $cidade = strtoupper($json[3]['value']);
                $cpfcnpj = strtoupper($json[4]['value']);
                $fone = strtoupper($json[5]['value']);
                $resul_clientes = DB::connection('odbc')->select("select ID, 
                                                                         Nome, 
                                                                         Fantasia, 
                                                                         Endereco, 
                                                                         Cidade, 
                                                                         CPFCNPJ, 
                                                                         Fone1, 
                                                                         Fone2, 
                                                                         Obs
                                                                    from pessoas
                                                                   where nome like '%$nome%'
                                                                     and fantasia like '%$fantasia%'
                                                                     and cidade like '%$cidade%'
                                                                     and cpfcnpj like '%$cpfcnpj%'
                                                                     and (fone1 like '%$fone%'
                                                                      or fone2 like '%$fone%')
                                                                order by 2");
                $div = $json[7]['value'];
                return view ('site.Pessoas', compact('tipo', 'resul_clientes', 'div'));
                
            }
        }
        else if ($tipo =='blur')
        {
            if(isset($json))
            {
                $id = $json;
                $resul_clientes = DB::connection('odbc')->select("select * from pessoas where id = $id");
                return view ('site.Pessoas', compact('tipo', 'resul_clientes'));
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
