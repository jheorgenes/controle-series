<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;

class ExcluirCapaSerie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $serie;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($serie)
    {
        $this->serie = $serie; //Recebe os dados do dispatch que veio da classe RemovedorDeSerie
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() //Não recebe nada como argumento, pois está recebendo no construtor.
    {
        $serie = $this->serie;
        if($serie->capa) { //Verifica se tem arquivo de upload da capa
            Storage::delete($serie->capa); //Utiliza o fascade para deletar uma Capa de Série
        }
    }
}
