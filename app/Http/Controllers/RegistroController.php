<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function create()
    {
        return view('registro.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token'); //Pega tudo que estiver no formulário, exceto o token
        $data['password'] = Hash::make($data['password']); //Modificando a senha para um Hash de autenticação criptografado pelo láravel
        $user = User::create($data); //Criando um usuário com as informações

        Auth::login($user); //Usando os usuários para autenticação

        return redirect()->route('listar_series');
    }
}
