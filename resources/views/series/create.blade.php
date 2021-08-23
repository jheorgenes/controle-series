@extends('layout')

@section('cabecalho')
    Adicionar Série
@endsection

@section('conteudo')
    @include('erros', ['errors' => $errors])

    <form method="post" enctype="multipart/form-data"><!-- O elemento enctype="multipart/form-data" é para permitir que o formulário possa receber arquivos de upload -->
        @csrf <!-- Autenticação de segurança -->
        <div class="row">
            <div class="col col-8">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome">
            </div>

            <div class="col col-2">
                <label for="qtd_temporadas">Nº temporadas</label>
                <input type="number" class="form-control" name="qtd_temporadas" id="qtd_temporadas">
            </div>

            <div class="col col-2">
                <label for="ep_por_temporada">Nº episódios</label>
                <input type="number" class="form-control" name="ep_por_temporada" id="ep_por_temporada">
            </div>
        </div>
        <div class="row">
            <div class="col col-12">
                <label for="nome">Capa</label>
                <input type="file" class="form-control" name="capa" id="capa">
            </div>
        </div>
        <br>
        <button class="btn btn-primary">Adicionar</button>
    </form>
@endsection
