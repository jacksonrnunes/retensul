@extends('layouts.template')
@section('menu')
<div style="overflow:auto;" id="menu_lateral">
    <label id="label_menu">Menu Lateral</label>    
        <ul class="navbar-nav mr-auto rounded">
            <li class="nav-item">
                <a id="ver_categoria" name='ver_categoria' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Ver Categoria
                </a>
            </li>
            <li class="nav-item">
                <a id='editar_orcamento' name='linkar_categoria' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Linkar Categoria
                </a>
            </li>
            <li class="nav-item">
                <a id='deletar_orcamento' name='verificar_categoria' class="nav-link rounded-bottom" href="#" aria-haspopup="true" aria-expanded="false">
                    Verificar Categorias
                </a>
            </li>
        </ul>
</div>
@endsection
@section('principal')
@section('content')
@endsection
@endsection

