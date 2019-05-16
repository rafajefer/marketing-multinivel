<?php

try {
   $dsn = "mysql:dbname=projeto_mmn;host=localhost";
   $user = "root";
   $pass = "";   
   $pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $ex) {
   echo "Connection falied: ".$ex->getMessage();
   exit;
}