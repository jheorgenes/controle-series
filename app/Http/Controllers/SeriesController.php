<?php


namespace App\Http\Controllers;

use App\Events\NovaSerie;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\User;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Método para ixibir Página de Séries
     * @param Request $request (Responsável pelo tratamento de requisições)
     */
    public function index(Request $request)
    {

        /** Exemplos que podem ser utilizados
         * echo $request->url(); //Consulta a URL
         * echo $request->query('parametro'); Consulta o valor do parâmetro passado.
         * var_dump($request->query()); Consulta todos os dados da query String e trás em formato de array
         * $series = Serie::all(); //Trás todos os dados que o eloquent conseguiu encontrar
         */
        $series = Serie::query() //Consulta no banco
            ->orderBy('nome') //Ordena pela coluna 'nome'
            ->get(); //Pega tudo e retorna para $series

        $mensagem = $request->session()->get('mensagem'); //Método session da classe Request, pega a 'key' (definida como mensagem)
        //$request->session()->remove('mensagem'); //Quando quiser remover a sessão
        return view('series.index', compact('series', 'mensagem')); //Chama a view, passando os dados da series e da mensagem (obtidos anteriormente)
    }

    /**
     * Método para acesso a tela de criação de novas Séries
     */
    public function create()
    {
        return view('series.create');
    }

    /**
     * Método para criar Série
     * @param SeriesFormRequest $request
     * @param CriadorDeSerie $criadorDeSerie (Classe definida como uma classe de serviço, ou comumente chamada de Helpers)
     */
    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
        $capa = null; //Define nulo por segurança
        if($request->hasFile('capa')){ //Se houver upload (função hasFile valida se tem arquivo de upload e retorna true ou false)
            $capa = $request->file('capa')->store('serie'); //Busca do request um arquivo de upload e adiciona no store (diretório) de série
        }

        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada,
            $capa //Enviando o arquivo upload da capa na Série
        );

        /* Criando um objeto de Evento */
        $eventoNovaSerie = new NovaSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        event($eventoNovaSerie); //Executando um evento

        $request->session()
            ->flash( //Exibe enquanto durar uma requisição
                'mensagem', //Key da session
                "Série {$serie->id} com suas temporadas e episódios, criada com sucesso: {$serie->nome}" //Value da session
            );
        return redirect()->route('listar_series');
        //return redirect('/series'); //Quando não tem nomeclatura da rota
    }

    /**
     * Método para remover uma Série
     * @param Request $request
     * @param RemovedorDeSerie $removedorDeSerie (Classe definida como uma classe de serviço, ou comumente chamada de Helpers)
     */
    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        $request->session() //Retornando mensagem de sucesso
            ->flash(
                'mensagem',
                "Série $nomeSerie removida com sucesso"
            );
        return redirect()->route('listar_series');
    }

    public function editaNome(int $id, Request $request)
    {
        $novoNome = $request->nome;
        $serie = Serie::find($id);
        $serie->nome = $novoNome;
        $serie->save();
    }
}
