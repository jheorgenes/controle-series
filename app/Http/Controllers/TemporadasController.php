<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Http\Request;

class TemporadasController extends Controller
{
    public function index(int $serieId) //Recebendo pela URL, o número da série
    {
        $serie = Serie::find($serieId); //Chamando o model Série, utilizando um fascade e buscando através do find();
        $temporadas = $serie->temporadas; //Pegando as temporadas de uma série

        return view('temporadas.index', compact('serie','temporadas'));
    }
}
