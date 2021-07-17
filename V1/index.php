<pre><?php
        // print_r($_POST);
        //print_r($_REQUEST);
        //print_r($_COOKIE);
        $endereco = "mysql:dbname=orcamento;host=localhost";
        $user = "root";
        $password = "";
        $quantidade = null;
        $pdo = new PDO($endereco, $user, $password);
        //var_dump($pdo->query("SELECT * FROM orcamentosimples")->fetchAll(PDO::FETCH_ASSOC));
        isset($_POST['nome']) ? $nome = $_POST['nome'] : $nome = '';
        isset($_POST['email']) ? $email = $_POST['email'] : $email = '';
        isset($_POST['mensagem']) ? $mensagem = $_POST['mensagem'] : $mensagem = '';
        if ($nome != '' && $email != '' && $mensagem != '') {
            $stmt = $pdo->prepare("INSERT INTO orcamentosimples (nome,email,mensagem) VALUES (:nome,:email,:mensagem)");
            $stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->bindValue(":mensagem", $mensagem, PDO::PARAM_STR);
            $stmt->execute();
            $quantidade = $stmt->rowCount();
            // if ($stmt->rowCount() > 0)
            //     echo "Registro Inserido com Sucesso!";
            // else
            //     echo "Falha ao Incluir Registro!";
        }
        $registros = $pdo->query("SELECT * FROM orcamentosimples")->fetchAll(PDO::FETCH_ASSOC);
        ?></pre>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <form action="./index.php" method="POST">
            <div class="card">
                <dv class="card-header">
                    Solicite seu Orçamento
                </dv>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="nome">Nome: </label>
                            <input type="text" id="nome" autofocus name="nome" class="form-control form-control-md">
                        </div>
                        <div class="col">
                            <label for="email">E-mail: </label>
                            <input type="email" id="email" name="email" class="form-control form-control-md">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="mensagem">Mensagem: </label>
                            <textarea id="mensagem" name="mensagem" class="form-control form-control-md">
                        </textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">Enviar</button>
                </div>
            </div>
        </form>
        <?php
        if ($quantidade > 0) {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">Registro Inserido com Sucesso!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
        <?php } else if ($quantidade === 0) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">Nao foi possivel inserir or Registro!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
        <?php
        }
        ?>

        <div class="card mt-5">
            <div class="card-header">
                Listagem
            </div>
            <div class="card-body">
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr class="bg-success text-white">
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Mensagem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($registros as $registro)
                            {
                                ?>
                                <tr>
                                    <td><?= $registro['nome'] ?></td>
                                    <td><?= $registro['email'] ?></td>
                                    <td><?= $registro['mensagem'] ?></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>