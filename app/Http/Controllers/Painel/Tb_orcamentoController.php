<?php

namespace retensul\Http\Controllers\Painel;
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\Tb_orcamento;
use retensul\Models\Tb_pedido;
use retensul\Models\Tb_orcamento_itens;
use retensul\Models\Tb_pedido_itens;
use retensul\Models\Tb_pedido_itens_fornecedores;
use retensul\Models\Vendedores;
use retensul\Models\Pessoas;

class Tb_orcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Tb_orcamento;

    public function __construct(Tb_orcamento $Tb_orcamento) {

        $this->Tb_orcamento = $Tb_orcamento;
    }
    public function index()
    {
        $orcamentos = tb_orcamento::select('*')->where('tb_orcamento_nivel','=','P')->get()->sortByDesc('tb_orcamento_id');
        $vendedores = Vendedores::all();
//        $nome_cliente = DB::connection('odbc')->select('select * from pessoas where id = 1554');
        //echo $vendedores;
        return view('site.Orcamento', compact('orcamentos', 'vendedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tipo = 'incluir';
        $vendedores = Vendedores::all();
        return view('Site.Orcamento_add_edit', compact('vendedores', 'tipo'));
    }
    public function salvar(Request $request)
    {
        if($request->tipo == 1)
        {
            $Orcamento = new Tb_orcamento;
            $Orcamento->tb_orcamento_id_cliente = $request->id_cliente;
            $Orcamento->tb_orcamento_contato = $request->contato_cliente;
            $Orcamento->tb_orcamento_telefone = $request->telefone_cliente;
            $Orcamento->tb_orcamento_email = $request->email_cliente;
            $Orcamento->tb_orcamento_data = implode("-",array_reverse(explode("/",$request->data_orcamento)));
            $Orcamento->tb_orcamento_id_vendedor = $request->vendedor;
            $Orcamento->tb_orcamento_id_plano = $request->id_plano_pagamento;
            $Orcamento->tb_orcamento_obs = $request->obs_pedido;
            $Orcamento->tb_orcamento_nivel = 'P';
            $total_orcamento = 0;
            for ($i=0;$i<count($request->tipo_produto);$i++)
            {
                $total_orcamento = $total_orcamento + $request->valor_total_produto[$i]; 
            }
            $Orcamento->tb_orcamento_total_orcamento = $total_orcamento;
            $Orcamento->save();
            $cont=1;
            for ($i=0;$i<count($request->tipo_produto);$i++)
            {
                $OrcamentoItens = new Tb_orcamento_itens;
                $OrcamentoItens->tb_orcamento_id = $Orcamento->tb_orcamento_id;
                $OrcamentoItens->tb_orcamento_itens_seq = $cont;
                $OrcamentoItens->tb_orcamento_itens_id_produto = $request->id_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_tipo = $request->tipo_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_referencia_produto = $request->referencia_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_descricao_produto = $request->descricao_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_marca_produto = $request->marca_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_qt_produto = $request->qt_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_un_produto = $request->un_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_preco_lista = $request->preco_lista_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_percentual_desconto_produto = $request->desconto_percentual_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_valor_desconto_produto = $request->desconto_valor_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_valor_unit_produto = $request->preco_unit_produto[$i];
                $OrcamentoItens->tb_orcamento_itens_valor_total_produto = $request->valor_total_produto[$i];
                $OrcamentoItens->save();  
                $cont++;
            }
        }
        elseif($request->tipo == 2)
        {
            $Pedido = new Tb_pedido;
            $Pedido->tb_pedido_id_cliente = $request->id_cliente;
            $Pedido->tb_pedido_contato = $request->contato_cliente;
            $Pedido->tb_pedido_telefone = $request->telefone_cliente;
            $Pedido->tb_pedido_email = $request->email_cliente;
            $Pedido->tb_pedido_data = implode("-",array_reverse(explode("/",$request->data_orcamento)));;
            $Pedido->tb_pedido_id_vendedor = $request->vendedor;
            $Pedido->tb_pedido_id_plano = $request->id_plano_pagamento;
            $Pedido->tb_pedido_obs = $request->obs_pedido;
            $total_pedido = 0;
            for ($i=0;$i<count($request->tipo_produto);$i++)
            {
                $total_pedido = $total_pedido + $request->valor_total_produto[$i]; 
            }
            $Pedido->tb_pedido_valor_total_pedido = $total_pedido;
            $Pedido->tb_pedido_status = 'A';
            $Pedido->save();
            $cont=1;
            for ($i=0;$i<count($request->tipo_produto);$i++)
            {
                $PedidoItens = new Tb_pedido_itens;
                $PedidoItens->tb_pedido_id = $Pedido->tb_pedido_id;
                $PedidoItens->tb_pedido_itens_seq = $cont;
                $PedidoItens->tb_pedido_itens_id_produto = $request->id_produto[$i];
                $PedidoItens->tb_pedido_itens_referencia_produto = $request->referencia_produto[$i];
                $PedidoItens->tb_pedido_itens_descricao_produto = $request->descricao_produto[$i];
                $PedidoItens->tb_pedido_itens_marca_produto = $request->marca_produto[$i];
                $PedidoItens->tb_pedido_itens_qt_produto = $request->qt_produto[$i];
                $PedidoItens->tb_pedido_itens_preco_lista_produto = $request->preco_lista_produto[$i];
                $PedidoItens->tb_pedido_itens_percentual_desconto_produto = $request->desconto_percentual_produto[$i];
                $PedidoItens->tb_pedido_itens_valor_desconto_produto = $request->desconto_valor_produto[$i];
                $PedidoItens->tb_pedido_itens_valor_unit_produto = $request->preco_unit_produto[$i];
                $PedidoItens->tb_pedido_itens_valor_total_produto = $request->valor_total_produto[$i];
                $PedidoItens->tb_pedido_itens_status_pedido = 'A'; 
                $PedidoItens->tb_pedido_itens_status_estoque = 'F';
                $PedidoItens->tb_pedido_itens_previsao_entrega = '0000-00-00';
                $PedidoItens->save(); 
                $itensFornecedor = new Tb_pedido_itens_fornecedores;
                $itensFornecedor->tb_pedido_itens_id = $PedidoItens->tb_pedido_itens_id;
                $itensFornecedor->tb_pedido_itens_fornecedores_id_fornecedor = '1';
                $itensFornecedor->save();
                $cont++;
            }
        }
        //echo $request;
        $tipo = 'save';
        return view('site.Orcamento_add_edit', compact('tipo'));
        
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
        $Tb_orcamento = new Tb_orcamento;
        $orcamento = $Tb_orcamento->find($id);
        //$Tb_orcamento_itens = new Tb_orcamento_itens;
        $orcamentoItens = Tb_orcamento_itens::select('*')->where('tb_orcamento_id', '=', $id)->get();
        //echo $orcamentoItens;
        $tipo = 'editar';
        $vendedores = Vendedores::all();
        return view('Site.Orcamento_add_edit', compact('vendedores', 'tipo', 'orcamento', 'orcamentoItens'));
    }
    
    public function responder($id)
    {
        //
        $Tb_orcamento = new Tb_orcamento;
        $orcamento = $Tb_orcamento->find($id);
        //$Tb_orcamento_itens = new Tb_orcamento_itens;
        $orcamentoItens = Tb_orcamento_itens::select('*')->where('tb_orcamento_id', '=', $id)->get();
        //echo $orcamentoItens;
        $tipo = 'responder';
        $vendedores = Vendedores::all();
        return view('Site.Orcamento_add_edit', compact('vendedores', 'tipo', 'orcamento', 'orcamentoItens'));
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
        $Orcamento = Tb_orcamento::find($id);
        $Orcamento->tb_orcamento_id_cliente = $request->id_cliente;
        $Orcamento->tb_orcamento_contato = $request->contato_cliente;
        $Orcamento->tb_orcamento_telefone = $request->telefone_cliente;
        $Orcamento->tb_orcamento_email = $request->email_cliente;
        $Orcamento->tb_orcamento_id_vendedor = $request->vendedor;
        $Orcamento->tb_orcamento_id_plano = $request->id_plano_pagamento;
        $Orcamento->tb_orcamento_obs = $request->obs_pedido;
        $total_orcamento = 0;
        for ($i=0;$i<count($request->tipo_produto);$i++)
        {
            $total_orcamento = $total_orcamento + $request->valor_total_produto[$i]; 
        }
        $Orcamento->tb_orcamento_total_orcamento = $total_orcamento;
        
        $Orcamento->save();
        //echo $orcamento;
        $cont=1;
        Tb_orcamento_itens::where('tb_orcamento_id','=',$Orcamento->tb_orcamento_id)->delete();
        for ($i=0;$i<count($request->tipo_produto);$i++)
        {
            $OrcamentoItens = new Tb_orcamento_itens;
            $OrcamentoItens->tb_orcamento_id = $Orcamento->tb_orcamento_id;
            $OrcamentoItens->tb_orcamento_itens_seq = $cont;
            $OrcamentoItens->tb_orcamento_itens_id_produto = $request->id_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_tipo = $request->tipo_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_referencia_produto = $request->referencia_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_descricao_produto = $request->descricao_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_marca_produto = $request->marca_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_qt_produto = $request->qt_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_un_produto = $request->un_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_preco_lista = $request->preco_lista_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_percentual_desconto_produto = $request->desconto_percentual_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_valor_desconto_produto = $request->desconto_valor_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_valor_unit_produto = $request->preco_unit_produto[$i];
            $OrcamentoItens->tb_orcamento_itens_valor_total_produto = $request->valor_total_produto[$i];
            $OrcamentoItens->save();  
            $cont++;
        }
        $tipo = 'save';
        $request->tipo = 'save';
        //echo $tipo;
        return view('site.Orcamento_add_edit', compact('tipo'));
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
        $orcamento = Tb_orcamento::find($id);
        $orcamento->tb_orcamento_nivel = 'F';
        $orcamento->save();
        return redirect()->action('Painel\Tb_orcamentoController@index');
    }
}
