@if($tipo == 'janela')
@if($div == 'modal_produto')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>$('#myModal').modal('show')</script>
@else
  <div class='container-fluid'>
    <div class='row'>
        <div id='principal' class="col-md-12">
            <div class="row">
               <div class='col-sm-11'>
                    
                </div>
                <div class='col-sm-1 fechar'>
                    <a href="#" onClick='fechar_div_modal("{{$div}}")'>
                        <img src='{{asset('assets/img/close.png')}}' alt='fechar' width='20px'>
                    </a>
                </div>
            </div>
            <div class="row">
            @if($div == 'incluir_produto')
                <form id='gravar_produto' method='get' class="col-sm-12" action = "javascript: cadastrar_produto();">
            @else
                <form id='gravar_produto' method='get' class="col-sm-12" action = "javascript: atualizar_produto();">
            @endif
            <fieldset class="fieldset_busca col-sm-12">
                @if($div == 'incluir_produto')
                <legend class="legend_busca" style="max-width:165px;">Incluir Produto</legend>
                @else
                <legend class="legend_busca" style="max-width:165px;">Editar Produto</legend>
                @endif
                <fieldset class="fieldset_busca col-sm-12">
                    <legend class="legend_busca" style="max-width:65px;">Busca</legend>
                    <div class="row">
                        <label for="tipo_produto" class='col-sm-2 custom-control col-form-label'>Tipo Produto:</label>
                        <select id="tipo_produto" name="tipo_produto" class="col-sm-2 form-control" required>
                            <option value="1" @if(isset($dados) && $dados[0]->value == '1') selected @endif>1 - Cadastrado</option>
                            <option value="2" @if(isset($dados) && $dados[0]->value == '2') selected @endif>2 - Não Cadastrado</option>
                        </select>
                    </div>
                    <div class='row'>
                        <label for="id_produto" class='col-sm-2 custom-control col-form-label'>ID Produto:</label>
                        <div class='col-sm-3'> 
                            <div class="input-group">
                                <input id="id_produto" name="id_produto" type="number" value="{{$dados[2]->value or old('id_produto')}}" class="form-control" placeholder="ID Produto" required="required">
                              <span class="input-group-btn">
                                <button id="busca_produto_id" class="btn btn-primary" type="button">
                                    <img src='{{asset('assets/img/procura.png')}}' alt='busca' width='20px' />
                                </button>
                              </span>
                            </div>
                        </div>
                    
                        <label for="referencia_produto" class='col-sm-2 custom-control col-form-label'>Referencia:</label>
                        <div class='col-sm-3'> 
                            <div class="input-group">
                              <input id="referencia_produto" name="referencia_produto" type="text" value="{{$dados[3]->value or old('referencia_produto')}}" class="form-control" placeholder="Referencia Produto" required="required">
                              <span class="input-group-btn">
                                <button id="busca_produto_referencia" class="btn btn-primary" type="button">
                                    <img src='{{asset('assets/img/procura.png')}}' alt='busca' width='20px' />
                                </button>
                              </span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="fieldset_busca col-sm-12">
                    <legend class="legend_busca" style="max-width:90px;">Produto</legend>
                    <div class='row'>
                        <label for="decricao_produto" class='col-sm-2 custom-control col-form-label'>Descrição:</label>
                        <input class="col-sm-6 form-control disabled" type="text" id="descricao_produto" value="{{$dados[4]->value or old('descricao_produto')}}" name="descricao_produto" readonly="readonly" disabled='disabled' placeholder="Descrição do Produto" required="required"/>
                        <label for="marca_produto" class='col-sm-2 custom-control col-form-label'>Marca:</label>    
                        <input class="col-sm-2 form-control disabled" type="text" id="marca_produto" value="{{$dados[5]->value or old('marca_produto')}}" name="marca_produto" readonly="readonly" disabled='disabled' placeholder="Marca do Produto" required="required"/>
                    </div>
                </fieldset>
                <fieldset class="fieldset_busca col-sm-12">
                    <legend class="legend_busca" style="max-width:70px;">Preços</legend>
                    <div class='row'>
                        <label for="preco_lista_produto" class='col-sm-2 custom-control col-form-label'>Preco lista:</label>
                        <div class="input-group col-sm-2">
                            <span class="input-group-addon col-sm-3">R$</span>
                            <input class="form-control disabled col-sm-9" type="number" id="preco_lista_produto" value="{{$dados[8]->value or old('preco_lista_produto')}}" name="preco_lista_produto" readonly="readonly" disabled='disabled' step="any" placeholder="Preço Lista"/>
                        </div>                        
                        <label for="preco_unit_produto" class='col-sm-2 custom-control col-form-label'>Preco venda:</label>
                        <div class="input-group col-sm-2 ">
                            <span class="input-group-addon col-sm-3">R$</span>
                            <input class="form-control col-sm-9" type="number" id="preco_unit_produto" name="preco_unit_produto" value="{{$dados[11]->value or old('preco_unit_produto')}}" placeholder="Preço Venda" required="required" step="any"/>
                        </div>
                    </div>
                    <div class="row">
                        <label for="qt_produto" class='col-sm-2 custom-control col-form-label'>Quantidade:</label>
                        <input class="col-sm-2 form-control" type="number" id="qt_produto" name="qt_produto" placeholder="Quantidade" value="{{$dados[6]->value or old('qt_produto')}}" required="required" step="any"/>
                        <label for="un_produto" class='col-sm-2 custom-control col-form-label'>Unidade:</label>
                        <input class="col-sm-2 form-control disabled" type="text" id="un_produto" name="un_produto" placeholder="Unidade" value="{{$dados[7]->value or old('un_produto')}}" required="required" readonly="readonly" disabled='disabled' />
                    </div>
                    <div class="row">
                        <fieldset class="fieldset_resultado col-sm-11" style="padding-left:15px; margin-left:15px">
                            <legend class="legend_resultado" style="max-width:115px;">Descontos</legend>
                            <div class="row">
                                <label for="percentual_desconto_produto" class='col-sm-2 custom-control col-form-label'>Desconto:</label>
                                <div class="input-group col-sm-2 ">
                                    <input class="col-sm-9 form-control" type="text" id="percentual_desconto_produto" name="percentual_desconto_produto" value="{{$dados[9]->value or old('percentual_desconto_produto')}}" placeholder="desconto"/>
                                    <span class="input-group-addon col-sm-3">%</span>
                                </div>
                                <label for="valor_desconto_produto" class='col-sm-2 custom-control col-form-label'>Desconto:</label>
                                <div class="input-group col-sm-2 ">
                                    <span class="input-group-addon col-sm-3">R$</span>
                                    <input class="col-sm-9 form-control" type="text" id="valor_desconto_produto" name="valor_desconto_produto" value="{{$dados[10]->value or old('valor_desconto_produto')}}" placeholder="Desconto"/>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row" style="padding-top:15px;">
                        <label for="valor_total_produto" class='col-sm-2 custom-control col-form-label'>Valor total:</label>
                        <div class="input-group col-sm-2 ">
                            <span class="input-group-addon col-sm-3">R$</span>
                            <input class="col-sm-9 form-control disabled" type="text" id="valor_total_produto" name="valor_total_produto" value="{{$dados[12]->value or old('valor_desconto_produto')}}" readonly="readonly" disabled='disabled' placeholder="Valor Total" />    
                            <input type="hidden" id="div" name="div" readonly="readonly" value="{{$div}}" />
                            <input type="hidden" id="nr_item_produto" readonly="readonly" name="nr_item_produto" value="{{$dados[1]->value or old('nr_item_produto')}}" />
                        </div>
                    </div>
                </fieldset>
                 <fieldset class="fieldset_busca col-sm-12">
                    <legend class="legend_busca" style="max-width:65px;">Ações</legend>
                    @if($div == 'incluir_produto')
                        <button type="reset" class="btn btn-warning" onClick="return reseta()">Resetar Produto</button>
                        <button type="submit" id="inserir_produto" name="inserir_produto" class="btn btn-primary">Inserir Produto</button>
                    @else
                      <button type="submit" id="atualizar_produto" name="atualizar_produto" class="btn btn-primary">Atualizar Produto</button>
                    @endif
                    @if(isset($dados) && $dados[0]->value == '2')
                        <script> mudaTipoProduto('update'); </script>
                    @endif
                </fieldset>
            </fieldset>
            </form>
            </div>
        </div>
    </div>
  </div>
  <div id="corpo">
  </div>
  <script>
    document.getElementById("id_produto").focus();
  </script>

@endif
@endif
@if($tipo == 'pesquisa')
  <div class='container-fluid'>
    <div class='row'>
        <div id='principal' class="col-md-12">
            <div class="row">
               <div class='col-sm-11'>
                    <label class='custom-control col-form-label'> PESQUISAR PRODUTO</label>
                </div>
                <div class='col-sm-1 fechar'>
                    <a href="#" onClick='fechar_div_modal("{{$div}}")'>
                        <img src='{{asset('assets/img/close.png')}}' alt='fechar' width='20px'>
                    </a>
                </div>
            </div>
            <div class="row">
                <form name="dados_do_produto" id="dados_do_produto" class="col-sm-12">
                <fieldset class="fieldset_busca col-sm-12">
                    <legend class="legend_busca" style="max-width:175px;">Dados da Busca</legend>
                    <div class="col-sm-12">
                    <div class="row">
                        <label for="id" class='col-sm-1 custom-control col-form-label'>ID:</label>
                        <label for="referencia" class='col-sm-2 custom-control col-form-label'>Referencia:</label>
                        <label for="descricao" class='col-sm-4 custom-control col-form-label'>Descricao:</label>
                        <label for="marca" class='col-sm-3 custom-control col-form-label'>Marca:</label>
                    </div>
                    <div class="row">
                        <input class="col-sm-1 form-control pesquisa_produto" type="number" id="id" name="id" onkeyup="pesquisa_produto()"/>
                        <input class="col-sm-2 form-control pesquisa_produto" type="text" id="referencia" name="referencia" onkeyup="pesquisa_produto()"/>
                        <input class="col-sm-4 form-control pesquisa_produto" type="text" id="descricao" name="descricao" onkeyup="pesquisa_produto()"/>
                        <input class="col-sm-3 form-control pesquisa_produto" type="text" id="marca" name="marca" onkeyup="pesquisa_produto()"/>
                        <input type="hidden" id="div_pai" name="div_pai" value="{{$div}}" />
                    </div>
                    </div>
                </fieldset>
                </form>
            </div>
            <div class="row">
                <div id="resultado_busca_produto" style='overflow: auto;'></div>
            </div>
        </div>
    </div>
  </div>
<script>
  document.getElementById("descricao").focus();
</script>
@endif
@if($tipo == 'resultado')
<div class="col-sm-12">
    <fieldset class="fieldset_resultado col-sm-12">
        <legend class="legend_resultado" style="max-width:215px;">Resultado da Busca</legend>
        <div class="col-sm-12">
            <div class="row">
                @if(count($resul_produtos) >0)
                <table id='grid_resultado_busca_produto' class='table table-striped table-hover table-bordered col-sm-12'>
                    <thead>
                        <tr>
                            <th nowrap='nowrap'>ID Produto</th>
                            <th nowrap='nowrap'>Referencia</th>
                            <th nowrap='nowrap'>Descricao do produto</th>
                            <th nowrap='nowrap'>Marca</th>
                            <th nowrap='nowrap'>Preco</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resul_produtos as $produto)
                        <tr onclick="preencher_campo_produto({{$produto->id}},'{{$produto->referencia}}','{{$produto->descricao}}','{{$produto->marca}}', '{{$produto->produto_preco_lista}}', '{{$produto->unidade}}', '{{$div}}')">
                            <td nowrap='nowrap'>{{$produto->id}}</td>
                            <td nowrap='nowrap'>{{$produto->referencia}}</td>
                            <td nowrap='nowrap'>{{$produto->descricao}}</td>
                            <td nowrap='nowrap'>{{$produto->marca}}</td>
                            <td nowrap='nowrap'>R$ {{sprintf("%01.2f",$produto->produto_preco_lista)}}</td>
                         </tr>
                         @endforeach
                    </tbody>
                </table>
                @else
                <center>Não há resultado para esta pesquisa!</center>
                @endif
            </div>
        </div>
    </fieldset>  
</div>
@endif
@if($tipo == 'blur')
  @if(count($resul_produtos) > 0)
    @foreach($resul_produtos as $produto)
        <input value="{{$produto->id}}" type="hidden" id="id_produto_div" name="id_produto_div" />
        <input value="{{$produto->referencia}}" type="hidden" id="referencia_produto_div" name="referencia_produto_div" />
        <input value="{{$produto->descricao}}" type="hidden" id="descricao_produto_div" name="descricao_produto_div" />
        <input value="{{$produto->marca}}" type="hidden" id="marca_produto_div" name="marca_produto_div" />
        <input value="{{$produto->produto_preco_lista}}" type="hidden" id="preco_produto_div" name="preco_produto_div" />
        <input value="{{$produto->unidade}}" type="hidden" id="unidade_produto_div" name="unidade_produto_div" />
    @endforeach
  @else
     <input value="Não cadastrado" type="hidden" id="descricao_produto_div" name="descricao_produto_div" />
  @endif
  <script>
      preencher_campo_produto($('#id_produto_div').val(), $('#referencia_produto_div').val(), $('#descricao_produto_div').val(), $('#marca_produto_div').val(), $('#preco_produto_div').val(), $('#unidade_produto_div').val(), '');
  </script>
@endif

