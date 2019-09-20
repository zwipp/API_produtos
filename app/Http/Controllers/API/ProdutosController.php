<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Produto;


class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::all();

        return response($produtos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validacao = Validator::make(request()->all(), [
            'nome' => 'required',
            'descricao' => 'required',
            'valor' => 'required',
        ]);

        if($validacao->fails()){ //se tiver algum erro entra aki
            return response($validacao->messages(),401);
        }

        if(!empty(request('url_imagem'))){
            $caminhoCompleto = public_path() . '/storage/uploads'; //o caminho onde será colocado a img
            $nomeArquivo = time() . '.' . 'png'; //escolher o nome do arquivo
            //movendo para o projeto
            request('url_imagem')->move($caminhoCompleto, $nomeArquivo);

            $produto = Produto::create([
                'nome' => request('nome'),
                'descricao' => request('descricao'),
                'url_imagem' => url('/storage/uploads' . $nomeArquivo), //salvar a img com o caminho dela
                'valor' => request('valor')
            ]);
        }
        else{
            $produto = Produto::create([
                'nome' => request('nome'),
                'descricao' => request('descricao'),
                'valor' => request('valor')
            ]);
        }

        return response($produto, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if(!$produto){
            $erro = ['mensagem' => 'produto nao encontrado'];
            return response(json_encode($erro),401);
        }
        
        $produto->delete();

        return response($produto, 200);
    }
}
