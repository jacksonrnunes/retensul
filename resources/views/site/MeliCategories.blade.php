
{{$tipo}}
    
    @if($tipo == 'principal')
@extends('layouts.template_janela')
@endif
@if($tipo == 'principal' || $tipo = 'retorno')
@section('principal')
@if(isset($MeliCategoriesPrincipal))
@if(count($MeliCategoriesPrincipal) == 0)
<div id="corpo">
</div>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav_categorias" role="tab">Categorias</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#nav_produtos" role="tab">Produtos</a>
    </li>
</ul>
<!-- Tab panes -->
<form name="form_categories" id="form_categories" action="MeliCategories/save" method="POST">
{{ csrf_field() }}
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_categorias" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:120px;">Categorias</legend>
        Não Existe Categoria Principal Cadastrada!<br/>
        Abaixo lista de Super Categorias que não estão Cadastradas.<br/>
        <div class="row">
            <div class="col-sm-12"> 
            <div class="row">
                <label for="" class="col-sm-12 custom-control col-form-label">Lista de Categorias </label>
                <input name="select-all" id="select-all" class="checkbox" type="checkbox" />
                <label for="" class="col-sm-1 custom-control col-form-label">Código</label>
                <label for="" class="col-sm-2 custom-control col-form-label">Descricão </label>
                @if(count($result) > 0)
                    @foreach($result as $categorie)                    
                    <div class="col-sm-12">
                        <div class="row">
                            <input name="checkbox_categorie[]" id="checkbox_categorie" class="checkbox checkbox_categorie" type="checkbox" value="{{$categorie['id']}}" />
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
  </div>
<div class="tab-pane col-sm-12" id="nav_produtos" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:65px;">Ações</legend>
    </fieldset>
</div>
</div> 
</form>
@endif
@if(count($MeliCategoriesPrincipal) != 0)
<div id="corpo">
</div>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#nav_categorias" role="tab">Categorias</a>
    </li>
</ul>
<!-- Tab panes -->
<form name="form_categories" id="form_categories" action="MeliCategories/save" method="POST">
{{ csrf_field() }}
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_categorias" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:120px;">Categorias</legend>
        <div class="row" style="margin-left: 15px;">
            <div class="col-sm-3">
            <fieldset class="fieldset_busca col-sm-12">
                <legend class="legend_busca" style="max-width:0px;"></legend>
            <div class="col-sm-12"> 
            <div class="row">
                
                <!-- <label for="" class="col-sm-1 custom-control col-form-label">Código</label> -->
                <label for="" class="col-sm-12 custom-control col-form-label">Descricão </label>
                @if(count($MeliCategoriesPrincipal) > 0)
                    @foreach($MeliCategoriesPrincipal as $CategoriesPrincipal)  
                    <div class="col-sm-12">
                        <div class="row">
                            <input type="hidden" name="id_categorie_cadastradas[]" id="id_categorie_{{$CategoriesPrincipal->meli_categorie_id_original}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal->meli_categorie_id_original}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            <button class="btn btn-outline-primary col-sm-12 verificar_categoria" type="button" id="{{$CategoriesPrincipal->meli_categorie_id_original}}" name="verificar_categoria_{{$CategoriesPrincipal->meli_categorie_id_original}}">
                                <input name="descricao_categorie_cadastradas[]" id="descricao_categorie_{{$CategoriesPrincipal->meli_categorie_name}}" class="col-sm-12 form-control disabled" type="text" value="{{$CategoriesPrincipal->meli_categorie_name}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                <!-- <img width="25" src="{{asset('assets/img/plus.png')}}" alt="verificar_categoria" border="0" align="center" />-->
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
                    <input name="select-all" id="select-all" class="checkbox" type="checkbox" class="col-sm-2" />
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
                                    <input name="checkbox_categorie[]" id="checkbox_categorie" class="checkbox checkbox_categorie col-sm-1" type="checkbox" value="{{$categorie['id']}}" />
                                    &nbsp;
                                    <input type="hidden" name="id_categorie[]" id="id_categorie_{{$categorie['id']}}" class="col-sm-1 form-control disabled" type="text" value="{{$categorie['id']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                    <input name="descricao_categorie[]" id="descricao_categorie_{{$categorie['id']}}" class="col-sm-10 form-control disabled" type="text" value="{{$categorie['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                </div>

                            </div>
                        @endif
                    @endforeach
                    <button class="btn btn-outline-primary col-sm-11" type="button" id="cadastrar_categorias" name="cadastrar_categorias">
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
            <div class="col-sm-3" id="div_nivel2" name="div_nivel2">
            </div>
        </div>
         
    </fieldset>
  </div>
<div class="tab-pane col-sm-12" id="nav_produtos" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
        <legend class="legend_busca" style="max-width:65px;">Ações</legend>
    </fieldset>
</div>
</div> 
</form>
@endif
@else
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


