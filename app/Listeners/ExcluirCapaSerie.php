<?php

namespace App\Listeners;

use App\Events\SerieApagada;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage; //Necessário importar o alias de Storage

class ExcluirCapaSerie implements ShouldQueue //Trabalhando de forma assincrona.
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SerieApagada  $event
     * @return void
     */
    public function handle(SerieApagada $event) //Recebendo dados da classe de evento SerieApagada como argumento
    {
        $serie = $event->serie;
        if($serie->capa) { //Verifica se tem arquivo de upload da capa
            Storage::delete($serie->capa); //Utiliza o fascade para deletar uma Capa de Série
        }
    }
}
