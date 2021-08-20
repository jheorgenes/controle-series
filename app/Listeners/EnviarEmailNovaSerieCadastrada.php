<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarEmailNovaSerieCadastrada
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
    public function handle(NovaSerie $event)
    {
        $nomeSerie = $event->nomeSerie;
        $qtdTemporadas = $event->qtdTemporadas;
        $qtdEpisodios = $event->qtdEpisodios;
        $users = User::all();

        foreach ($users as $index => $user) {
            $multiplicador = $index + 1; //percorre o index do array e adiciona um número somado ao indice
            $email = new \App\Mail\NovaSerie( //Definindo os dados do email para serem enviados
                $nomeSerie,
                $qtdTemporadas,
                $qtdEpisodios
            );

            $email->subject = 'Nova Série Adicionada'; //Adicionando um titulo para o E-mail
            $when = now()->addSecond($multiplicador * 10); //Adicionando tempo de espera da fila (multiplicando 10 segundos para cada usuario da fila)
            /**
             * Para enviar e-mail pode ser utilizado as propriedades
             * send() = Apenas envia o e-mail
             * queue() = Envia e-mail por fila
             * later() = Envia e-mail por fila quando for sua vez (determina o tempo como parâmetro)
             */
            \Illuminate\Support\Facades\Mail::to($user)->later( //Enviando e-mail
                $when,
                $email);
            //sleep(5); //Adicionando tempo de espera de forma inapropriada
        }
    }
}
