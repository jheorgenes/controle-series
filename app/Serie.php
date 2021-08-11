<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * Mapeando objetos com tabelas
 * O laravel converte o nome da tabela automaticamente, colocando a primeira letra minuscula e acrescenta o 's' no final
 * protected $table = 'series'; Caso queira fazer o mapeamento manualmente
 */
class Serie extends Model
{
    public $timestamps = false; //retirando as colunas created_at e updated_ad
    protected $fillable = ['nome']; //Atributo que determina quais campos poderão ser preenchidos com o método create

    public function temporadas()
    {
        return $this->hasMany(Temporada::class); //Série tem muitas temporadas
    }
}
