<?php

namespace App\Orcamento\Models;


class OrcamentoModel{
    private int $idOrcamento;
    private string $nome;
    private string $email;
    private string $mensagem;

    public function setIdOrcamento(int $id)
    {
        $this->idOrcamento = $id;
    }

    public function setNome(string $nome)
    {
        $this->nome = trim($nome);
    }
    public function setEmail(string $email)
    {
        $this->email = trim($email);
    }
    public function setMensagem(string $mensagem)
    {
        $this->mensagem = trim($mensagem);
    }

    public function getIdOrcamento()
    {
        return $this->idOrcamento;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getMensagem()
    {
        return $this->mensagem;
    }
    
}

?>