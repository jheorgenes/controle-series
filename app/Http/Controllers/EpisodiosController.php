<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Temporada;
use Illuminate\Http\Request;

class EpisodiosController extends Controller
{
    public function index(Temporada $temporada, Request $request)
    {
        return view('episodios.index', [
            'episodios' => $temporada->episodios,
            'temporadaId' => $temporada->id,
            'mensagem' => $request->session()->get('mensagem')
        ]);
    }

    public function assistir(Temporada $temporada, Request $request)
    {
        $episodiosAssistidos = $request->episodios; //Pega os episódios assistidos marcados no checkInBox
        /* Loop do Laravel para percorrer cada episódio */
        $temporada->episodios->each(function (Episodio $episodio) //Recebe a Model de episódio
            use ($episodiosAssistidos) { //Declara que está utilizando a váriável externa dentro da função
            $episodio->assistido = in_array( //Recebe na coluna assistido, o que for igual no array
                $episodio->id, //id que está no banco
                $episodiosAssistidos //id dos episódios marcados como assistido
            );
        });
        $temporada->push(); //Envia tudo que tem de modificação e todas as modificações das dependências, pro banco

        $request->session()->flash(
            'mensagem',
            'Episódios marcados como assistidos'
        );

        return redirect()->back();
    }
}
