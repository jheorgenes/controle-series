<?php

namespace App\Services;

use App\Serie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CriadorDeSerie
{
    /**
     * Criando Série
     * @param string $nomeSerie
     * @param int $qtdTemporadas
     * @param int $epPorTemporada
     * @param string $capa
     * A interrogação na frente do tipo representa que o tipo pode ser opcional, ou seja, pode ou não ser passado o tipo string
     * return Model Serie
     */
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epPorTemporada, ?string $capa): Serie
    {
        DB::beginTransaction(); //Iniciando uma transação
            $serie = Serie::create([
                'nome' => $nomeSerie,
                'capa' => $capa
            ]);
            $this->criaTemporadas($qtdTemporadas, $epPorTemporada, $serie);
        DB::commit(); //Finalizando transação com o commit

        return $serie;
    }

    /**
     * Criando Temporadas
     * @param int $qtdTemporadas
     * @param int $epPorTemporada
     * @param $serie
     */
    private function criaTemporadas(int $qtdTemporadas, int $epPorTemporada, Serie $serie): void
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) { //Enquanto existir temporadas, incrementa
            $temporada = $serie->temporadas()->create(['numero' => $i]); //Gerando um número de temporada

            $this->criaEpisodios($epPorTemporada, $temporada);
        }
    }

    /**
     * Criando Episódios
     * @param int $epPorTemporada
     * @param \Illuminate\Database\Eloquent\Model $temporada
     */
    private function criaEpisodios(int $epPorTemporada, Model $temporada): void
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}
