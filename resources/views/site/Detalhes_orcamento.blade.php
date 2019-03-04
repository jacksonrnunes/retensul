@if(isset($id))
<table id="grid_produtos_orcamento" class='table table-striped table-hover table-bordered'>
    <thead>
        <tr>
            <th>Item</th>
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
        </tr>
    </thead>
    <tbody>
    @if(count($itens_orcamento) > 0)
      @foreach($itens_orcamento as $item_orcamento)
        <tr>
            <td nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_seq}}</td>
            <td nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_id_produto}}</td>
            <td nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_referencia_produto}}</td>
            <td width-max="500px" nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_descricao_produto}}</td>
            <td nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_marca_produto}}</td>
            <td nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_qt_produto}}</td>
            <td nowrap='nowrap'>R$ {{number_format($item_orcamento->tb_orcamento_itens_valor_unit_produto,2,",",".")}}</td>
            <td nowrap='nowrap'>R$ {{number_format($item_orcamento->tb_orcamento_itens_valor_total_produto,2,",",".")}}</td>
            <td nowrap='nowrap'>R$ {{number_format($item_orcamento->tb_orcamento_itens_preco_lista,2,",",".")}}</td>
            <td nowrap='nowrap'>{{$item_orcamento->tb_orcamento_itens_percentual_desconto_produto}}%</td>
            <td nowrap='nowrap'>R$ {{number_format($item_orcamento->tb_orcamento_itens_valor_desconto_produto,2,",",".")}}</td>
        </tr>
      @endforeach
    @endif
    </tbody>
</table>
@endif



