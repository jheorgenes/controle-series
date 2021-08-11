<?php

namespace Tests\Feature;

use App\Serie;
use App\Services\CriadorDeSerie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CriadorDeSerieTest extends TestCase
{
    use RefreshDatabase;
    public function testCriarSerie()
    {
        $criadorDeSerie = new CriadorDeSerie();
        $nomeSerie = 'Nome de teste';
        $serieCriada = $criadorDeSerie->criarSerie($nomeSerie, 1, 1);

        $this->assertInstanceOf(Serie::class, $serieCriada); //Verifica se está conectado na instância
        $this->assertDatabaseHas('series', ['nome' => $nomeSerie]); //verifica se há registro desse nome no banco de dados
        $this->assertDatabaseHas('temporadas', ['serie_id' => $serieCriada->id, 'numero' => 1]); //Verifica se há registro desse numero de temporadas no banco de dados
        $this->assertDatabaseHas('episodios', ['numero' => 1]); //Verifica se há registro desse numero de episódio no banco de dados
    }
}
