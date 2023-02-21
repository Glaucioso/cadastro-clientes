<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Layout.base');
})->name('inicio');


// ROUTES para Locais de divulgação
Route::get('/gestao_clientes/cadastros/locais/lista', 'locais@mostrar_locais')->name('lista_locais');
Route::get('/gestao_clientes/cadastros/locais/lista/adicionar', 'locais@add_locais')->name('add_locais');
Route::post('/gestao_clientes/cadastros/locais/lista/adicionar/gravando', 'locais@gravar_locais')->name('gravar_locais');
Route::get('/gestao_clientes/cadastros/locais/lista/editar/{id_local}', 'locais@editar_local')->name('editar_locais');
Route::post('/gestao_clientes/cadastros/locais/lista/editar/gravando', 'locais@gravar_edit_locais')->name('gravar_edit_locais');

//ROUTES para cadastro de clientes
Route::get('/gestao_clientes/clientes', 'clientes@listar_cliente')->name('lista_cliente');
Route::post('/gestao_clientes/clientes/cadastro/buscar', 'clientes@listar2_cliente')->name('buscar_cliente');
Route::get('/gestao_clientes/clientes/cadastro/add/{codigo}', 'clientes@add_cliente')->name('add_cliente');
Route::post('/gestao_clientes/clientes/cadastro/gravar', 'clientes@gravar_cliente')->name('gravar_cliente');
Route::get('/gestao_clientes/clientes/cadastro/editar/{codigo}', 'clientes@editar_cliente')->name('editar_cliente');
Route::post('/gestao_clientes/clientes/cadastro/editar/gravando', 'clientes@gravar_edit_cliente')->name('gravar_edit_cliente');
