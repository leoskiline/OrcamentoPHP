<?php

namespace Config;

use PDO;

Class Conexao {

    private $endereco = "mysql:dbname=orcamento;host=localhost";
    private $user = "root";
    private $password = "";
    public static $conexaoSingleton = null;

    public function __construct()
    {
        if(!self::$conexaoSingleton)
            self::$conexaoSingleton = new PDO($this->endereco, $this->user, $this->password);
    }

    public function exec()
    {
        return self::$conexaoSingleton;
    }

}

?>