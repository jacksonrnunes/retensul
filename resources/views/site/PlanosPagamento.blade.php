@if($tipo == 'pesquisa')
<div class="modal fade" id="{{$div}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">         
          <h5 class="modal-title" id="exampleModalLabel">Pesquisar Plano</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body container-fluid">
            <div class='row'>
                <div id='principal' class="col-md-12">
                    <div class="row">
                        <div id="resul_busca_plano" style='overflow: auto;'>
                            <fieldset class="fieldset_resultado col-sm-12">
                                <legend class="legend_resultado" style="max-width:215px;">Resultado da Busca</legend>
                                @if(count($PlanosPagamento))
                                <div class="col-sm-12" style='overflow: auto;'>
                                    <table id='grid_resultado_busca_plano' class='table table-striped table-hover table-bordered'>
                                        <thead>
                                            <tr>
                                               <th nowrap='nowrap'>ID Plano</th>
                                               <th nowrap='nowrap'>Descricao</th>
                                        </thead>
                                        <tbody>
                                            @foreach($PlanosPagamento as $Plano)
                                            <tr style='cursor:pointer' onclick="preencher_campo_plano({{$Plano->ID}},'{{$Plano->Descricao}}', '{{$div}}')">
                                              <td>{{$Plano->ID}}</td>
                                              <td>{{$Plano->Descricao}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <center>Não Há Planos Cadastrados</center>
                                @endif
                                <input id="div" name="div" type="hidden" value="{{$div}}" /> 
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
<script>
    $('#'+div.value).modal('show');
</script>
@endif  
@if($tipo == 'blur')
  @if(count($PlanosPagamento) > 0)
    @foreach($PlanosPagamento as $Plano)
        <input value="{{$Plano->ID}}" type="hidden" id="id_plano_div" name="id_plano_div" />
        <input value="{{$Plano->Descricao}}" type="hidden" id="descricao_plano_div" name="descricao_plano_div" />
    @endforeach
  @else
     <input value="Não cadastrado" type="hidden" id="descricao_plano_div" name="descricao_plano_div" />
  @endif
  <script>
      preencher_campo_plano($('#id_plano_div').val(), $('#descricao_plano_div').val(), '');
  </script>
@endif


