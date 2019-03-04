@php 
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\Tb_orcamento;
use retensul\Models\Vendedores;
use retensul\Models\Pessoas;
@endphp
@extends('layouts.template_janela')
@section('principal')
@if($tipo == 'responder')


<form name="form_orcamento" id="form_orcamento" action="@if(isset($orcamento)) {{route('orcamento.update', $orcamento->tb_orcamento_id)}} @endif" method="POST">
{{ csrf_field() }}
<div id="corpo">
</div>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav_dados_cliente" role="tab">Dados do cliente</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav_produtos" role="tab">Produtos</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_dados_cliente" role="tabpanel">
      <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:80px;">Cliente</legend>
        <div class="row">
          <div class="col-sm-2">              
              <div class="col-sm-10 exibe-id">
                  <br />
                  <h4>Orçamento Nr {{$orcamento->tb_orcamento_id}}</h4>  
                  <br />
              </div>              
          </div>
          <div class="col-sm-10">
          <div class="row">
              <label for="id_cliente" class="col-sm-1 custom-control col-form-label">Código: </label>
              <div class='col-sm-2'> 
                <div class="input-group">
                    <input id="id_cliente" name="id_cliente" type="number" value="{{$orcamento->tb_orcamento_id_cliente or old('id_cliente')}}" class="form-control disabled" disabled="disabled" readonly="readonly" placeholder="ID Cliente" required>
                </div>
              </div>
              @if(isset($orcamento))
              @php $dados_cliente = DB::connection('odbc')->select("select * from pessoas where id = $orcamento->tb_orcamento_id_cliente");@endphp
              @endif
              <label for="nome_cliente" class="col-sm-1 custom-control col-form-label">Nome: </label>
              <input name="nome_cliente" id="nome_cliente" class="col-sm-6 form-control disabled" type="text" value="{{$dados_cliente[0]->Nome or old('nome_cliente')}}" placeholder="Campo não editável, selecione o cliente pelo ID" disabled="disabled" readonly="readonly" required>
          </div>
        <div class="row">
          <label for="contato_cliente" class="col-sm-1 custom-control col-form-label">Contato: </label>
          <input name="contato_cliente" id="contato_cliente" class="col-sm-2 form-control disabled" disabled="disabled" readonly="readonly" type="text" value="{{$orcamento->tb_orcamento_contato or old('contato_cliente')}}" placeholder="Contato" required>
          <label for="telefone_cliente" class="col-sm-1 custom-control col-form-label">Telefone: </label>
          <input name="telefone_cliente" id="telefone_cliente" class="col-sm-3 form-control disabled" disabled="disabled" readonly="readonly" type="tel" value="{{$orcamento->tb_orcamento_telefone or old('telefone_cliente')}}" placeholder="(00)0 0000-0000" required>
          <label for="email_cliente" class="col-sm-1 custom-control col-form-label">E-mail: </label>
          <input name="email_cliente" class="col-sm-2 form-control disabled" disabled="disabled" readonly="readonly" id="email_cliente" type="email" value="{{$orcamento->tb_orcamento_email or old('email_cliente')}}" placeholder="example@host.com" onChange="checkMail()" ><br>
        </div>
        <div class="row">          
          <label for="obs_cliente" class="col-sm-2 custom-control col-form-label" >Observações: </label>
          <textarea class="col-sm-6 form-control disabled"  name="obs_cliente" id="obs_cliente" value="{{$dados_cliente[0]->Obs or old('obs_cliente')}}" disabled="disabled" readonly="readonly" placeholder="Observação do cliente"></textarea>
        </div>
          </div>
        </div>
       </fieldset>
       <fieldset class="fieldset_busca col-sm-12">
         <legend class="legend_busca" style="max-width:190px;">Dados do Pedido</legend>
         <div class="row">
             <label class="col-sm-1 custom-control col-form-label">Data:</label>
             <input class="col-sm-1 form-control disabled"  type="text" id="data_orcamento" name="data_orcamento" value="@if( isset($orcamento->tb_orcamento_data)) {{implode("/",array_reverse(explode("-",$orcamento->tb_orcamento_data)))}} @else @php $data = date('d/m/Y'); echo $data; @endphp @endif" readonly="readonly" disabled="disabled" />     
             <label for="vendedor" class="col-sm-2 custom-control col-form-label"> Vendedor:</label>
             <input id="vendedor" name="vendedor" class="col-sm-2 form-control disabled"  disabled="disabled" readonly="readonly" value="@if(isset($vendedores)) @foreach($vendedores as $item) @if($orcamento->tb_orcamento_id_vendedor == $item->ID) {{$item->ID}} - {{$item->Nome}} @endif @endforeach @endif" required>
             <label for="tipo" class="col-sm-1 custom-control col-form-label">Tipo:</label>
             <input class="col-sm-2 form-control disabled"  type="text" id="tipo" name="tipo" value="1 - Orcamento" readonly="readonly" disabled="disabled" />     
         </div>
         <div class="row">
             <label for="id_plano_pagamento" class="col-sm-2 custom-control col-form-label">Plano de Pagamento:</label>     
             <div class='col-sm-1'> 
                <div class="input-group">
                  <input name="id_plano_pagamento" id="id_plano_pagamento" type="number" value="{{$orcamento->tb_orcamento_id_plano or old('id_plano_pagamento')}}" class="form-control disabled" readonly="readonly" disabled="disabled"  placeholder="Buscar Plano" required>
                </div>
             </div>
             @if(isset($orcamento))
             @php $dados_plano = DB::connection('odbc')->select("select * from planos where id = $orcamento->tb_orcamento_id_plano");@endphp
             @endif
             <input name="descricao_plano_pagamento" id="descricao_plano_pagamento" class="col-sm-2 form-control disabled" type="text" value="{{$dados_plano[0]->Descricao or old('descricao_plano_pagamento')}}" placeholder="Campo não editável" readonly='readonly' disabled="disabled" required>
         </div>
         <div class="row">
            <label for="obs_pedido" class="col-sm-2 custom-control col-form-label">Observações:</label>
            <textarea name="obs_pedido" id="obs_pedido" placeholder="Digite aqui a observação do orcamento/pedido" rows="6" class="col-sm-6 form-control disabled" readonly="readonly" disabled="disabled" >{{$orcamento->tb_orcamento_obs or old('obs_pedido')}}</textarea>        
         </div>
      </fieldset>
  </div>
  <div class="tab-pane col-sm-12" id="nav_produtos" role="tabpanel">
        <fieldset class="fieldset_busca col-sm-12">
         <legend class="legend_busca" style="max-width:65px;">Ações</legend>
            <div class="row" style="padding-left:15px;">
                <div class='col-sm-8'>
                    <div class="row">
                        <div class="input-group col-sm-3">
                          <span class="input-group-btn">
                            <button class="btn btn-outline-primary col-sm-12" type="button" id='incluir_resposta_produto' name='incluir_resposta_produto'>
                                <img width="25" src="{{asset('assets/img/plus.png')}}" alt="Incluir Item" border="0" align="center" />
                                Incluir Resposta
                            </button>
                          </span>
                        </div>
                        <div class="input-group col-sm-3">
                          <span class="input-group-btn">
                            <button class="btn btn-outline-warning disabled" type="button" id="editar_produto_orcamento" name="editar_produto_orcamento" disabled="true">
                                <img width="25" src="{{asset('assets/img/edit.png')}}" alt="Editar" border="0" align="center" />
                                Editar Produto
                            </button>
                          </span>
                        </div>
                        <div class="input-group col-sm-3">
                          <span class="input-group-btn">
                            <button class="btn btn-outline-danger disabled" type="button" id="excluir_produto_orcamento" name="excluir_produto_orcamento" disabled="true">
                                <img width="25" src="{{asset('assets/img/delete.png')}}" alt="Excluir" border="0" align="center" />
                                Excluir Produto
                            </button>
                          </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="total_orcamento" class="col-sm-5 custom-control col-form-label">Total Orcamento:</label>     
                        <div class='col-sm-7'> 
                            <div class="input-group col-sm-12 ">
                                <span class="input-group-addon col-sm-3">R$</span>
                                <input class="col-sm-9 form-control disabled" type="number" step="any" id="total_orcamento" name="total_orcamento" value="{{$orcamento->tb_orcamento_total_orcamento or old('total_orcamento')}}" placeholder="Valor Total" disabled="disabled" readonly="readonly"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="fieldset_resultado col-sm-12" >
            <legend class="legend_resultado" style="max-width:195px;">Produtos Inclusos</legend>
            <div id="itens_produtos" name="itens_produtos" style="overflow-y:scroll; height:350px;"> 
                @if(isset($orcamentoItens))
                @foreach($orcamentoItens as $item)
                <fieldset class="fieldset_busca col-sm-12" style="overflow-x:scroll;">
                    <legend class="legend_busca" style="max-width:105px;">Item Nº{{$item->tb_orcamento_itens_seq}}</legend>
                    <table style="max-width: 1000px;" id="tabela_itens_inclusos" class="table table-striped table-hover table-bordered ">
                    <thead>
                        <tr>
                            <th nowrap="nowrap"> Item</th>
                            <th nowrap="nowrap"> ID Produto</th>
                            <th nowrap="nowrap"> Referencia Produto</th>
                            <th nowrap="nowrap"> Descricao Produto</th>
                            <th nowrap="nowrap"> Marca Produto</th>
                            <th nowrap="nowrap"> QT Produto</th>
                            <th nowrap="nowrap"> UN Produto</th>
                            <th nowrap="nowrap"> Valor Lista</th>
                            <th nowrap="nowrap"> Desconto</th>
                            <th nowrap="nowrap"> Desconto </th>
                            <th nowrap="nowrap"> Valor Unit.</th>
                            <th nowrap="nowrap"> Valor Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='id_{{$item->tb_orcamento_itens_seq}}' name='id_{{$item->tb_orcamento_itens_seq}}' style='cursor:pointer'>
                            <td  style="min-width: 50px;" class="col-sm-12">
                                <input type='hidden' id='tipo_produto[]' name='tipo_produto[]' value="{{$item->tb_orcamento_itens_tipo}}" readonly='readonly' >
                                <input type='text' class="col-sm-12 form-control-sm" id='item[]' name='item[]' value="{{$item->tb_orcamento_itens_seq}}" readonly='readonly'>
                            </td>
                            <td class="col-sm-12">
                                <input type='text' class="col-sm-12 form-control-sm" id='id_produto[]' name='id_produto[]' value="{{$item->tb_orcamento_itens_id_produto}}" readonly='readonly'>
                            </td>
                            <td nowrap='nowrap' class="col-sm-1">
                                <input type='text' class="col-sm-12 form-control-sm" id='referencia_produto[]' name='referencia_produto[]' value='{{$item->tb_orcamento_itens_referencia_produto}}' readonly='readonly'>
                            </td>
                            <td nowrap='nowrap' style="min-width: 200px;" class="col-sm-1">
                                <input type='text' class="col-sm-12 form-control-sm" id='descricao_produto[]' name='descricao_produto[]' value='{{$item->tb_orcamento_itens_descricao_produto}}' readonly='readonly'>
                            </td>
                            <td nowrap='nowrap' class="col-sm-1">
                                <input type='text' class="col-sm-12 form-control-sm" id='marca_produto[]' name='marca_produto[]' value='{{$item->tb_orcamento_itens_marca_produto}}' readonly='readonly'>
                            </td>
                            <td nowrap='nowrap' class="col-sm-1">
                                <input type='number' step="any" class="col-sm-12 form-control-sm" id='qt_produto[]' name='qt_produto[]' value="{{$item->tb_orcamento_itens_qt_produto}}" readonly='readonly'>
                            </td>
                            <td nowrap='nowrap' class="col-sm-1">
                                <input type='text' class="col-sm-12 form-control-sm" id='un_produto[]' name='un_produto[]' value="{{$item->tb_orcamento_itens_un_produto}}" readonly='readonly'>
                            </td>
                            <td style="min-width: 100px;" class="col-sm-3">
                                <div class="input-group col-sm-12 " style="padding:0px;">
                                    <span class="input-group-addon col-sm-3">R$</span>
                                    <input type='number' class="col-sm-9 form-control-sm" step="any" id='preco_lista_produto[]' name='preco_lista_produto[]' value="{{$item->tb_orcamento_itens_preco_lista}}" readonly='readonly' >
                                </div>                                
                            </td>
                            <td style="min-width: 100px;" class="col-sm-3">                                
                                <div class="input-group col-sm-12" style="padding:0px;">
                                    <input type='number' class="col-sm-9 form-control-sm" step="any" id='desconto_percentual_produto[]' name='desconto_percentual_produto[]' value="{{$item->tb_orcamento_itens_percentual_desconto_produto}}" readonly='readonly' >
                                    <span class="input-group-addon col-sm-3">%</span>
                                </div>
                            </td>
                            <td style="min-width: 100px;" class="col-sm-3">
                                <div class="input-group col-sm-12" style="padding:0px;">
                                    <span class="input-group-addon col-sm-3">R$</span>
                                    <input type='number' class="col-sm-9 form-control-sm" step="any" id='desconto_valor_produto[]' name='desconto_valor_produto[]' value="{{$item->tb_orcamento_itens_valor_desconto_produto}}" readonly='readonly' >
                                </div>      
                            </td>
                            <td style="min-width: 100px;" class="col-sm-3">
                                <div class="input-group col-sm-12" style="padding:0px;">
                                    <span class="input-group-addon col-sm-3">R$</span>
                                    <input type='number' class="col-sm-9 form-control-sm" step="any" id='preco_unit_produto[]' name='preco_unit_produto[]' value="{{$item->tb_orcamento_itens_valor_unit_produto}}" readonly='readonly' >
                                </div> 
                            </td>
                            <td style="min-width: 100px;" nowrap='nowrap' class="col-sm-1">
                                <div class="input-group col-sm-12" style="padding:0px;">
                                    <span class="input-group-addon col-sm-3">R$</span>
                                    <input type='number' class="col-sm-9 form-control-sm" step="any" id='valor_total_produto[]' name='valor_total_produto[]' value="{{$item->tb_orcamento_itens_valor_total_produto}}" readonly='readonly' >
                                </div> 
                            </td>
                        </tr>
                    </tbody>
                    </table>
              </fieldset>
              @endforeach
              @endif
          </div>
        </fieldset>
  </div>
</div>       
<div id="menu_inferior" >
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:65px;">Ações</legend>
        <button type="button" class="btn btn-danger" onClick="fechar_janela()">Sair</button>
        @if($tipo == 'incluir')
        <button type="reset" class="btn btn-warning" onClick="return reseta()">Resetar Orcamento</button>
        <button id="gravar_orcamento" type="button" class="btn btn-primary">Gravar Orcamento</button>
        @endif
        @if($tipo == 'editar')
        <button id="gravar_orcamento" type="button" class="btn btn-primary">Editar Orcamento</button>
        @endif
    </fieldset>
</div>
<div class="row">
    <div id="retorno_cliente_blur">        
    </div>
    <div id="retorno_plano_blur">        
    </div>
    <div id='retorno_produto_blur'>
    </div>
</div>
</form>
<script>
    document.getElementById('id_cliente').focus();
</script>

@endif

@if(($tipo == 'incluir') || ($tipo == 'editar'))
@if($tipo == 'incluir')
<form name="form_orcamento" id="form_orcamento" action="save" method="POST">
@endif
@if($tipo == 'editar')
<form name="form_orcamento" id="form_orcamento" action="@if(isset($orcamento)) {{route('orcamento.update', $orcamento->tb_orcamento_id)}} @endif" method="POST">
@endif
     {{ csrf_field() }}
<div id="corpo">
</div>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav_dados_cliente" role="tab">Dados do cliente</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav_produtos" role="tab">Produtos</a>
    </li>
</ul>
<!-- Tab panes -->
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_dados_cliente" role="tabpanel">
      <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:80px;">Cliente</legend>
        <div class="row">
          @if($tipo == 'editar')
          <div class="col-sm-2">              
              <div class="col-sm-10 exibe-id">
                  <br />
                  <h4>Orçamento Nr {{$orcamento->tb_orcamento_id}}</h4>  
                  <br />
              </div>              
          </div>
          @endif
          @if($tipo == 'editar')
          <div class="col-sm-10">
          @else 
          <div class="col-sm-12"> 
          @endif
          <div class="row">
              <label for="id_cliente" class="col-sm-1 custom-control col-form-label">Código: </label>
              <div class='col-sm-2'> 
                <div class="input-group">
                    <input id="id_cliente" name="id_cliente" type="number" value="{{$orcamento->tb_orcamento_id_cliente or old('id_cliente')}}" class="form-control" placeholder="ID Cliente" required>
                  <span class="input-group-btn">
                    <button id="busca_cliente_orcamento" class="btn btn-primary" type="button">
                        <img src='{{asset('assets/img/procura.png')}}' alt='busca' width='20px' />
                    </button>
                  </span>
                </div>
              </div>
              @if(isset($orcamento))
              @php $dados_cliente = DB::connection('odbc')->select("select * from pessoas where id = $orcamento->tb_orcamento_id_cliente");@endphp
              @endif
              <label for="nome_cliente" class="col-sm-1 custom-control col-form-label">Nome: </label>
              <input name="nome_cliente" id="nome_cliente" class="col-sm-6 form-control disabled" type="text" value="{{$dados_cliente[0]->Nome or old('nome_cliente')}}" placeholder="Campo não editável, selecione o cliente pelo ID" disabled="disabled" readonly="readonly" required>
          </div>
        <div class="row">
          <label for="contato_cliente" class="col-sm-1 custom-control col-form-label">Contato: </label>
          <input name="contato_cliente" id="contato_cliente" class="col-sm-2 form-control" type="text" value="{{$orcamento->tb_orcamento_contato or old('contato_cliente')}}" placeholder="Contato" required>
          <label for="telefone_cliente" class="col-sm-1 custom-control col-form-label">Telefone: </label>
          <input name="telefone_cliente" id="telefone_cliente" class="col-sm-3 form-control" type="tel" value="{{$orcamento->tb_orcamento_telefone or old('telefone_cliente')}}" placeholder="(00)0 0000-0000" required>
          <label for="email_cliente" class="col-sm-1 custom-control col-form-label">E-mail: </label>
          <input name="email_cliente" class="col-sm-2 form-control" id="email_cliente" type="email" value="{{$orcamento->tb_orcamento_email or old('email_cliente')}}" placeholder="example@host.com" onChange="checkMail()" ><br>
        </div>
        <div class="row">          
          <label for="obs_cliente" class="col-sm-2 custom-control col-form-label" >Observações: </label>
          <textarea class="col-sm-6 form-control disabled"  name="obs_cliente" id="obs_cliente" value="{{$dados_cliente[0]->Obs or old('obs_cliente')}}" readonly="readonly" disabled="disabled" placeholder="Observação do cliente"></textarea>
        </div>
          </div>
        </div>
       </fieldset>
       <fieldset class="fieldset_busca col-sm-12">
         <legend class="legend_busca" style="max-width:190px;">Dados do Pedido</legend>
         <div class="row">
             <label class="col-sm-1 custom-control col-form-label">Data:</label>
             <input class="col-sm-1 form-control disabled"  type="text" id="data_orcamento" name="data_orcamento" value="@if( isset($orcamento->tb_orcamento_data)) {{implode("/",array_reverse(explode("-",$orcamento->tb_orcamento_data)))}} @else @php $data = date('d/m/Y'); echo $data; @endphp @endif" readonly="readonly" disabled="disabled" />     
             <label for="vendedor" class="col-sm-1 custom-control col-form-label"> Vendedor:</label>
             <select id="vendedor" name="vendedor" class="col-sm-2 form-control" required>
                 <option value=''>Selecione</option>
             @if(isset($vendedores))
                 @foreach($vendedores as $item)
                    <option value='{{$item->ID}}' @if(isset($orcamento) && $orcamento->tb_orcamento_id_vendedor == $item->ID) Selected @endif>{{$item->ID}} - {{$item->Nome}}</option>
                 @endforeach
             @endif                 
             </select> 
             <label for="tipo" class="col-sm-1 custom-control col-form-label">Tipo:</label>
             @if(isset($orcamento))
               <input class="col-sm-2 form-control disabled"  type="text" id="tipo" name="tipo" value="1 - Orcamento" readonly="readonly" disabled="disabled" />     
             @else
             <select id="tipo" name="tipo" class="col-sm-2 form-control" required>
               <option value="">Selecione</option>
               <option value="1">1 - Orcamento</option>
               <option value="2">2 - Pedido</option>
             </select>
             @endif
         </div>
         <div class="row">
             <label for="id_plano_pagamento" class="col-sm-2 custom-control col-form-label">Plano de Pagamento:</label>     
             <div class='col-sm-2'> 
                <div class="input-group">
                  <input name="id_plano_pagamento" id="id_plano_pagamento" type="number" value="{{$orcamento->tb_orcamento_id_plano or old('id_plano_pagamento')}}" class="form-control" placeholder="Buscar Plano" required>
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" id="busca_plano" name="busca_plano">
                        <img src='{{asset('assets/img/procura.png')}}' alt='busca' width='20px' />
                    </button>
                  </span>
                </div>
             </div>
             @if(isset($orcamento))
             @php $dados_plano = DB::connection('odbc')->select("select * from planos where id = $orcamento->tb_orcamento_id_plano");@endphp
             @endif
             <input name="descricao_plano_pagamento" id="descricao_plano_pagamento" class="col-sm-2 form-control disabled" type="text" value="{{$dados_plano[0]->Descricao or old('descricao_plano_pagamento')}}" placeholder="Campo não editável" readonly='readonly' disabled="disabled" required>
         </div>
         <div class="row">
            <label for="obs_pedido" class="col-sm-2 custom-control col-form-label">Observações:</label>
            <textarea name="obs_pedido" id="obs_pedido" placeholder="Digite aqui a observação do orcamento/pedido" rows="6" class="col-sm-6 form-control">{{$orcamento->tb_orcamento_obs or old('obs_pedido')}}</textarea>        
         </div>
      </fieldset>
  </div>
  <div class="tab-pane col-sm-12" id="nav_produtos" role="tabpanel">
        <fieldset class="fieldset_busca col-sm-12">
         <legend class="legend_busca" style="max-width:65px;">Ações</legend>
            <div class="row" style="padding-left:15px;">
                <div class='col-sm-8'>
                    <div class="row">
                        <div class="input-group col-sm-3">
                          <span class="input-group-btn">
                            <button class="btn btn-outline-primary col-sm-12" type="button" id='incluir_produto_orcamento' name='incluir_produto_orcamento'>
                                <img width="25" src="{{asset('assets/img/plus.png')}}" alt="Incluir Item" border="0" align="center" />
                                Incluir Produto
                            </button>
                          </span>
                        </div>
                        <div class="input-group col-sm-3">
                          <span class="input-group-btn">
                            <button class="btn btn-outline-warning disabled" type="button" id="editar_produto_orcamento" name="editar_produto_orcamento" disabled="true">
                                <img width="25" src="{{asset('assets/img/edit.png')}}" alt="Editar" border="0" align="center" />
                                Editar Produto
                            </button>
                          </span>
                        </div>
                        <div class="input-group col-sm-3">
                          <span class="input-group-btn">
                            <button class="btn btn-outline-danger disabled" type="button" id="excluir_produto_orcamento" name="excluir_produto_orcamento" disabled="true">
                                <img width="25" src="{{asset('assets/img/delete.png')}}" alt="Excluir" border="0" align="center" />
                                Excluir Produto
                            </button>
                          </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="total_orcamento" class="col-sm-5 custom-control col-form-label">Total Orcamento:</label>     
                        <div class='col-sm-7'> 
                            <div class="input-group col-sm-12 ">
                                <span class="input-group-addon col-sm-3">R$</span>
                                <input class="col-sm-9 form-control disabled" type="number" step="any" id="total_orcamento" name="total_orcamento" value="{{$orcamento->tb_orcamento_total_orcamento or old('total_orcamento')}}" placeholder="Valor Total" disabled="disabled" readonly="readonly"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="fieldset_resultado col-sm-12">
         <legend class="legend_resultado" style="max-width:195px;">Produtos Inclusos</legend>
          <div id="itens_produtos" name="itens_produtos" style="overflow-y:scroll; height:350px;"> 
              @if(isset($orcamentoItens))
              <table id="tabela_itens_inclusos" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th nowrap="nowrap"> Item</th>
                        <th nowrap="nowrap"> ID Produto</th>
                        <th nowrap="nowrap"> Referencia Produto</th>
                        <th nowrap="nowrap"> Descricao Produto</th>
                        <th nowrap="nowrap"> Marca Produto</th>
                        <th nowrap="nowrap"> QT Produto</th>
                        <th nowrap="nowrap"> UN Produto</th>
                        <th nowrap="nowrap"> Valor Lista</th>
                        <th nowrap="nowrap"> Desconto</th>
                        <th nowrap="nowrap"> Desconto </th>
                        <th nowrap="nowrap"> Valor Unit.</th>
                        <th nowrap="nowrap"> Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamentoItens as $item)
                    <tr id='id_{{$item->tb_orcamento_itens_seq}}' name='id_{{$item->tb_orcamento_itens_seq}}' style='cursor:pointer'>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='tipo_produto[]' name='tipo_produto[]' value="{{$item->tb_orcamento_itens_tipo}}" readonly='readonly' >
                            <input type='hidden' id='item[]' name='item[]' value="{{$item->tb_orcamento_itens_seq}}" readonly='readonly'>
                            {{$item->tb_orcamento_itens_seq}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='id_produto[]' name='id_produto[]' value="{{$item->tb_orcamento_itens_id_produto}}" readonly='readonly'>
                            {{$item->tb_orcamento_itens_id_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='referencia_produto[]' name='referencia_produto[]' value='{{$item->tb_orcamento_itens_referencia_produto}}' readonly='readonly'>
                            {{$item->tb_orcamento_itens_referencia_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='descricao_produto[]' name='descricao_produto[]' value='{{$item->tb_orcamento_itens_descricao_produto}}' readonly='readonly'>
                            {{$item->tb_orcamento_itens_descricao_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='marca_produto[]' name='marca_produto[]' value='{{$item->tb_orcamento_itens_marca_produto}}' readonly='readonly'>
                            {{$item->tb_orcamento_itens_marca_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='qt_produto[]' name='qt_produto[]' value="{{$item->tb_orcamento_itens_qt_produto}}" readonly='readonly'>
                            {{$item->tb_orcamento_itens_qt_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='un_produto[]' name='un_produto[]' value="{{$item->tb_orcamento_itens_un_produto}}" readonly='readonly'>
                            {{$item->tb_orcamento_itens_un_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='preco_lista_produto[]' name='preco_lista_produto[]' value="{{$item->tb_orcamento_itens_preco_lista}}" readonly='readonly' >
                            R$ {{$item->tb_orcamento_itens_preco_lista}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='desconto_percentual_produto[]' name='desconto_percentual_produto[]' value="{{$item->tb_orcamento_itens_percentual_desconto_produto}}" readonly='readonly'>
                            {{$item->tb_orcamento_itens_percentual_desconto_produto}}%
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='desconto_valor_produto[]' name='desconto_valor_produto[]' value="{{$item->tb_orcamento_itens_valor_desconto_produto}}" readonly='readonly' >
                            R$ {{$item->tb_orcamento_itens_valor_desconto_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='preco_unit_produto[]' name='preco_unit_produto[]' value="{{$item->tb_orcamento_itens_valor_unit_produto}}" readonly='readonly' >
                            R$ {{$item->tb_orcamento_itens_valor_unit_produto}}
                        </td>
                        <td nowrap='nowrap'>
                            <input type='hidden' id='valor_total_produto[]' name='valor_total_produto[]' value="{{$item->tb_orcamento_itens_valor_total_produto}}" readonly='readonly' >
                            R$ {{$item->tb_orcamento_itens_valor_total_produto}}
                        </td>
    
                    @endforeach
                </tbody>
              </table>
              @endif
          </div>
        </fieldset>
  </div>
</div>       
<div id="menu_inferior" >
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:65px;">Ações</legend>
        <button type="button" class="btn btn-danger" onClick="fechar_janela()">Sair</button>
        @if($tipo == 'incluir')
        <button type="reset" class="btn btn-warning" onClick="return reseta()">Resetar Orcamento</button>
        <button id="gravar_orcamento" type="button" class="btn btn-primary">Gravar Orcamento</button>
        @endif
        @if($tipo == 'editar')
        <button id="gravar_orcamento" type="button" class="btn btn-primary">Editar Orcamento</button>
        @endif
    </fieldset>
</div>
<div class="row">
    <div id="retorno_cliente_blur">        
    </div>
    <div id="retorno_plano_blur">        
    </div>
    <div id='retorno_produto_blur'>
    </div>
</div>
</form>
<script>
    document.getElementById('id_cliente').focus();
</script>

@endif
@endsection

@if($tipo == 'save')
<script> window.close();
 window.opener.location.reload();</script>
@endif

