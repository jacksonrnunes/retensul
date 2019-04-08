<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Retensul - Cadastro de Orcamentos</title>
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css')}}">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/estilo.css')}}">

</head>
<body>
    <div class='container-fluid'>
        <div class='row'>
            <div id='principal' class="col-md-12">
                @yield('principal')
            </div>
        </div>
    </div>
    <!-- JavaScripts -->
    <script src="{{asset('assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <!--<script src="{{asset('assets/js/popper.js')}}"></script>-->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/jquery.js')}}"></script>
</body>
</html>
