@if(isset($id))
<table id="grid_produtos_pedido" class='table table-striped table-hover table-bordered'>
    <thead>
        <tr>
            <th>Item</th>
            <th>Status</th>
            <th>ID Produto</th>
            <th>Referencia Produto</th>
            <th width-max="500px" nowrap='nowrap'>Descricao Produto</th>
            <th>Marca Produto</th>
            <th>QT</th>
            <th>Valor Unit.</th>
            <th>Valor Total</th>
            <th>Preco Lista</th>
            <th>Desconto (%)</th>
            <th>Desconto (R$)</th>
            <th>Previsão de Entrega</th>
        </tr>
    </thead>
    <tbody>
    @if(count($itens_pedido) > 0)
      @foreach($itens_pedido as $item_pedido)
        <tr>
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_seq}}</td>
            @if($item_pedido->tb_pedido_itens_status_estoque == "T") 
                <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_verde.png')}}' width='15' /></td>
            @endif
            @if (($item_pedido->tb_pedido_itens_status_estoque == "F") && ( $item_pedido->tb_pedido_itens_status_pedido == "P"))
                <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_amarelo.png')}}' width='15' /></td>
            @endif
            @if (($item_pedido->tb_pedido_itens_status_estoque == "F") && ( $item_pedido->tb_pedido_itens_status_pedido == "A"))
                <td align='center' nowrap='nowrap'><img src='{{asset('assets/img/circulo_vermelho.png')}}' width='15' /></td>
            @endif
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_id_produto}}</td>
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_referencia_produto}}</td>
            <td width-max="500px" nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_descricao_produto}}</td>
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_marca_produto}}</td>
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_qt_produto}}</td>
            <td nowrap='nowrap'>R$ {{number_format($item_pedido->tb_pedido_itens_valor_unit_produto,2,",",".")}}</td>
            <td nowrap='nowrap'>R$ {{number_format($item_pedido->tb_pedido_itens_valor_total_produto,2,",",".")}}</td>
            <td nowrap='nowrap'>R$ {{number_format($item_pedido->tb_pedido_itens_preco_lista,2,",",".")}}</td>
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_percentual_desconto_produto}}%</td>
            <td nowrap='nowrap'>R$ {{number_format($item_pedido->tb_pedido_itens_valor_desconto_produto,2,",",".")}}</td>
            <td nowrap='nowrap'>{{$item_pedido->tb_pedido_itens_previsao_entrega}}</td>
        </tr>
      @endforeach
    @endif
    </tbody>
</table>
@endif



