<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 *Quando a classe implementa ShouldQueue, automaticamente a classe vai jogar o processo para uma fila
 */
class LogNovaSerieCadastrada implements ShouldQueue
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
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event) //Recebendo serviço de evento como argumento
    {
        $nomeSerie = $event->nomeSerie; //Adicionando dados
        \Log::info('Serie nova cadastrada ' . $nomeSerie); //Gerando log com uma string e o nome da série
    }
}
