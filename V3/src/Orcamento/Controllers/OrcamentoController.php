<?php

namespace App\Orcamento\Controllers;

use App\Orcamento\Repository\OrcamentoRepository;
use App\Orcamento\Services\OrcamentoService;
use Config\Conexao;
use PDO;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class OrcamentoController
{
    private PDO $conn;
    public function __construct()
    {
        $this->conn = (new Conexao())->exec();
    }

    public function index(Request $request, Response $response)
    {
        $orcamento = new OrcamentoRepository($this->conn);
        $orcamento->listaDados();

        $retorno = [
            "status" => true,
            "resultSet" => $orcamento->getDados(),
            "qtd" => $orcamento->getQtd()
        ];

        $response->getBody()->write(json_encode($retorno));
        return $response;
    }

    public function update(Request $request, Response $response)
    {
        $dados = $request->getParsedBody();
        $orcamento = new OrcamentoService($this->conn,$dados);
        $status = $orcamento->atualizarDados();
        $erros = $orcamento->getErros();
        $retorno = [
            "status" => $status,
            "errors" => $erros
        ];
        $response->getBody()->write(json_encode($retorno));
        return $response;
    }

    public function destroy(Request $request, Response $response)
    {
        $dados = $request->getParsedBody();
        $orcamento = new OrcamentoService($this->conn,$dados);
        $status = $orcamento->deletarDados();
        $erros = $orcamento->getErros();
        $retorno = [
            "status" => $status,
            "errors" => $erros
        ];
        $response->getBody()->write(json_encode($retorno));
        return $response;
    }

    public function store(Request $request, Response $response)
    {
        $dados = $request->getParsedBody();
        $orcamento = new OrcamentoService($this->conn,$dados);
        $status = $orcamento->inserirRegistro();
        $erros = $orcamento->getErros();
        $retorno = [
            "status" => $status,
            "errors" => $erros
        ];
        $response->getBody()->write(json_encode($retorno));
        return $response;

    }



    //show -- retornar apenas um registro
    //index -- retornar mais de um registro
    //store -- executar um processo
    //update -- responsavel por atualizar registro
    //destry -- deletar registro
}


?>