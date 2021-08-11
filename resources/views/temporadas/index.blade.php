@extends('layout')

@section('cabecalho')
    Temporadas de {{ $serie->nome }}
@endsection

@section('conteudo')
    <ul class="list_group">
        @foreach ($temporadas as $temporada)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="/temporadas/{{ $temporada->id }}/episodios">
                    Temporada {{ $temporada->numero }}
                </a>
                <span class="badge bg-dark">
                   {{ $temporada->getEpisodiosAssistidos()->count() }} / {{ $temporada->episodios->count() }} <!--Coleção de Episódios-->
                </span>
            </li>
        @endforeach
    </ul>
@endsection
