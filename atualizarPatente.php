<?php

session_start();
require_once 'config.php';
require_once 'funcoes.php';

// Busca id de todos os usuários
$sql = "SELECT id FROM usuarios";
$stmt = $pdo->query($sql);
$usuarios = array();

if($stmt->rowCount() > 0) {
   $usuarios = $stmt->fetchAll();
   
   foreach($usuarios as $chave => $usuario) {
      $usuarios[$chave]['filhos'] = calcular_cadastros($usuario['id'], $limite);
   }
}

$sql = "SELECT * FROM patentes ORDER BY min DESC";
$stmt = $pdo->query($sql);
$patentes = array();
if($stmt->rowCount() > 0) {
   $patentes = $stmt->fetchAll();
}

foreach ($usuarios as $usuario) {
   
   foreach ($patentes as $patente) {
      if(intval($usuario['filhos']) >= intval($patente['min'])) {
         
         $sql = "UPDATE usuarios SET patente = :patente WHERE id = :id";
         $stmt = $pdo->prepare($sql);
         $stmt->bindValue(":patente", $patente['id']);
         $stmt->bindValue(":id", $usuario['id']);
         $stmt->execute();
         
         break;
      }
      
   }
}