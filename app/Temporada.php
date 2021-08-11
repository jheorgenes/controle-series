<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use function foo\func;

class Temporada extends Model
{
    protected $fillable = ['numero'];
    public $timestamps = false;

    public function serie()
    {
        return $this->belongsTo(Serie::class); //Temporada pertence a uma série
    }

    public function episodios()
    {
        return $this->hasMany(Episodio::class); //Temporada tem muitos episódios
    }

    public function getEpisodiosAssistidos(): Collection
    {
        return $this->episodios->filter(function (Episodio $episodio){
            return $episodio->assistido;
        });
    }
}
