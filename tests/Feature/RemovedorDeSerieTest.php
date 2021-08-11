<?php

namespace Tests\Feature;

use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemovedorDeSerieTest extends TestCase
{
    use RefreshDatabase;
    /** @var Serie */
    private $serie;
    protected function setUp(): void
    {
        parent::setUp();
        $criadorDeSerie = new CriadorDeSerie();
        $this->serie = $criadorDeSerie->criarSerie('Nome da Série', 1, 1);
    }

    public function testRemoverUmaSerie()
    {
        $this->assertDatabaseHas('series', ['id' => $this->serie->id]); //Verifica se tem o registro no banco
        $removedorDeSerie = new RemovedorDeSerie();
        $nomeSerie = $removedorDeSerie->removerSerie($this->serie->id);
        $this->assertIsString($nomeSerie); //verifica se é uma string
        $this->assertEquals('Nome da Série', $this->serie->nome); //Verifica se o nome é igual
        $this->assertDatabaseMissing('series', ['id' => $this->serie->id]); //Verifica se NÃO existe mais a série no banco
    }
}
