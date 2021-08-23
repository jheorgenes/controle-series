@extends('layout')

@section('cabecalho')
    Temporadas de {{ $serie->nome }}
@endsection

@section('conteudo')

    @if($serie->capa)<!-- Se tiver upload da capa da série -->
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <a href="{{ $serie->capa_url }}" target="_blank"><!-- Acessa a capa da Série utilizando o mutator do laravel -->
                    <img src="{{ $serie->capa_url }}" class="img-thumbnail" height="400px" width="400px">
                </a>
            </div>
        </div>
    @endif

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
