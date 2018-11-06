<?php
session_start();
// print_r($_SESSION);
include_once 'includes/db_connect.php';
include_once 'includes/psl-config.php';
 ?>

<?php

function check_answer($ans,$username,$mysqli)
{
  $prep_stmt = "SELECT question, answer FROM security_qa WHERE username = ? LIMIT 1";
  $stmt = $mysqli->prepare($prep_stmt);

  if ($stmt) {
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $stmt->store_result();

      $stmt->bind_result($question, $answer);
      $stmt->fetch();

      if ($stmt->num_rows == 1) {
          // A user with this email address already exists
          // echo "hellllllo";
          if($answer != $ans)
          echo '<p class="error">Incorrect answer</p>';
          else {
             header('Location: forgot1.php');
          }
          return true;
      }
  } else {
      return false;
  }

}




 ?>

 <!DOCTYPE html>
 <html>
 <head>

 </head>
 <body>
   <?php

    echo $_SESSION["question"];
    $ans = filter_input(INPUT_POST, 'answer_1', FILTER_SANITIZE_STRING);
    if($ans!="")
    check_answer($ans,$_SESSION["username"],$mysqli)
    ?>
   <form action="forgot.php" method="post" name="answer">
     Answer: <input type="text" name="answer_1" />
     <input type="submit" value="submit" />
   </form>
 </body>
 </html>
