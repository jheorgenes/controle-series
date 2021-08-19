<?php


namespace App\Http\Controllers;

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
        $serie = $criadorDeSerie->criarSerie(
            $request->nome,
            $request->qtd_temporadas,
            $request->ep_por_temporada
        );

        $users = User::all();
        foreach ($users as $index => $user) {
            $multiplicador = $index + 1; //percorre o index do array e adiciona um número somado ao indice
            $email = new \App\Mail\NovaSerie( //Definindo os dados do email para serem enviados
                $request->nome,
                $request->qtd_temporadas,
                $request->ep_por_temporada
            );
            $email->subject = 'Nova Série Adicionada'; //Adicionando um titulo para o E-mail
            $when = now()->addSecond($multiplicador * 10); //Adicionando tempo de espera da fila (multiplicando 10 segundos para cada usuario da fila)
            /**
             * Para enviar e-mail pode ser utilizado as propriedades
             * send() = Apenas envia o e-mail
             * queue() = Envia e-mail por fila
             * later() = Envia e-mail por fila quando for sua vez (determina o tempo como parâmetro)
             */
            \Illuminate\Support\Facades\Mail::to($user)->later( //Enviando e-mail
                $when,
                $email);
            //sleep(5); //Adicionando tempo de espera de forma inapropriada
        }

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
