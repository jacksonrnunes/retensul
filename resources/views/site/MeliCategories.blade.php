
<form name="form_sub_categories" id="form_sub_categories" action="MeliCategories/save" method="POST">
{{ csrf_field() }}
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_categorias" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:0px;"></legend>
        <div class="row">
            <div class="col-sm-12"> 
            <div class="row">
                <label for="" class="col-sm-12 custom-control col-form-label">Lista de Categorias não cadastradas</label>
                <input name="select-all-n2" id="select-all-n2" class="checkbox" type="checkbox" />
                <!-- <label for="" class="col-sm-1 custom-control col-form-label">Código</label>-->
                <label for="" class="col-sm-2 custom-control col-form-label">Descricão </label>
                @if(count($result) > 0)
                    @foreach($result as $categorie)                    
                    <div class="col-sm-12">
                        <div class="row">
                            <input name="checkbox_categorie[]" id="checkbox_categorie_{{$categorie['id']}}" class="checkbox checkbox_categorie_n2" type="checkbox" value="{{$categorie['id']}}" />
                            &nbsp;
                            <input type="hidden" name="id_categorie[]" id="id_categorie_{{$categorie['id']}}" class="col-sm-1 form-control disabled" type="text" value="{{$categorie['id']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            <input name="descricao_categorie[]" id="descricao_categorie_{{$categorie['id']}}" class="col-sm-10 form-control disabled" type="text" value="{{$categorie['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                        </div>
                    
                    </div>
                    @endforeach  
                @endif
                <button class="btn btn-outline-primary col-sm-12" type="button" id="cadastrar_categorias" name="cadastrar_categorias">
                    <img width="25" src="{{asset('assets/img/plus.png')}}" alt="Incluir Categoria" border="0" align="center" />
                    Incluir Categorias Selecionadas
                </button>
            </div>
            </div>
        </div>
    </fieldset>
  </div>
</div> 
</form>
