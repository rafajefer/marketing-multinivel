<?php
session_start();
require_once 'config.php';
require_once 'funcoes.php';

// Verifica se sessão está vázia, caso esteja redireciona para login.php
if (empty($_SESSION['uLogin'])) {
   header("Location: login.php");
   exit;
}

// Busca o nome do usuário logado
$id = $_SESSION['uLogin'];

$sql = "SELECT nome FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
   $data = $stmt->fetch();
   $nome = $data['nome'];
} else {
   header("Location: login.php");
   exit;
}

$sql = "SELECT count(*) as count FROM usuarios";
$stmt = $pdo->prepare($sql);
$stmt->execute();
if($stmt->rowCount() > 0) {
   $data = $stmt->fetch();
   $total = $data['count'];
} else {
   $total = 0;
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Sistema de Marketing Multinível</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   </head>
   <body>
      <!-- Start .\ Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         <a class="navbar-brand" href="javascript:void(0)">MMN</a>
         <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
            <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navb">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item active">
                  <a class="nav-link" href="index.php">Dashboard</a>
               </li>
               <!-- Dropdown -->
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                     Usuários
                  </a>
                  <div class="dropdown-menu">
                     <a class="dropdown-item" href="cadastro.php">Novo</a>
                     <a class="dropdown-item" href="usuarios.php">Listar</a>
                  </div>
               </li>
               <li class="nav-item">
                  <a class="nav-link disabled" href="javascript:void(0)">Disabled</a>
               </li>
            </ul>
            <!-- Navbar text-->
            <span class="navbar-text mr-5">
               Olá, <?php echo $nome; ?>
            </span>
            <ul class="navbar-nav my-auto">
               <li class="nav-item active">
                  <a class="nav-link btn btn-sm btn-danger my-2 my-sm-0" href="deslogar.php">Deslogar</a>
               </li>               
            </ul>
         </div>
      </nav>
      <!-- Start .\ Navbar -->
      
      <div class="jumbotron jumbotron-fluid">
         <div class="container pb-5">
            <h1>Sistema de Marketing Multinível</h1>
            <h2><?php echo $total; ?> usuários cadastrados</h2>   
         </div>
      </div>
      <div class="container">
      <?php 
         // Lista usuarios
         $usuarios = listaUsuarios($id, $limite);
         exibir($usuarios);
         
      ?>
         <pre>
            <?php // print_r($usuarios);?>
         </pre>
      </div>
   </body>
</html>

