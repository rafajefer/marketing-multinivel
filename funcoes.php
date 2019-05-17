<?php

function listaUsuarios($id, $limite) {
   global $pdo;
   $lista = array();
   // Busca usuários cadastrados pelo usuários logado
   $sql = "SELECT * FROM usuarios WHERE id_pai = :id";
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
      echo $usuario['nome'].' - '.count($usuario['filhos']).' cadastros diretos';
      
      if(count($usuario['filhos']) > 0) {
         exibir($usuario['filhos']);
      }
      echo "</li>";
   }
   echo '</ul>';
}
