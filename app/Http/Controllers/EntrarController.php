<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrarController extends Controller
{
    public function index()
    {
        return view('entrar.index');
    }

    public function entrar(Request $request)
    {
        /**
         * Auth (autenticate) é uma classe facade que realiza as autenticações no laravel
         * o método attempt() tenta fazer uma autenticação, utilizando como parâmetro, o email e senha
         * Nesse caso, está sendo utilizando um array associativo de emails e senhas para validar em algum desses logins, se são válidos na autenticação
         * Se a autenticação retornar false, vai redirecionar para a página de login e exibir mensagem de erro
         */
        if(!Auth::attempt($request->only(['email', 'password']))){
            //Realizando o redirecionamento para a página de login e exibindo mensagem de erro
            return redirect()->back()->withErrors('Usuário e/ou senha incorretos');
        }

        return redirect()->route('listar_series');
    }
}
