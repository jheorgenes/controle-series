<?php

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


use Illuminate\Support\Facades\Auth;

Route::get('/series', 'SeriesController@index')->name('listar_series');
Route::get('/series/criar', 'SeriesController@create')->name('form_criar_serie')->middleware('autenticador');
Route::post('/series/criar', 'SeriesController@store')->middleware('autenticador');
Route::delete('/series/{id}', 'SeriesController@destroy')->middleware('autenticador');
Route::post('/series/{id}/editaNome', 'SeriesController@editaNome');

Route::get('/series/{serieId}/temporadas', 'TemporadasController@index');

Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index');
Route::post('/temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')->middleware('autenticador');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/entrar', 'EntrarController@index');
Route::post('/entrar', 'EntrarController@entrar');
Route::get('/registrar', 'RegistroController@create');
Route::post('/registrar', 'RegistroController@store');

Route::get('/sair', function(){
    Auth::logout();
    return redirect('/entrar');
});

/* Essa rota acessa a classe de Email para visualizar o e-mail enviado
 * Recebe como argumento os dados do email para que será visualizado */
Route::get('/visualizando-email', function(){
   return new \App\Mail\NovaSerie(
       'Arow',
       5,
       10
   );
});

/* Essa rota acessa uma classe de Email para enviar um e-mail
 * Recebe como argumento os dados do e-mail que serão enviados */
Route::get('/enviando-email', function(){
    $email = new \App\Mail\NovaSerie(
        'Arow',
        5,
        10
    );

    $email->subject = 'Nova Série Adicionada'; //Adicionando um título ao e-mail
    $user = (object) [
        'email' => 'jheorgenes@gmail.com',
        'name' => 'Jheorgenes'
    ]; //Email e nome de quem vai receber o e-mail

    \Illuminate\Support\Facades\Mail::to($user)->send($email); //Enviando o e-mail
    return 'Email enviado!';
});
