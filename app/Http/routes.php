<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
Route::get('/categories', 'Painel\CategoriesController@index');
Route::resource('/categories', 'Painel\CategoriesController');
Route::get('/categories_add', 'Painel\CategoriesController@create');
Route::get('/categories_edit/{id}', 'Painel\CategoriesController@edit');
Route::get('/categories_del/{id}', 'Painel\CategoriesController@destroy');
*/


Route::get('/orcamento/add', 'Painel\Tb_orcamentoController@create');
Route::get('/orcamento/listar', 'Painel\Tb_orcamentoController@index');
Route::get('/orcamento/editar/{id}', 'Painel\Tb_orcamentoController@edit');
Route::get('/orcamento/responder/{id}', 'Painel\Tb_orcamentoController@responder');
Route::get('/orcamento/responder/produtos/buscar/tipo/{tipo}/div/{div}/json/{dados}', 'Painel\ProdutosController@buscar');
Route::post('/orcamento/editar/{id}/save', 'Painel\Tb_orcamentoController@update')->name('orcamento.update');
Route::get('/orcamento/editar/produtos/buscar/tipo/{tipo}/div/{div}/json/{dados}', 'Painel\ProdutosController@buscar');
Route::get('/orcamento/editar/produtos/buscar/tipo/{tipo}/div/{div}', 'Painel\ProdutosController@buscar');
Route::get('/orcamento/editar/produtos/buscar/tipo/{tipo}/json/{json}', 'Painel\ProdutosController@buscar');
Route::get('/orcamento/editar/clientes/buscar/tipo/{tipo}/json/{json}', 'Painel\PessoasController@buscar');
Route::get('/orcamento/editar/clientes/buscar/tipo/{tipo}/div/{div}', 'Painel\PessoasController@buscar');
Route::get('/orcamento/detalhes/{id}', 'Painel\Tb_orcamento_itensController@show');
Route::get('/orcamento/deletar/{id}', 'Painel\Tb_orcamentoController@destroy');
Route::get('/orcamento/incluir', 'Painel\Tb_orcamentoController@create');
Route::get('/orcamento/clientes/buscar/tipo/{tipo}', 'Painel\PessoasController@buscar');
Route::get('/orcamento/clientes/buscar/tipo/{tipo}/json/{json}', 'Painel\PessoasController@buscar');
Route::get('/orcamento/clientes/buscar/tipo/{tipo}/div/{div}', 'Painel\PessoasController@buscar');
Route::get('/orcamento/planos/buscar/tipo/{tipo}/div/{div}', 'Painel\PlanospagamentoController@buscar');
Route::get('/orcamento/planos/buscar/tipo/{tipo}/json/{json}', 'Painel\PlanospagamentoController@buscar');
Route::get('/orcamento/produtos/buscar/tipo/{tipo}/div/{div}', 'Painel\ProdutosController@buscar');
Route::get('/orcamento/produtos/buscar/tipo/{tipo}/json/{json}', 'Painel\ProdutosController@buscar');

Route::get('/orcamento/produtos/buscar/tipo/{tipo}/div/{div}/json/{dados}', 'Painel\ProdutosController@buscar');
Route::post('/orcamento/save', 'Painel\Tb_orcamentoController@salvar');


Route::get('/pedido/add', 'Painel\Tb_pedidoController@create');
Route::get('/pedido/listar', 'Painel\Tb_pedidoController@index');
Route::get('/pedido/detalhes/{id}', 'Painel\Tb_pedido_itensController@show');
Route::get('/pedido/deletar/{id}', 'Painel\Tb_pedidoController@destroy');

Route::get('/vendedores', 'Painel\VendedoresController@index');

Route::get('/MeliSuperCategories', 'Painel\MeliSuperCategoriesController@buscar');
Route::get('/MeliCategories/{categorie}', 'Painel\MeliCategoriesController@buscar');
Route::post('/MeliSuperCategories/save', 'Painel\MeliSuperCategoriesController@salvar');







Route::get('/', function () {
    return view('welcome');
});
