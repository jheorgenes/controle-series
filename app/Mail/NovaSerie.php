<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NovaSerie extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $qtdTemporadas;
    public $qtdEpisodios;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $qtdTemporadas, $qtdEpisodios) //recebendo dados da série como parâmetro
    {
        $this->nome = $nome;
        $this->qtdTemporadas = $qtdTemporadas;
        $this->qtdEpisodios = $qtdEpisodios;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() //Função criada pelo próprio laravel
    {
        return $this->markdown('mail.serie.nova-serie'); //Utilizando as marcações de texto (igual readme do github)
    }
}
