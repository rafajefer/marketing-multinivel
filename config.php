<?php

try {
   $dsn = "mysql:dbname=projeto_mmn;host=localhost";
   $user = "root";
   $pass = "";   
   $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $ex) {
   echo "Connection falied: ".$ex->getMessage();
   exit;
}