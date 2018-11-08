<?php
session_start();
// print_r($_SESSION);
include_once 'includes/db_connect.php';
include_once 'includes/psl-config.php';
 ?>


 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="UTF-8">
   <title>Secure Login: Registration Form</title>
   <script type="text/JavaScript" src="js/sha512.js"></script>
   <script type="text/JavaScript" src="js/forms.js?q=1"></script>
   <link rel="stylesheet" href="styles/main.css" />

 </head>
 <body>
   <?php

    // echo $_SESSION["question"];
    // $ans = filter_input(INPUT_POST, 'answer_1', FILTER_SANITIZE_STRING);
    // if($ans!="")
    // check_answer($ans,$_SESSION["username"],$mysqli)
    if(isset($_POST['p']))
    {
      $error_msg="";
      $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
      $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
      $password = hash('sha512', $password . $random_salt);
      $username = $_SESSION["username"];
      // echo $username;

      $prep_stmt = "UPDATE members SET password = ? , salt = ? WHERE username = ? ";
      $stmt = $mysqli->prepare($prep_stmt);

      if ($stmt) {
          $stmt->bind_param('sss', $password,$random_salt,$username);
          $stmt->execute();
          $stmt->store_result();
          echo "Password Updated";
          // if ($stmt->num_rows == 1) {
          //     // A user with this email address already exists
          //     echo "helllo";
          //     $error_msg .= '<p class="error">New password set</p>';
          // }
      } else {
          $error_msg .= '<p class="error">Database error</p>';
      }

      echo $error_msg;
  }



    ?>
   <form action="forgot1.php" method="post" name="con_password">
     Password: <input type="password"
                      name="password"
                      id="password" /><br>
    Confirm password: <input type="password" name="confirmpwd"
                                                       id="confirmpwd" /><br>
   <input type="button"
          value="Submit"
          onclick="return regformhashh(this.form,
                          this.form.password,
                          this.form.confirmpwd);" />
   </form>
 </body>
 </html>
