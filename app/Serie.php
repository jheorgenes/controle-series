<?php


namespace App;


use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * Mapeando objetos com tabelas
 * O laravel converte o nome da tabela automaticamente, colocando a primeira letra minuscula e acrescenta o 's' no final
 * protected $table = 'series'; Caso queira fazer o mapeamento manualmente
 */
class Serie extends Model
{
    public $timestamps = false; //retirando as colunas created_at e updated_ad
    protected $fillable = ['nome', 'capa']; //Atributo que determina quais campos poderão ser preenchidos com o método create

    public function getCapaUrlAttribute()
    {
        if($this->capa){ //Se tiver capa
            return Storage::url($this->capa); //Utiliza o fascade para buscar a URL até a pasta publica do storage e lá, vai acessar o o diretório da capa da série
        }
        return Storage::url('serie/sem-imagem.jpg'); //Senão tiver upload da capa, acessa a URL do fascade e exibe o arquivo sem imagem
    }

    public function temporadas()
    {
        return $this->hasMany(Temporada::class); //Série tem muitas temporadas
    }
}
