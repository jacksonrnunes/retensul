@if($tipo == 'retorno')
@php $nivel++;@endphp
<form name="form_sub_categories" id="form_sub_categories" action="MeliCategories/save" method="POST">
{{ csrf_field() }}
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_categorias" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
    <legend class="legend_busca" style="max-width:120px;">Categorias</legend>
        <div class="col-sm-12"> 
            <div class="row">
                <!-- <label for="" class="col-sm-1 custom-control col-form-label">Código</label> -->
                @if(count($SubCategorias) > 0)
                <label for="" class="col-sm-12 custom-control col-form-label">Descricão </label>
                    @foreach($SubCategorias as $SubCategoria)  
                    <div class="col-sm-12">
                        <div class="row">
                            <input type="hidden" name="id_categorie_cadastradas[]" id="id_categorie_{{$SubCategoria->meli_categorie_id_original}}" class="col-sm-12 form-control disabled" type="text" value="{{$SubCategoria->meli_categorie_id_original}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            <button class="btn btn-outline-primary col-sm-12 verificar_categoria" type="button" id="{{$SubCategoria->meli_categorie_id_original}}" name="verificar_categoria_{{$SubCategoria->meli_categorie_id_original}}" nivel="{{$nivel}}">
                                <input name="descricao_categorie_cadastradas[]" id="descricao_categorie_{{$SubCategoria->meli_categorie_name}}" class="col-sm-12 form-control disabled" type="text" value="{{$SubCategoria->meli_categorie_name}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            </button>
                        </div>
                    </div>
                    @endforeach  
                @endif
            </div>
        </div>
        @if((count($SubCategorias) != count($result)))
        <div class="row">
            <div class="col-sm-12"> 
                <div class="row">
                    @if(count($SubCategorias) > 0)
                    <input id="select-all" name="select-all" class="checkbox select-all" type="checkbox" nivel="{{$nivel}}" />
                    <label for="" class="col-sm-2 custom-control col-form-label">Descricão </label>
                        @if(count($result) > 0)
                        @foreach($result as $categorie)  
                            @php $verifica=false; 
                            @endphp
                            @foreach($SubCategorias as $SubCategoria)
                                @if($SubCategoria->meli_categorie_id_original == $categorie['id'])
                                    @php $verifica = true; 
                                    @endphp
                                @endif
                            @endforeach
                            @if($verifica == false)
                                <div class="col-sm-12">
                                    <div class="row">
                                        <input type="checkbox" name="checkbox_categorie_{{$nivel}}[]" id="checkbox_categorie_{{$nivel}}" class="checkbox checkbox_categorie_{{$nivel}} col-sm-1" value="{{$categorie['id']}}" />
                                        <input type="hidden" name="id_categorie[]" id="id_categorie_{{$categorie['id']}}" class="col-sm-3 form-control disabled" value="{{$categorie['id']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                        <input type="text" name="descricao_categorie[]" id="descricao_categorie_{{$categorie['id']}}" class="col-sm-10 form-control disabled" value="{{$categorie['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @endif
                    @else
                        <label for="" class="col-sm-12 custom-control col-form-label">Lista de Categorias não cadastradas</label>
                        <input id="select-all" name="select-all" class="checkbox select-all" type="checkbox" nivel="{{$nivel}}" />
                        <label for="" class="col-sm-2 custom-control col-form-label">Descricão </label>
                        @if(count($result) > 0)
                            @foreach($result as $categorie)                    
                            <div class="col-sm-12">
                                <div class="row">
                                    <input name="checkbox_categorie_{{$nivel}}[]" id="checkbox_categorie_{{$nivel}}" class="checkbox checkbox_categorie_{{$nivel}}" type="checkbox" value="{{$categorie['id']}}" />
                                    <input type="hidden" name="id_categorie[]" id="id_categorie_{{$categorie['id']}}" class="col-sm-1 form-control disabled" type="text" value="{{$categorie['id']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                    <input name="descricao_categorie[]" id="descricao_categorie_{{$categorie['id']}}" class="col-sm-10 form-control disabled" type="text" value="{{$categorie['name']}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                                </div>
                            </div>
                            @endforeach  
                        @endif
                        @endif
                        <button class="btn btn-outline-primary col-sm-12" type="button" id="cadastrar_sub_categorias" name="cadastrar_sub_categorias" nivel="{{$nivel}}">
                            <img width="25" src="{{asset('assets/img/plus.png')}}" alt="Incluir Categoria" border="0" align="center" />
                            Incluir Categorias Selecionadas
                        </button>
                </div>
            </div>
        </div>
        @endif
    </fieldset>
  </div>
   
</div> 
</form>
<script src="{{asset('assets/js/jquery.js')}}"></script>
@endif
@if($tipo == 'vazio')
<p>vazio</p>
@endif
@if($tipo == 'sistema')
@php $nivel++;@endphp
{{ csrf_field() }}
<div class="tab-content row">
  <div class="tab-pane active col-sm-12" id="nav_categorias" role="tabpanel">
    <fieldset class="fieldset_busca col-sm-12">
    <legend class="legend_busca" style="max-width:120px;">Categorias</legend>
        <div class="col-sm-12"> 
            <div class="row">
                <!-- <label for="" class="col-sm-1 custom-control col-form-label">Código</label> -->
                @if(count($SubCategorias) > 0)
                <label for="" class="col-sm-12 custom-control col-form-label">Descricão </label>
                    @foreach($SubCategorias as $SubCategoria)  
                    <div class="col-sm-12">
                        <div class="row">
                            <input type="hidden" name="id_categorie_cadastradas[]" id="id_categorie_{{$SubCategoria->meli_categorie_id_original}}" class="col-sm-12 form-control disabled" type="text" value="{{$SubCategoria->meli_categorie_id_original}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
                            <button class="btn btn-outline-primary col-sm-12 verificar_categoria_sistema" type="button" id="{{$SubCategoria->meli_categorie_id_original}}" name="verificar_categoria_{{$SubCategoria->meli_categorie_id_original}}" nivel="{{$nivel}}">
                                <input name="descricao_categorie_cadastradas[]" id="descricao_categorie_{{$SubCategoria->meli_categorie_name}}" class="col-sm-12 form-control disabled" type="text" value="{{$SubCategoria->meli_categorie_name}}" placeholder="Campo não editável, dado capturado da API do ML" disabled="disabled" readonly="readonly" required>    
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
<script src="{{asset('assets/js/jquery.js')}}"></script>
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


