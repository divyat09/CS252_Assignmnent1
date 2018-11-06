<?php
/**
 * Copyright (C) 2013 peredur.net
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script>
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>

    <script>


        function leven(a, b) {
                if(a.length === 0) return b.length;
                if(b.length === 0) return a.length;

                var matrix = [];

                // increment along the first column of each row
                var i;
                for(i = 0; i <= b.length; i++){
                matrix[i] = [i];
                }

                // increment each column in the first row
                var j;
                for(j = 0; j <= a.length; j++){
                matrix[0][j] = j;
                }

                // Fill in the rest of the matrix
                for(i = 1; i <= b.length; i++){
                for(j = 1; j <= a.length; j++){
                if(b.charAt(i-1) == a.charAt(j-1)){
                matrix[i][j] = matrix[i-1][j-1];
                } else {
                matrix[i][j] = Math.min(matrix[i-1][j-1] + 1, // substitution
                                        Math.min(matrix[i][j-1] + 1, // insertion
                                                 matrix[i-1][j] + 1)); // deletion
                }
                }
                }

                return matrix[b.length][a.length];
                // return "a";
          }
        function check_password_strength() {

          var x = document.getElementById("password");
          // document.getElementById("demo").innerHTML = x.value;
          var common_passwords =["123456","123456789","qwerty","12345678","111111","1234567890","1234567","password","123123","987654321","qwertyuiop","mynoob","123321","666666","18atcskd2w","7777777","1q2w3e4r","654321","555555","3rjs1la7qe","google","1q2w3e4r5t","123qwe","zxcvbnm","1q2w3e"];
          var ans =100000;
          for(i = 0;i<25;i++)
          {
            ans = Math.min(leven(common_passwords[i],x.value),ans);
            // ans = leven(common_passwords[i],x.value);
          }
          if(ans<=3)
          {
             document.getElementById("demo").innerHTML = "weak";
          }
          if(ans> 3 && ans <=7)
          {
            document.getElementById("demo").innerHTML = "ok";
          }
          if(ans > 7)
          {
            document.getElementById("demo").innerHTML = "strong";
          }

        }
    </script>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>">
            Username: <input type='text' name='username' id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            Password: <input type="password"
                             name="password"
                             id="password" onkeydown="check_password_strength()"/><br>
            <p id="demo"></p>
            Confirm password: <input type="password"
                                     name="confirmpwd"
                                     id="confirmpwd" /><br>
            Security Question: <select name="question">
                      <option value="color">What is your favourite color ?</option>
                      <option value="dog">What is the name of your pet dog ?</option>
                      <option value="car">What is your car company ? </option>
                      <!-- <option value="">Audi</option> -->
            </select>
            <br><br>
            Security Answer: <input type="text" name="answer" id="answer"/><br>
            <input type="button"
                   value="Register"
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" />
        </form>
        <p>Return to the <a href="index.php">login page</a>.</p>
    </body>
</html>
