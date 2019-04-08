@if($tipo == 'principal')
    @extends('layouts.template_janela')
@endif
@if($tipo == 'principal' || $tipo = 'retorno')
    @section('principal')
@php $nivel=1; @endphp
<div id="corpo">
</div>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav_categorias" role="tab">Categorias ML</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav_categorias_sistema" role="tab">Categorias Sistema</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav_categorias_arvore" role="tab">Categorias arvore</a>
    </li>
</ul>
{{ csrf_field() }}
<div class="tab-content row">
  @if(isset($MeliCategoriesPrincipal))
  @if(count($MeliCategoriesPrincipal) == 0)
  <div class="tab-pane active col-sm-12" id="nav_categorias" role="tabpanel">
    <form name="form_categories" id="form_categories" action="MeliCategories/save" method="POST">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:120px;">Categorias</legend>
        Não Existe Categoria Principal Cadastrada!<br/>
        Abaixo lista de Super Categorias que não estão Cadastradas.<br/>
        <div class="row">
            <div class="col-sm-12"> 
            <div class="row">
                <label for="" class="col-sm-12 custom-control col-form-label">Lista de Categorias </label>
                <input id="select-all" name="select-all" class="checkbox select-all" type="checkbox" nivel="{{$nivel}}" />
                <label for="" class="col-sm-1 custom-control col-form-label">Código</label>
                <label for="" class="col-sm-2 custom-control col-form-label">Descricão </label>
                @if(count($result) > 0)
                    @foreach($result as $categorie)                    
                    <div class="col-sm-12">
                        <div class="row">
                            <input name="checkbox_categorie[]" id="checkbox_categorie_{{$nivel}}" class="checkbox checkbox_categorie_{{$nivel}}" type="checkbox" value="{{$categorie['id']}}" />
                            &nbsp;
                            <input name="id_categorie[]" id="id_categorie_{{$categorie['id']}}" class="col-sm-1 form-control disabled" type="hidden" value="{{$categorie['id']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>
                            <input name="descricao_categorie[]" id="descricao_categorie_{{$categorie['id']}}" class="col-sm-2 form-control disabled" type="text" value="{{$categorie['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                        </div>
                    
                    </div>
                    @endforeach  
                @endif
                <button class="btn btn-outline-primary col-sm-3" type="button" id="cadastrar_categorias" name="cadastrar_categorias">
                    <img width="25" src="{{asset('assets/img/plus.png')}}" alt="Incluir Categoria" border="0" align="center" />
                    Incluir Categorias Selecionadas
                </button>
            </div>
            </div>
        </div>
    </fieldset>
  </form>
  </div>
  @endif
  @if(count($MeliCategoriesPrincipal) != 0)
  @php $nivel=1; @endphp

  <!-- Tab panes -->
  {{ csrf_field() }}
  <div class="tab-pane active col-sm-12 container-fluid" id="nav_categorias" role="tabpanel">
  <form name="form_categories" id="form_categories" action="MeliCategories/save" method="POST">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:120px;">Categorias</legend>
        <div id="categorias" class="row flex-row flex-nowrap" style="margin-left: 15px;">
            <div class="col-sm-3">
            <fieldset class="fieldset_busca col-sm-12">
                <legend class="legend_busca" style="max-width:110px;">Principais</legend>
            <div class="col-sm-12"> 
            <div class="row">
                <!-- <label for="" class="col-sm-1 custom-control col-form-label">Código</label> -->
                <label for="" class="col-sm-12 custom-control col-form-label">Descricão </label>
                @if(count($MeliCategoriesPrincipal) > 0)
                    @foreach($MeliCategoriesPrincipal as $CategoriesPrincipal)  
                    <div class="col-sm-12">
                        <div class="row">
                            <input type="hidden" name="id_categorie_cadastradas[]" id="id_categorie_{{$CategoriesPrincipal->meli_categorie_id_original}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal->meli_categorie_id_original}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            <button class="btn btn-outline-primary col-sm-12 verificar_categoria" type="button" id="{{$CategoriesPrincipal->meli_categorie_id_original}}" name="verificar_categoria_{{$CategoriesPrincipal->meli_categorie_id_original}}" nivel="1">
                                <input name="descricao_categorie_cadastradas[]" id="descricao_categorie_{{$CategoriesPrincipal->meli_categorie_name}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal->meli_categorie_name}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            </button>
                        </div>
                    </div>
                    @endforeach  
                @endif
            </div>
            </div>
            @if((count($MeliCategoriesPrincipal) != count($result)))
            <div class="row">
                <div class="col-sm-12"> 
                <div class="row">
                    <label for="" class="col-sm-12 custom-control col-form-label">Lista de Categorias não cadastradas </label>
                    <input id="select-all" name="select-all" class="checkbox select-all" type="checkbox" nivel="{{$nivel}}" />
                    <!-- <label for="" class="col-sm-1 custom-control col-form-label">Código</label> -->
                    <label for="" class="col-sm-10 custom-control col-form-label">Descricão </label>
                    @foreach($result as $categorie)  
                        @php $verifica=false; 
                        @endphp
                        @foreach($MeliCategoriesPrincipal as $CategoriePrincipal)
                            @if($CategoriePrincipal->meli_categorie_id_original == $categorie['id'])
                                @php $verifica = true; 
                                @endphp
                            @endif
                        @endforeach
                        @if($verifica == false)
                            <div class="col-sm-12">
                                <div class="row">
                                    <input name="checkbox_categorie[]" id="checkbox_categorie_{{$nivel}}" class="checkbox checkbox_categorie_{{$nivel}} col-sm-1" type="checkbox" value="{{$categorie['id']}}" />
                                    &nbsp;
                                    <input type="hidden" name="id_categorie[]" id="id_categorie_{{$categorie['id']}}" class="col-sm-1 form-control disabled" type="text" value="{{$categorie['id']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                    <input name="descricao_categorie[]" id="descricao_categorie_{{$categorie['id']}}" class="col-sm-10 form-control disabled" type="text" value="{{$categorie['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                </div>

                            </div>
                        @endif
                    @endforeach
                    <button class="btn btn-outline-primary col-sm-11" type="button" id="cadastrar_categorias" name="cadastrar_categorias" nivel="{{$nivel}}">
                        <img width="25" src="{{asset('assets/img/plus.png')}}" alt="Incluir Categoria" border="0" align="center" />
                        Incluir Categorias Selecionadas
                    </button>
                </div>
                </div>
            </div>
        @else
        <div class="row">
            <div class="col-sm-12"> 
            <div class="row">
                <label for="" class="col-sm-12 custom-control col-form-label">Todas as Categorias estão cadastradas </label>
            </div>
            </div>
        </div>
        @endif    
            </fieldset>
            </div>
        </div>
    </fieldset>
  </form>
  </div> 
  @endif
  <div class="tab-pane col-sm-12 container-fluid" id="nav_categorias_sistema" role="tabpanel">
  @if(isset($MeliCategoriesPrincipal))
    @if(count($MeliCategoriesPrincipal) == 0)
        <p>Não existe categorias cadastradas no sistema</p> 
    @else
        <fieldset class="fieldset_busca col-sm-12">
            <legend class="legend_busca" style="max-width:240px;">Categorias do Sistema</legend>
            <div id="categorias_sistema" class="row flex-row flex-nowrap" style="margin-left: 15px;">
                <div class="col-sm-3">
                    <fieldset class="fieldset_busca col-sm-12">
                        <legend class="legend_busca" style="max-width:110px;">Principais</legend>
                        <div class="col-sm-12"> 
                            <div class="row">
                                <label for="" class="col-sm-12 custom-control col-form-label">Descricão </label>
                                @if(count($MeliCategoriesPrincipal) > 0)
                                    @foreach($MeliCategoriesPrincipal as $CategoriesPrincipal)  
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <input type="hidden" name="id_categorie_cadastradas[]" id="id_categorie_{{$CategoriesPrincipal->meli_categorie_id_original}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal->meli_categorie_id_original}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                            <button class="btn btn-outline-primary col-sm-12 verificar_categoria_sistema" type="button" id="{{$CategoriesPrincipal->meli_categorie_id_original}}" name="verificar_categoria_{{$CategoriesPrincipal->meli_categorie_id_original}}" nivel="1">
                                                <input name="descricao_categorie_cadastradas[]" id="descricao_categorie_{{$CategoriesPrincipal->meli_categorie_name}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal->meli_categorie_name}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach  
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </fieldset>
    @endif
  @endif
  </div>
  <div class="tab-pane col-sm-12 container-fluid" id="nav_categorias_arvore" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:210px;">Categorias Arvore</legend>
        <div id="categorias_arvore" class="row flex-row flex-nowrap" style="margin-left: 15px;">
            <div class="col-sm-3">
                <fieldset class="fieldset_busca col-sm-12">
                    <legend class="legend_busca" style="max-width:110px;">Principais</legend>
                    <div class="col-sm-12"> 
                        <div class="row">
                            <label for="" class="col-sm-12 custom-control col-form-label">Descricão </label>
                            @if(count($result) > 0)
                                @foreach($result as $CategoriesPrincipal)  
                                <div class="col-sm-12">
                                    <div class="row">   
                                        <button class="btn btn-outline-primary col-sm-12 exibir_arvore" type="button" id="{{$CategoriesPrincipal['id']}}" name="exibir_arvore_{{$CategoriesPrincipal['id']}}" nivel="1">
                                            <input name="exibir_arvore[]" id="exibir_arvore_{{$CategoriesPrincipal['name']}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                        </button>
                                    </div>
                                </div>
                                @endforeach  
                            @endif
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </fieldset>
  </div>
</div>
@endif
@endsection
@endif
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
@endif
@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
    </div>
@endif
@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	Please check the form below for errors
    </div>
@endif


