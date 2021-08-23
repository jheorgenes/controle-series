@extends('layout')

@section('cabecalho')
    Séries
@endsection

@section('conteudo')

    @include('mensagem', ['mensagem' => $mensagem])

    @auth
    <a href="{{ route('form_criar_serie') }}" class="btn btn-dark mb-2">Adicionar</a>
    @endauth
    <ul class="list-group">
        @foreach ($series as $serie)
        <li class="list-group-item
                   d-flex
                   justify-content-between
                   align-items-center">
            <div>
                <img src="{{ $serie->capa_url }}" class="img-thumbnail" height="100px" width="100px"><!-- Incluíndo a imagem da capa e acessando o mutator do laravel -->
                <span id="nome-serie-{{ $serie->id }}">{{ $serie->nome }}</span>
            </div>
            <div class="input-group w-50" hidden id="input-nome-serie-{{ $serie->id }}">
                <input type="text" class="form-control" value="{{ $serie->nome }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" onclick="editarSerie({{ $serie->id }})">
                        <i class="fas fa-check"></i>
                    </button>
                    @csrf
                </div>
            </div>

            <span class="d-flex">
                @auth
                <button class="btn btn-info btn-sm m-1" onclick="toggleInput({{ $serie->id }})">
                    <i class="fas fa-edit"></i>
                </button>
                @endauth
                <a href="/series/{{ $serie->id }}/temporadas" class="btn btn-info btn-sm m-1">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                @auth
                <form method="post" action="/series/{{ $serie->id }}"
                      onsubmit="return confirm('Tem certeza que deseja remover {{ addslashes($serie->nome) }}? ')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm m-1">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </form>
                @endauth
            </span>
        </li>
        @endforeach
    </ul>

    <script>
        function toggleInput(serieId){
            const nomeSerieEl = document.getElementById(`nome-serie-${serieId}`);
            const inputSerieEl = document.getElementById(`input-nome-serie-${serieId}`);
            if (nomeSerieEl.hasAttribute('hidden')) { //Se o nome estiver escondido
                nomeSerieEl.removeAttribute(`hidden`); //Remove o atributo que esconde
                inputSerieEl.hidden = true; //Adiciona a Série
            } else { //Se o nome não estiver escondido, esconda-o
                inputSerieEl.removeAttribute('hidden'); //Exibir o input
                nomeSerieEl.hidden = true; //Esconde o nome da série
            }
        }

        function editarSerie(serieId) {
            let formData = new FormData();
            const nome = document.querySelector(`#input-nome-serie-${serieId} > input`).value; //Pegando o novo valor do nome da série que está no input
            const token = document.querySelector('input[name="_token"]').value; //Pegando o token
            formData.append('nome', nome); //adicionando no objeto FormData, o parametro nome e o valor do nome
            formData.append('_token', token); //adicionando no objeto FormData, o parametro _token e o valor do token

            const url = `/series/${serieId}/editaNome`; //Definindo a URL
            /* fetch é tipo um ajax do js que permite fazer requisição de forma assíncrona */
            fetch(url, { //Recebe como parametro a URL, um objeto de parametros que tenha: corpo e método
                body: formData, //Recebe o objeto FormData como corpo do objeto
                method: 'POST' //Recebe o POST como método da requisição.
            }).then(() => { //Depois de concluído a requisição.
                toggleInput(serieId); //Retira o campo input da serieID, utilizando a função liga e desliga
                document.getElementById(`nome-serie-${serieId}`).textContent = nome; //Adiciona no html o texto com o novo nome.
            });
        }
    </script>
@endsection
