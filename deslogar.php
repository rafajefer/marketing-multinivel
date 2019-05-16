<?php
session_start();
unset($_SESSION['uLogin']);
header("Location: login.php");
exit;
