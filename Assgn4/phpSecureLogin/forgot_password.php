<?php
session_start();
// $_SESSION["u"] = "cat";
// sheader('Location: forgot.php');
?>
<!DOCTYPE html>
<?php
include_once 'includes/db_connect.php';
include_once 'includes/psl-config.php';
function does_exist($username,$mysqli)
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
            $_SESSION["question"] = $question;
            // echo $question;
            return true;
        }
    } else {
        return false;
    }

}

// function check_answer($ans,$username,$mysqli)
// {
//   $prep_stmt = "SELECT question, answer FROM security_qa WHERE username = ? LIMIT 1";
//   $stmt = $mysqli->prepare($prep_stmt);
//
//   if ($stmt) {
//       $stmt->bind_param('s', $username);
//       $stmt->execute();
//       $stmt->store_result();
//
//       $stmt->bind_result($question, $answer);
//       $stmt->fetch();
//
//       if ($stmt->num_rows == 1) {
//           // A user with this email address already exists
//           // echo "hellllllo";
//           if($answer != $ans)
//           echo "Incorrect answer";
//           return true;
//       }
//   } else {
//       return false;
//   }
//
// }


 ?>
<html>

  <head>

  </head>
  <body>
    <?php

    $error_msg = "";
    // $flag = 0;
    // $ans = filter_input(INPUT_POST, 'answer', FILTER_SANITIZE_STRING);
   //  if($ans!="")
   //  {
   //  // echo $ans;
   //  $flag = 1;
   // }
   $username = filter_input(INPUT_POST, 'username_1', FILTER_SANITIZE_STRING);
   // if($flag == 1)
   // {
   //   echo $username;
   //
   //   check_answer($ans,$username,$mysqli);
   // }
   // if($flag == 0)
   // {
    // $username = filter_input(INPUT_POST, 'username_1', FILTER_SANITIZE_STRING);
    // echo $username;
    $prep_stmt = "SELECT id FROM members WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            // $new_user_name = find_new_name($username,$mysqli);
            // echo "hello";
            // $error_msg .= '<p class="error">A user with this username already exists.   </p>';
          $_SESSION["username"] = $username;
           does_exist($username,$mysqli);
           header('Location: forgot.php');


        }
        else {
          $error_msg .= '<p class="error">Such username does not exist </p>';
        }
    } else {
        $error_msg .= '<p class="error">Database error</p>';
    }
    echo $error_msg;



    ?>


  </body>

</html>
