@php 
use retensul\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use retensul\Http\Requests;
use retensul\Models\Tb_orcamento;
use retensul\Models\Vendedores;
use retensul\Models\Pessoas;
@endphp

@extends('layouts.template')
@section('menu')
<div style="overflow:auto;" id="menu_lateral">
    <label id="label_menu">Menu Lateral</label>    
        <ul class="navbar-nav mr-auto rounded">
            <li class="nav-item">
                <a id="incluir_orcamento" name='incluir_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Incluir Orcamento
                </a>
            </li>
            <li class="nav-item">
                <a id='editar_orcamento' name='editar_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Editar Orcamento
                </a>
            </li>
            <li class="nav-item">
                <a id='deletar_orcamento' name='deletar_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Deletar Orcamento
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Ver Resposta
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Imprimir Orcamento
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Imprimir P/ E-mail
                </a>
            </li>
            <li class="nav-item">
                <a id='responder_orcamento' name='responder_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Responder Orçamento
                </a>
            </li>
        </ul>
</div>
@endsection

@section('content')
<div id='grid_orcamento' style='overflow:scroll;' class='table-responsive' >
  <table id='grid_resultado_orcamento' class='table table-striped table-hover table-bordered'>
      <thead>
          <tr>
            <th width='60' align='center' nowrap='nowrap'>Tipo</th>
            <th width='40' align='center' nowrap='nowrap'>Status</th>
            <th max-width='60' align='center' nowrap='nowrap'>ID</th>
            <th width='200' nowrap='nowrap'>Cliente</th>
            <th width='80' nowrap='nowrap'>Contato</th>
            <th width='80' nowrap='nowrap'>Plano</th>
            <th width='80' nowrap='nowrap'>
              <select id='vendedor' name='vendedor' class='input_select' onChange='captura_grid(this.value)'>
                  <option value="0">Selecione</option>
                  @if(count($vendedores) > 0)
                    @foreach($vendedores as $item)
                      <option value='{{$item->ID}}'>{{$item->ID}} - {{$item->Nome}}</option>
                    @endforeach
                  @endif
              </select>
            </th>
            <th width='70' align='center' nowrap='nowrap'>Data</th>
            <th width='80' align='center' nowrap='nowrap'>Valor Total</th>
            <th nowrap='nowrap'>OBS</th>
          </tr>
      </thead>
      <tbody>
      @if(count($orcamentos) > 0)
        @foreach($orcamentos as $orcamento)        
          <tr>
              <td nowrap='nowrap' scope="row">Orcamento</td>
              @if (!empty($orcamento->tb_orcamento_id_principal_ou_resposta))
              <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_verde.png')}}' width='15' /></td>
              @else
              <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_amarelo.png')}}' width='15' /></td>
              @endif
              <td align='center' nowrap='nowrap'>{{$orcamento->tb_orcamento_id}}</td>
              @php $nome_cliente = DB::connection('odbc')->select("select * from pessoas where id = $orcamento->tb_orcamento_id_cliente");@endphp
              <td nowrap='nowrap'>{{$orcamento->tb_orcamento_id_cliente}} - {{$nome_cliente[0]->Nome}}</td>
              <td nowrap='nowrap'>{{$orcamento->tb_orcamento_contato}}</td>
              @php $plano = DB::connection('odbc')->select("select * from planos where id = $orcamento->tb_orcamento_id_plano");@endphp
              <td nowrap='nowrap'>{{$orcamento->tb_orcamento_id_plano}} - {{$plano[0]->Descricao}}</td>
              @php $vendedor = DB::connection('odbc')->select("select * from vendedores where id = $orcamento->tb_orcamento_id_vendedor");@endphp
              <td nowrap='nowrap'>{{$orcamento->tb_orcamento_id_vendedor}} - {{$vendedor[0]->Nome}}</td>
              <td nowrap='nowrap'>{{$orcamento->tb_orcamento_data}}</td>
              <td nowrap='nowrap'>R$ {{sprintf("%01.2f", $orcamento->tb_orcamento_total_orcamento)}}</td>
              <td nowrap='nowrap'>{{$orcamento->tb_orcamento_obs}}</td>
          </tr>        
        @endforeach
      @endif
      </tbody>
  </table>
</div>
@endsection
@section('detalhes')
<div id="detalhes_orcamento" style='overflow:scroll;' class='table-responsive'>
    <p> Clique em um orçamento para exibir os produtos </p>
</div>
@endsection


