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
        $this->orcamento->setIdOrcamento(isset($dados['idOrcamento'])? $dados['idOrcamento']: 0);
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

    public function atualizarDados()
    {
        $this->verificaRegistros();
        if(count($this->erros) > 0 || $this->orcamento->getIdOrcamento() <= 0) 
        {
            return false;
        }
        $sql = "UPDATE orcamentosimples SET nome = :nome, email = :email, mensagem = :mensagem WHERE idOrcamento = :idOrcamento";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nome",$this->orcamento->getNome(),PDO::PARAM_STR);
        $stmt->bindValue(":email",$this->orcamento->getEmail(),PDO::PARAM_STR);
        $stmt->bindValue(":mensagem",$this->orcamento->getMensagem(),PDO::PARAM_STR);
        $stmt->bindValue(":idOrcamento",$this->orcamento->getIdOrcamento(),PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function deletarDados()
    {
        if($this->orcamento->getIdOrcamento() <= 0) 
        {
            return false;
        }
        $sql = "DELETE FROM orcamentosimples WHERE idOrcamento = :idOrcamento";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idOrcamento",$this->orcamento->getIdOrcamento(),PDO::PARAM_INT);
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
