
@extends('layouts.template')
@section('principal')
@section('menu')
<div style="overflow:auto;" id="menu_lateral">
    <label id="label_menu">Menu Lateral</label>    
        <ul class="navbar-nav mr-auto rounded">
            <li class="nav-item">
                <a id="incluir_orcamento" name='incluir_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Incluir Categoria
                </a>
            </li>
            <li class="nav-item">
                <a id='editar_orcamento' name='editar_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Linkar Categoria
                </a>
            </li>
            <li class="nav-item">
                <a id='deletar_orcamento' name='deletar_orcamento' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Verificar Categorias
                </a>
            </li>
        </ul>
</div>
@endsection

@section('content')
@if(count($result) > 0)
  @foreach($result as $categorie)
    {{$categorie['id']}}
    -
    {{$categorie['name']}}
    
    <br/>
  @endforeach  
@endif
@endsection

@endsection

