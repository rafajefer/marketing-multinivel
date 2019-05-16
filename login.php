<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <title></title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   </head>
   <body>

      <div class="container mt-5">
         <h2>Login</h2>
         <form method="POST">
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="form-group">
               <label for="senha">Password:</label>
               <input type="password" class="form-control" id="senha" placeholder="Enter password" name="senha">
            </div>
            <div class="form-group form-check">
               <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="remember"> Remember me
               </label>
            </div>
            <button type="submit" class="btn btn-primary">Acessar</button>
         </form>
      </div>

   </body>
</html>
