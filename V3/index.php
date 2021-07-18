<?php

use App\Orcamento\Controllers\OrcamentoController;
use App\Orcamento\Repository\OrcamentoRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Config\Conexao;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();


// $app->get('/', function (Request $request, Response $response, $args) {
//     $conexao = new Conexao();
//     $orcamento = new OrcamentoRepository($conexao->exec());
//     $orcamento->listaDados();
//     $response->getBody()->write(json_encode([
//         "dados" => $orcamento->getDados(),
//         "qtd" => $orcamento->getQtd()
//     ]));
//     return $response;
// });


$app->get('/orcamento/lista', OrcamentoController::class . ':index');

$app->post('/orcamento/inserir', OrcamentoController::class . ':store');

$app->put('/orcamento/atualizar', OrcamentoController::class . ':update');

$app->delete('/orcamento/deletar', OrcamentoController::class . ':destroy');

$app->run();