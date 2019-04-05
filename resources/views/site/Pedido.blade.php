<?php 
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\Tb_pedido;
use retensul\Models\Tb_pedido_itens;
use retensul\Models\Vendedores;
use retensul\Models\Pessoas;
?>

@extends('layouts.template')
@section('menu')
<div style="overflow:auto;" id="menu_lateral">
    <label id="label_menu">Menu Lateral</label>    
        <ul class="navbar-nav mr-auto rounded">
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Incluir Pedido
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Editar Pedido
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Deletar Pedido
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Ver Pedido
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Imprimir Pedido
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Imprimir P/ E-mail
                </a>
            </li>
        </ul>
</div>
@endsection

@section('content')
<div id='grid_pedido' style='overflow:scroll;' class='table-responsive'>
  <table id='grid_resultado_orcamento' class='table table-striped table-hover table-bordered'>
      <thead>
          <tr>
            <th max-width='60' align='center' nowrap='nowrap'>Tipo</th>
            <th max-width='40' align='center' nowrap='nowrap'>Status</th>
            <th max-width='60' align='center' nowrap='nowrap'>ID</th>
            <th max-width='200' nowrap='nowrap'>Cliente</th>
            <th max-width='80' nowrap='nowrap'>Contato</th>
            <th max-width='80' nowrap='nowrap'>Plano</th>
            <th max-width='80' nowrap='nowrap'>
              <select id='vendedor' name='vendedor' class='input_select' onChange='captura_grid(this.value)'>
                  <option value="0">Selecione</option>
                  @if(count($vendedores) > 0)
                    @foreach($vendedores as $item)
                      <option value='{{$item->ID}}'>{{$item->ID}} - {{$item->Nome}}</option>
                    @endforeach
                  @endif
              </select>
            </th>
            <th max-width='70' align='center' nowrap='nowrap'>Data</th>
            <th max-width='80' align='center' nowrap='nowrap'>Valor Total</th>
            <th nowrap='nowrap'>OBS</th>
          </tr>
      </thead>
      <tbody>
      @if(count($pedidos) > 0)
        @foreach($pedidos as $pedido)        
          <tr>
              <td nowrap='nowrap' scope="row">Pedido</td>              
              <?php
              $resposta = true;
              $cont = 0;
              $itens_pedido = tb_pedido_itens::select('*')->where('tb_pedido_id', '=', $pedido->tb_pedido_id)->get(); 
              ?>              
              @foreach($itens_pedido as $item_pedido)              
                @if ($item_pedido->tb_pedido_itens_status_estoque == "F")                
                       <?php 
                       $resposta = false;
                       $cont++;
                       ?>
                @endif
              @endforeach              
              @if ($resposta == true)
                <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_verde.png')}}' width='15' /></td>
              @elseif (($resposta == false) && (count($itens_pedido) == $cont) &&($item_pedido->tb_pedido_status == "P") )
                <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_amarelo.png')}}' width='15' /></td>
              @elseif (($resposta == false) && (count($itens_pedido) == $cont) &&($pedido->tb_pedido_status == "A") )
                <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_vermelho.png')}}' width='15' /></td>
              @else
              <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_azul.png')}}' width='15' /></td>
              @endif
              <td align='center' nowrap='nowrap'>{{$pedido->tb_pedido_id}}</td>
              <?php $nome_cliente = DB::connection('odbc')->select("select * from pessoas where id = $pedido->tb_pedido_id_cliente");?>
              <td nowrap='nowrap'>{{$pedido->tb_pedido_id_cliente}} - {{utf8_encode($nome_cliente[0]->Nome)}}</td>
              <td nowrap='nowrap'>{{$pedido->tb_pedido_contato}}</td>
              <?php $plano = DB::connection('odbc')->select("select * from planos where id = $pedido->tb_pedido_id_plano");?>
              <td nowrap='nowrap'>{{$pedido->tb_pedido_id_plano}} - {{$plano[0]->Descricao}}</td>
              <?php $vendedor = DB::connection('odbc')->select("select * from vendedores where id = $pedido->tb_pedido_id_vendedor");?>
              <td nowrap='nowrap'>{{$pedido->tb_pedido_id_vendedor}} - {{$vendedor[0]->Nome}}</td>
              <td nowrap='nowrap'>{{$pedido->tb_pedido_data}}</td>
              <td nowrap='nowrap'>R$ {{sprintf("%01.2f", $pedido->tb_pedidoo_total_pedido)}}</td>
              <td nowrap='nowrap'>{{$pedido->tb_pedido_obs}}</td>
          </tr>        
        @endforeach
      @endif
      </tbody>
  </table>
</div>
@endsection
@section('detalhes')
<div id="detalhes_orcamento" style='overflow:scroll;' class='table-responsive'>
    <p> Clique em um pedido para exibir os produtos </p>
</div>
@endsection


