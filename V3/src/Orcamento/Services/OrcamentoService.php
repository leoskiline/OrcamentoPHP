<?php

namespace App\Orcamento\Services;
use App\Orcamento\Models\OrcamentoModel;
use PDO;

class OrcamentoService{
    private PDO $conn;
    private OrcamentoModel $orcamento;
    private Array $erros = [];

    public function __construct(PDO $conn,array $dados)
    {
        $this->conn = $conn;
        $this->orcamento = new OrcamentoModel();
        $this->orcamento->setNome(isset($dados['nome'])? $dados['nome'] : '');
        $this->orcamento->setEmail(isset($dados['email'])? $dados['email'] : '');
        $this->orcamento->setMensagem(isset($dados['mensagem'])? $dados['mensagem'] : '');
    }

    private function setErro($erro)
    {
        $this->erros[] = $erro;
    }

    public function getErros()
    {
        return $this->erros;
    }

    public function inserirRegistro()
    {
        $this->verificaRegistros();
        if(count($this->erros) > 0)
        {
            return false;
        }

        $sql = "INSERT INTO orcamentosimples (nome,email,mensagem) VALUES (:nome,:email,:mensagem)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nome",$this->orcamento->getNome(),PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->orcamento->getEmail(),PDO::PARAM_STR);
        $stmt->bindValue(":mensagem",$this->orcamento->getMensagem(),PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function verificaRegistros()
    {
        if($this->orcamento->getNome() === '')
        {
            $this->setErro("Por Favor Informar o Nome");
        }
        if($this->orcamento->getEmail() === '')
        {
            $this->setErro("Por Favor Informar o Email");
        }
        if($this->orcamento->getMensagem() === '')
        {
            $this->setErro("Por Favor Informar a Mensagem");
        }

    }

}

?>
