@if($tipo == 'pesquisa')
<div class="modal fade" id="{{$div}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form id='busca_cliente' method='GET' class="col-sm-12">
            <div class="modal-header">         
              <h5 class="modal-title" id="exampleModalLabel">Pesquisar Cliente</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body container-fluid">
                <div class='row'>
                    <div id='principal' class="col-md-12">
                        <div class="row">
                            <fieldset class="fieldset_busca col-sm-12">
                            <legend class="legend_busca" style="width:195px;">Dados para busca</legend>
                            <div class="row">
                                <label class="col-sm-1 custom-control col-form-label" for="id_cliente_div">ID:</label>
                                <label class="col-sm-3 custom-control col-form-label" for="nome_cliente_div">NOME:</label>    
                                <label class="col-sm-2 custom-control col-form-label" for="fantasia_cliente_div">FANTASIA:</label>    
                                <label class="col-sm-2 custom-control col-form-label" for="cidade_cliente_div">CIDADE:</label>    
                                <label class="col-sm-2 custom-control col-form-label" for="cpfcnpj_cliente_div">CPFCNPJ:</label>    
                                <label class="col-sm-2 custom-control col-form-label" for="fone1_cliente_div">FONE:</label>    
                            </div>
                            <div class="row">
                                <input class="col-sm-1 form-control" value='' type="text" id="id_cliente_div" name="id_cliente_div" onKeyUp="pesquisa_cliente()" />
                                <input class="col-sm-3 form-control" value='' type="text" id="nome_cliente_div" name="nome_cliente_div" onKeyUp="pesquisa_cliente()" />
                                <input class="col-sm-2 form-control" value='' type="text" id="fantasia_cliente_div" name="fantasia_cliente_div" onKeyUp="pesquisa_cliente()" />
                                <input class="col-sm-2 form-control" value='' type="text" id="cidade_cliente_div" name="cidade_cliente_div" onKeyUp="pesquisa_cliente()"  />
                                <input class="col-sm-2 form-control" value='' type="text" id="cpfcnpj_cliente_div" name="cpfcnpj_cliente_div" onKeyUp="pesquisa_cliente()"  />
                                <input class="col-sm-2 form-control" value='' type="text" id="fone1_cliente_div" name="fone1_cliente_div" onKeyUp="pesquisa_cliente()" />
                                <input type="hidden" id="fone2_cliente_div" name="fone2_cliente_div" />
                                <input type="hidden" id="div_pai" name="div_pai" value="{{$div}}" />
                            </div>
                            </fieldset>
                        </div>
                        <div class="row">
                            <div id="resultado_busca_cliente" style='overflow: auto;'>        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </form>
    </div>
  </div>
</div>
<script>
    $('#'+div_pai.value).modal('show');
</script>
@endif
@if($tipo == 'resultado')
    <fieldset class="fieldset_resultado col-sm-12">
         <legend class="legend_resultado" style="max-width:215px;">Resultado da Busca</legend>
        @if(count($resul_clientes) > 0)
        <div class="col-sm-12" style='overflow: auto;'>
        <table id='grid_resultado_busca_cliente' class='table table-striped table-hover table-bordered'>
            <thead>
                <tr>
                   <th nowrap='nowrap'>ID Cliente</th>
                   <th nowrap='nowrap'>Nome Cliente</th>
                   <th nowrap='nowrap'>Nome Fantasia</th>
                   <th nowrap='nowrap'>Endereco</th>
                   <th nowrap='nowrap'>Cidade</th>
                   <th nowrap='nowrap'>CPF / CNPJ</th>
                   <th nowrap='nowrap'>Fone 1</th>
                   <th nowrap='nowrap'>Fone 2</th>
               </tr>
            </thead>
            <tbody>
            @foreach($resul_clientes as $cliente)
                @php
                    $cliente->Obs = implode("``", explode("\"", $cliente->Obs));
                    $cliente->Obs = implode("`", explode("'", $cliente->Obs));
                    $cliente->Obs = str_replace("\r\n",";",trim($cliente->Obs));
                @endphp
		<tr style='cursor:pointer' onclick="preencher_campo_cliente({{$cliente->ID}},'{{$cliente->Nome}}','{{$cliente->Obs}}','{{$cliente->Fone1}}', '{{$div}}')">
                    <td nowrap>{{$cliente->ID}}</td>
		    <td nowrap>{{$cliente->Nome}}</td>
		    <td nowrap>{{$cliente->Fantasia}}</td>
		    <td nowrap>{{$cliente->Endereco}}</td>
		    <td nowrap>{{$cliente->Cidade}}</td>
		    <td nowrap>{{$cliente->CPFCNPJ}}</td>
		    <td nowrap>{{$cliente->Fone1}}</td>
		    <td nowrap>{{$cliente->Fone2}}</td>
		</tr>
             @endforeach
             </tbody>
	    </table>
        </div>
        @else  
            <center>Não há resultado para esta pesquisa!</center>
        @endif
	  </fieldset>
          
@endif
@if($tipo == 'blur')
  @if(count($resul_clientes) > 0)
    @foreach($resul_clientes as $cliente)
        @php
            $cliente->Obs = implode("``", explode("\"", $cliente->Obs));
            $cliente->Obs = implode("`", explode("'", $cliente->Obs));
            $cliente->Obs = str_replace("\r\n",";",trim($cliente->Obs));
        @endphp
            <input value="{{$cliente->ID}}" type="hidden" id="id_cliente_div" name="id_cliente_div" />
            <input value="{{$cliente->Nome}}" type="hidden" id="nome_cliente_div" name="nome_cliente_div" />
            <input value="{{$cliente->Fantasia}}" type="hidden" id="fantasia_cliente_div" name="fantasia_cliente_div" />
            <input value="{{$cliente->Endereco}}" type="hidden" id="endereco_cliente_div" name="endereco_cliente_div" />
            <input value="{{$cliente->Cidade}}" type="hidden" id="cidade_cliente_div" name="cidade_cliente_div" />
            <input value="{{$cliente->CPFCNPJ}}" type="hidden" id="cpfcnpj_cliente_div" name="cpfcnpj_cliente_div" />
            <input value="{{$cliente->Fone1}}" type="hidden" id="fone1_cliente_div" name="fone1_cliente_div" />
            <input value="{{$cliente->Fone2}}" type="hidden" id="fone2_cliente_div" name="fone2_cliente_div" />
            <input value="{{$cliente->Obs}}" type="hidden" id="obs_cliente_div" name="obs_cliente_div" />
    @endforeach
  @else
     <input value="Não cadastrado" type="hidden" id="nome_cliente_div" name="nome_cliente_div" />
  @endif
  <script>
      preencher_campo_cliente($('#id_cliente_div').val(), $('#nome_cliente_div').val(), $('#obs_cliente_div').val(), $('#fone1_cliente_div').val(), '');
  </script>
@endif