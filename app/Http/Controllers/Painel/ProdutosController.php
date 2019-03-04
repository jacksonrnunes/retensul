<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\Produtos;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Produtos;

    public function __construct(Produtos $Produtos) {

        $this->Produtos = $Produtos;
    }
    public function index()
    {
        $Produtos = Produtos::all();
        return view('site.Pessoas', compact('Produtos'));
    }
    public function buscar(Request $request)
    { 
        if($request->tipo == 'janela')
        {
            $div = $request->div;
            $tipo = $request->tipo;
            //$dados = json_encode($request->dados, JSON_HEX_AMP);
            $dados = json_decode($request->dados);
            if($div == 'incluir_produto')
            {
                return view('site.Produtos', compact('tipo', 'div'));
            }
            else if($div == 'editar_produto')
            {
                //print_r ($dados);
                return view('site.Produtos', compact('tipo', 'div', 'dados'));
            }
            else if($div == 'incluir_produto_resposta')
            {
                //print_r ($dados);
                return view('site.Produtos', compact('tipo', 'div', 'dados'));
            }
            else if($div == 'modal_produto')
            {
                echo $div;
                return view('site.Produtos', compact('tipo', 'div'));
            }
        }
        if($request->tipo == 'pesquisa')
        {
            $div = $request->div;
            $tipo = $request->tipo;
            return view('site.Produtos', compact('tipo', 'div'));
        }
        if($request->tipo == 'resultado')
        {
            $tipo = $request->tipo;
            $json = json_decode($request->json, true);
            if($json[0]['value'] <> '')
            {
                $id = $json[0]['value'];
                $resul_produtos = DB::connection('odbc')->select("SELECT produtosprincipal.id as id, 
                                                                         produtosprincipal.descricao as descricao,
                                                                         produtosprincipal.marca as marca,
                                                                         round(produtosprincipal.precovenda1,2) as produto_preco_lista,
                                                                         produtosreferencia.referencia as referencia,
                                                                         produtosprincipal.UNVenda as unidade
                                                                    FROM produtosprincipal, produtosreferencia 
                                                                   where produtosprincipal.id = produtosreferencia.id_produto
                                                                     and produtosprincipal.id = $id
                                                                ORDER BY 2");
                
                
                $div = $json[4]['value'];
                return view('site.Produtos', compact('tipo', 'resul_produtos', 'div'));
            }
            else
            {
                $referencia = $json[1]['value'];
                $descricao = strtoupper($json[2]['value']);
                $marca = strtoupper($json[3]['value']);
                $query = "SELECT produtosprincipal.id as id, 
                                 produtosprincipal.descricao as descricao,
                                 produtosprincipal.marca as marca,
                                 produtosprincipal.precovenda1 as produto_preco_lista,
                                 produtosreferencia.referencia as referencia,
                                 produtosprincipal.UNVenda as unidade
                            FROM produtosprincipal, produtosreferencia 
                           where produtosprincipal.id = produtosreferencia.id_produto";
                if($referencia <> '')
                {
                    $query .= " and produtosreferencia.referencia like '$referencia%'";
                }
                if($descricao <> '')
                {
                    $query .= " and produtosprincipal.descricao like '$descricao%'";
                }
                if($marca <> '')
                {
                    $query .= " and produtosprincipal.marca like '$marca%'";
                }
                $query .= "     and produtosprincipal.ativo <> 'N'
                      ORDER BY 2";
                $resul_produtos = DB::connection('odbc')->select($query);
                
                $div = $json[4]['value'];
                return view('site.Produtos', compact('tipo', 'resul_produtos', 'div'));
                
            }
            //$div = $request->div;
            //return view('site.Produtos', compact('tipo', 'div'));
        }
        else if ($request->tipo =='blur')
        {
            if(isset($request->json))
            {
                $id = $request->json;
                $tipo = $request->tipo;
                $resul_produtos = DB::connection('odbc')->select("SELECT produtosprincipal.id as id, 
                                                                         produtosprincipal.descricao as descricao,
                                                                         produtosprincipal.marca as marca,
                                                                         round(produtosprincipal.precovenda1,2) as produto_preco_lista,
                                                                         produtosreferencia.referencia as referencia,
                                                                         produtosprincipal.UNVenda as unidade
                                                                    FROM produtosprincipal, produtosreferencia 
                                                                   where produtosprincipal.id = produtosreferencia.id_produto
                                                                     and produtosprincipal.id = $id
                                                                ORDER BY 2");
                //$resul_produtos = DB::connection('odbc')->select("SELECT * from produtosprincipal where id = 150");
                return view('site.Produtos', compact('tipo', 'resul_produtos'));
            }
        }
        else if ($request->tipo =='blurref')
        {
            //echo $json;
            if(isset($request->json))
            {
                
                $referencia = $request->json;
                $tipo = 'blur';
                $resul_produtos = DB::connection('odbc')->select("SELECT produtosprincipal.id as id, 
                                                                         produtosprincipal.descricao as descricao,
                                                                         produtosprincipal.marca as marca,
                                                                         round(produtosprincipal.precovenda1,2) as produto_preco_lista,
                                                                         produtosreferencia.referencia as referencia,
                                                                         produtosprincipal.UNVenda as unidade
                                                                    FROM produtosprincipal, produtosreferencia 
                                                                   where produtosprincipal.id = produtosreferencia.id_produto
                                                                     and produtosreferencia.referencia = '$referencia'
                                                                ORDER BY 2");
                return view('site.Produtos', compact('tipo', 'resul_produtos'));
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
