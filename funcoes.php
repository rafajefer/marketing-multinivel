<?php
function calcular_cadastros($id, $limite) {
   $lista = array();
   global $pdo;
   
   // Busca qtde de filhos do $id passado
   $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id_pai = :id");
   $sql->bindValue(":id", $id);
   $sql->execute();
   $filhos = 0;
   if($sql->rowCount() > 0) {
      // Guarda todos os registro no array $lista
      $lista = $sql->fetchAll(PDO::FETCH_ASSOC);
      
      // Guarda total de registro retornado na consulta
      $filhos = $sql->rowCount();
      
      // Verifica filhos dos filhos e acrescenta em filhos
      foreach($lista as $chave => $usuario) {
         if($limite > 0) {
            $filhos += calcular_cadastros($usuario['id'], $limite-1);
         }
      }
      
   }
   return $filhos;
}
function listaUsuarios($id, $limite) {
   global $pdo;
   $lista = array();
   // Busca usuários cadastrados pelo usuários logado
   $sql = "SELECT "
           . "usuarios.id, usuarios.id_pai, usuarios.nome, usuarios.email, usuarios.patente, patentes.nome as patente "
           . "FROM usuarios "
           . "LEFT JOIN patentes ON patentes.id = usuarios.patente "
           . "WHERE usuarios.id_pai = :id";
   $stmt = $pdo->prepare($sql);
   $stmt->bindValue(":id", $id);
   $stmt->execute();
   if ($stmt->rowCount() > 0) {
      $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

      foreach ($lista as $chave => $usuario) {
         $lista[$chave]['filhos'] = array();
         if ($limite > 0) {
            $lista[$chave]['filhos'] = listaUsuarios($usuario['id'], $limite - 1);
         }
      }
   }
   return $lista;
}

function exibir($array) {

   echo '<ul>';
   foreach ($array as $usuario) {
      echo "<li>";
      echo '<sup><span class="badge badge-success">'.$usuario['patente'].'</span></sup>'.$usuario['nome'].' - '.count($usuario['filhos']).' cadastros diretos';
      
      if(count($usuario['filhos']) > 0) {
         exibir($usuario['filhos']);
      }
      echo "</li>";
   }
   echo '</ul>';
}
