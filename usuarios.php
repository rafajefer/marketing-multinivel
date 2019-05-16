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

$sql = "SELECT nome, id_pai FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
   $data = $stmt->fetch();
   $nome = $data['nome'];
   $id_pai = $data['id_pai'];
} else {
   header("Location: login.php");
   exit;
}

// Busca usuários cadastrados pelo usuários logado
$sql = "SELECT * FROM usuarios WHERE id_pai = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id);
$stmt->execute();
if ($stmt->rowCount() > 0) {
   $usuarios = $stmt->fetchAll();
} else {
   $usuarios = array();
}

// Busca o líder do usuário logado
$sql = "SELECT nome FROM usuarios WHERE id_pai = :id_pai";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id_pai", $id_pai);
$stmt->execute();
if($stmt->rowCount() > 0) {
   $data = $stmt->fetch();
   $lider = $data['nome'];
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
      
      <!-- font-awesome -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
   
      <!-- custom script -->
      <script src="script.js"></script>
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
               Olá, <?php echo $nome; ?>
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
         <div class="clearfix">
            <span class="float-left"><h2>Sua equipe</h2></span>
            <span class="float-right text-muted"><p><?php echo (!empty($lider)) ? "Seu líder: ".$lider : ''; ?></p></span>
         </div>
         
         <p>Usuários cadastrados por você ou pela sua equipe.</p>            
         <table class="table table-striped">
            <thead  class="thead-dark">
               <tr>
                  <th style="width: 50px;" class="text-center">ID</th>
                  <th style="width: 70px;" class="text-center">ID Pai</th>
                  <th>Nome</th>
                  <th>Email</th>
                  <th>Patente</th>
                  <th></th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($usuarios as $user): ?>
                  <tr>
                     <td class="text-center"><?php echo $user['id']; ?></td>
                     <td class="text-center"><?php echo $user['id_pai']; ?></td>
                     <td><?php echo $user['nome']; ?><sup><span class="badge badge-success">Nível 1</span></sup></td>
                     <td><?php echo $user['email']; ?></td>
                     <td><?php echo $user['patente']; ?></td>
                     
                     <?php 
                        // Pegar total de filhos
                        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE id_pai = :id_filho";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindValue(":id_filho", $user['id']);
                        $stmt->execute();
                        if($stmt->rowCount() > 0) {
                           $result = $stmt->fetch();
                           $qtde = $result['count'];
                           echo '<td><span class="badge badge-success">'.$qtde.'</span></td>';
                        } else {
                           echo '<td>0</td>';
                        }
                     ?>
                  </tr>
                  <?php 
                     // Verifica se user possuí filhos
                     $sql = "SELECT * FROM usuarios WHERE id_pai = :id_filho";
                     $stmt = $pdo->prepare($sql);
                     $stmt->bindValue(":id_filho", $user['id']);
                     $stmt->execute();
                     if($stmt->rowCount() > 0):
                        $data = $stmt->fetchAll();                     
                        foreach($data as $row):
                  ?>
                     <tr class="">
                        <td class="text-center"><?php echo $row['id']; ?></td>
                        <td class="text-center"><?php echo $row['id_pai']; ?></td>
                        <td><?php echo $row['nome']; ?><sup><span class="badge badge-primary">Nível 2</span></sup></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['patente']; ?></td>
                        <?php 
                        // Pegar total de filhos
                        $sql = "SELECT COUNT(*) as count FROM usuarios WHERE id_pai = :id_filho";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindValue(":id_filho", $row['id']);
                        $stmt->execute();
                        if($stmt->rowCount() > 0) {
                           $result = $stmt->fetch();
                           $qtde = $result['count'];
                           echo '<td><span class="badge badge-success">'.$qtde.'</span></td>';
                        } else {
                           echo '<td>0</td>';
                        }
                     ?>
                     </tr>
                     
                      <?php 
                     // Verifica se user possuí filhos
                     $sql = "SELECT * FROM usuarios WHERE id_pai = :id_filho";
                     $stmt = $pdo->prepare($sql);
                     $stmt->bindValue(":id_filho", $row['id']);
                     $stmt->execute();
                     if($stmt->rowCount() > 0):
                        $data = $stmt->fetchAll();                     
                        foreach($data as $row):
                  ?>
                     <tr class="">
                        <td class="text-center"><?php echo $row['id']; ?></td>
                        <td class="text-center"><?php echo $row['id_pai']; ?></td>
                        <td><?php echo $row['nome']; ?><sup><span class="badge badge-info">Nível 3</span></sup></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['patente']; ?></td>
                        <?php 
                           // Pegar total de filhos
                           $sql = "SELECT COUNT(*) as count FROM usuarios WHERE id_pai = :id_filho";
                           $stmt = $pdo->prepare($sql);
                           $stmt->bindValue(":id_filho", $row['id']);
                           $stmt->execute();
                           if($stmt->rowCount() > 0) {
                              $result = $stmt->fetch();
                              $qtde = $result['count'];
                              echo '<td><span class="badge badge-success">'.$qtde.'</span></td>';
                           } else {
                              echo '<td>0</td>';
                           }
                        ?>
                     </tr>
                           <?php 
                     // Verifica se user possuí filhos
                     $sql = "SELECT * FROM usuarios WHERE id_pai = :id_filho";
                     $stmt = $pdo->prepare($sql);
                     $stmt->bindValue(":id_filho", $row['id']);
                     $stmt->execute();
                     if($stmt->rowCount() > 0):
                        $data = $stmt->fetchAll();                     
                        foreach($data as $row):
                  ?>
                     <tr class="">
                        <td class="text-center"><?php echo $row['id']; ?></td>
                        <td class="text-center"><?php echo $row['id_pai']; ?></td>
                        <td><?php echo $row['nome']; ?><sup><span class="badge badge-danger">Nível 4</span></sup></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['patente']; ?></td>
                        <?php 
                           // Pegar total de filhos
                           $sql = "SELECT COUNT(*) as count FROM usuarios WHERE id_pai = :id_filho";
                           $stmt = $pdo->prepare($sql);
                           $stmt->bindValue(":id_filho", $row['id']);
                           $stmt->execute();
                           if($stmt->rowCount() > 0) {
                              $result = $stmt->fetch();
                              $qtde = $result['count'];
                              echo '<td><span class="badge badge-success">'.$qtde.'</span></td>';
                           } else {
                              echo '<td>0</td>';
                           }
                        ?>
                     </tr>
                           <?php 
                     // Verifica se user possuí filhos
                     $sql = "SELECT * FROM usuarios WHERE id_pai = :id_filho";
                     $stmt = $pdo->prepare($sql);
                     $stmt->bindValue(":id_filho", $row['id']);
                     $stmt->execute();
                     if($stmt->rowCount() > 0):
                        $data = $stmt->fetchAll();                     
                        foreach($data as $row):
                  ?>
                     <tr class="">
                        <td class="text-center"><?php echo $row['id']; ?></td>
                        <td class="text-center"><?php echo $row['id_pai']; ?></td>
                        <td><?php echo $row['nome']; ?><sup><span class="badge badge-dark">Nível 5</span></sup></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['patente']; ?></td>
                        <?php 
                           // Pegar total de filhos
                           $sql = "SELECT COUNT(*) as count FROM usuarios WHERE id_pai = :id_filho";
                           $stmt = $pdo->prepare($sql);
                           $stmt->bindValue(":id_filho", $row['id']);
                           $stmt->execute();
                           if($stmt->rowCount() > 0) {
                              $result = $stmt->fetch();
                              $qtde = $result['count'];
                              echo '<td><span class="badge badge-success">'.$qtde.'</span></td>';
                           } else {
                              echo '<td>0</td>';
                           }
                        ?>
                     </tr>
                     
                        <?php
                        endforeach;
                     endif;
                  ?>
                        <?php
                        endforeach;
                     endif;
                  ?>
                        <?php
                        endforeach;
                     endif;
                  ?>
                  <?php
                        endforeach;
                     endif;
                  ?>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>

   </body>
</html>

