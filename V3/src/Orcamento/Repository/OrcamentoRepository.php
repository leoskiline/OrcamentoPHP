<?php 

namespace App\Orcamento\Repository;

use PDO;

class OrcamentoRepository{

    private PDO $conn;
    private Int $qtd = 0;
    private Array $dados = [];

    public function __construct(PDO $conexao)
    {
        $this->conn = $conexao;
    }

    public function getQtd()
    {
        return $this->qtd;
    }

    public function getDados()
    {
        return $this->dados;
    }

    public function listaDados()
    {
        $sql = "SELECT * FROM orcamentosimples";
        $stmt = $this->conn->query($sql);
        $this->qtd = $stmt->rowCount();
        if($this->qtd > 0)
        {
            $this->dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $this;
    }


}

?>