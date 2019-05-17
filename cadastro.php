<?php
session_start();
require_once 'config.php';

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
// Válida os dados enviados pelo formulário
if (!empty($_POST['nome']) && !empty($_POST['email'])) {
   $nome = addslashes($_POST['nome']);
   $email = addslashes($_POST['email']);
   $id_pai = $_SESSION['uLogin'];

   // Verifica se e-mail já existe na base de dados
   $sql = "SELECT * FROM usuarios WHERE email = :email";
   $stmt = $pdo->prepare($sql);
   $stmt->bindValue(":email", $email);
   $stmt->execute();

   if ($stmt->rowCount() == 0) {
      $sql = "INSERT INTO usuarios (id_pai, nome, email, senha) VALUES (?,?,?,?)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(1, $id_pai);
      $stmt->bindParam(2, $nome);
      $stmt->bindParam(3, $email);
      $stmt->bindParam(4, md5(123));
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
         header("Location: index.php");
         exit;
      } else {
         echo "Não foi possível cadastrar o usuário $nome";
      }
   } else {
      echo "Já existe usuário cadastrado com esse e-mail!";
   }
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
               <li class="nav-item">
                  <a class="nav-link" href="index.php">Dashboard</a>
               </li>
               <!-- Dropdown -->
               <li class="nav-item dropdown active">
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
               Olá, <?php echo $_SESSION['usuario']['nome']; ?> <sup><span class="badge badge-success"><?php echo $_SESSION['usuario']['patente']; ?></span></sup>
            </span>
            <ul class="navbar-nav my-auto">
               <li class="nav-item active">
                  <a class="nav-link btn btn-sm btn-danger my-2 my-sm-0" href="deslogar.php">Deslogar</a>
               </li>               
            </ul>
         </div>
      </nav>      
      <!-- End .\ Navbar -->
      
      <div class="container mt-5">
         <h2>Cadastro de Usuários</h2>
         <form method="POST">            
            <div class="form-group">
               <label for="nome">Nome:</label>
               <input type="text" class="form-control" id="nome" placeholder="Enter name" name="nome">
            </div>
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
         </form>
      </div>

   </body>
</html>

