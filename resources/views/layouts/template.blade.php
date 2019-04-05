<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Retensul - Cadastro de Orcamentos</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/estilo.css')}}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding:.0rem 1rem!important;">
        <a class="navbar-brand">
            <img src="{{asset('assets/img/logo.jpg')}}" width="28">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown" style="padding:10px;">
            <ul class="navbar-nav mr-auto rounded" id="menu">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded-bottom" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Orçamentos
                    </a>
                    <ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdownMenuLink">
                        <span class="bar-navegation"></span>
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="orcamento/add">
                                Incluir Orçamento
                            </a>                                
                        </li>    
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="orcamento/listar">
                                Ver Orçamentos
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded-bottom" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pedidos
                    </a>
                    <ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdownMenuLink">
                        <span class="bar-navegation"></span>
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="pedido/add">
                                Incluir Pedido
                            </a>                                
                        </li>    
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="pedido/listar">
                                Ver Pedidos
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded-bottom" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Compras
                    </a>
                    <ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdownMenuLink">
                        <span class="bar-navegation"></span>
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="compras/listar_produtos">
                                Listar Produtos
                            </a>                                
                        </li>    
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="compras/listar">
                                Ver Compras
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded-bottom" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mercado Livre
                    </a>
                    <ul class="dropdown-menu sub-menu" aria-labelledby="navbarDropdownMenuLink">
                        <span class="bar-navegation"></span>
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="MercadoLivre">
                                Ver Mercado Livre
                            </a>                                
                        </li>    
                        <li class="nav-item dropdown">
                            <a class="nav-link rounded-bottom" href="MeliProducts">
                                Ver Produtos
                            </a>
                        </li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </nav>
    <div class='container-fluid'>
        <div class='row'>
            <div id='menu-lateral' class="col-md-2">
                @yield('menu')
            </div>
            <div class='col-md-10'>
                <div id='content' class='row col-md-12'>
                    @yield('content')
                </div>
                <div id='detalhes' class='row col-md-12'>
                    @yield('detalhes')
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScripts -->
    <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/jquery.js')}}"></script>
</body>
</html>
