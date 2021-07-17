<?php 
    class OrcamentoSimples{
        private PDO $conn;


        public function __construct(Conexao $conn)
        {
            $this->conn = $conn->exec();
        }

        public function inserirRegistro(array $dados)
        {
            if(isset($dados['nome']) && isset($dados['email']) && isset($dados['mensagem']))
            {
                $nome = $dados['nome'];
                $email = $dados['email'];
                $mensagem = $dados['mensagem'];
            }
            else
                return false;
            $sql = "INSERT INTO orcamentosimples (nome,email,mensagem) VALUES (:nome,:email,:mensagem)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":nome",$nome,PDO::PARAM_STR);
            $stmt->bindValue(":email",$email,PDO::PARAM_STR);
            $stmt->bindValue(":mensagem",$mensagem,PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0 || 0;
        }

        public function listarRegistros()
        {
            $retorno = $this->conn->query("SELECT * FROM orcamentosimples");
            return [
                "quantidade" => $retorno->rowCount(),
                "registros" => $retorno->fetchAll(PDO::FETCH_ASSOC)
            ];
        }
    }
?>