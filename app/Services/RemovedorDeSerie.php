<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\{Events\SerieApagada, Jobs\ExcluirCapaSerie, Serie, Temporada, Episodio};
use Storage; //Acessor de Upload de Arquivos. Utiliza fascade para realizar algumas operações, como acessar a url, deletar o arquivo, etc.

class RemovedorDeSerie
{
    /**
     * Removendo Série
     * @param $serieId
     * return string
     */
    public function removerSerie(int $serieId): string
    {
        $nomeSerie = '';
        /**
         * Utilizando Transações do Banco
         * Método transaction garante que só será executado quando
         * tudo que estiver dentro da função, for possível de ser executado no banco de dados
         * Isso trás garantia de integridade e performance
         **/
        DB::transaction(function() use($serieId, &$nomeSerie){ //&$nomeSerie passado como referência
            $serie = Serie::find($serieId); //Buscando Serie
            $serieObj = (object) $serie->toArray(); //Transformando série em array e depois transformando em objeto.

            $nomeSerie = $serie->nome;
            $this->removerTemporadas($serie); //Chamando método interno
            $serie->delete(); //terceiro deleta serie

            $evento = new SerieApagada($serieObj); //Criando dados do Evento com os dados da Série
            event($evento); //Emitindo evento
            ExcluirCapaSerie::dispatch($serieObj); //Chamando a classe Job e disparando (enviando os dados pro job através de injeção de dependência) um objeto stdClass de $serieObj
        });
        return $nomeSerie;
    }

    /**
     * Removendo temporadas
     * @param $serie
     * @throws \Exception
     */
    private function removerTemporadas(Serie $serie): void
    {
        /**
         * Método each (laço de repetição)
         * Método each() executará, pra cada uma das temporadas, uma função cujo parâmetro é $temporada
         * Bem parecido com um laço melhorado
         **/
        $serie->temporadas->each(function (Temporada $temporada) {
            $this->removerEpisodios($temporada);
            $temporada->delete(); //segundo deleta temporadas
        });
    }

    /**
     * Removendo Episódios
     * @param Temporada $temporada
     * @throws \Exception
     */
    private function removerEpisodios(Temporada $temporada): void
    {
        /**
         * Método each (laço de repetição)
         * Método each() executará, pra cada um dos episodios, uma função cujo parâmetro é $episodio
         * Bem parecido com um laço melhorado
         **/
        $temporada->episodios->each(function (Episodio $episodio) {
            $episodio->delete(); //primeiro deleta episódios
        });
    }
}
