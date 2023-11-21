<?php


// Inicia a sessão para gerenciar informações do usuário logado
session_start();

// Verifica se o formulário foi submetido e se os campos 'ra' e 'senha' não estão vazios
if (empty($_POST) || empty($_POST["email"]) || empty($_POST["senha"])) {
    // Se algum dos campos estiver vazio, redireciona de volta para a página de login (index.php)
    header("location: indexlogin.html");
}

// Inclui o arquivo de configuração do banco de dados
include "conecta.php";

// Obtém os valores de 'ra' e 'senha' do formulário
$usuario = $_POST["email"];
$senha = $_POST["senha"];

// Cria uma consulta SQL para buscar um usuário com o 'ra' e 'senha' fornecidos
$sql = "SELECT * FROM usuarios WHERE email = '$usuario' AND senha = '$senha'";

// Executa a consulta no banco de dados
$res = $conn->query($sql) or die($conn->error);

// Obtém a primeira linha de resultados como um objeto
$row = $res->fetch_object();

// Obtém a quantidade de linhas retornadas pela consulta
$qtd = $res->num_rows;

// Verifica se a consulta retornou pelo menos um resultado (usuário válido)
if ($qtd > 0) {
    // Define variáveis de sessão para o usuário logado
    $_SESSION["email"] = $usuario;
    $_SESSION["nome"] = $row->nome;

    // Redireciona para a página do dashboard (dashbord.php) após o login bem-sucedido
    header('Location: ../index_logado.php');
} else {
    // Se não houver resultados na consulta, exibe um alerta e redireciona de volta para a página de login (index.php)
    print "<script>alert('Email ou senha inválidos');</script>";
    print "<script>location.href='indexlogin.html';</script>";
}



