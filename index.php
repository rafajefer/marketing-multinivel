<?php

session_start();
require_once 'config.php';

if(!empty($_SESSION['uLogin'])) {
   header("Location: login.php");
   exit;
}