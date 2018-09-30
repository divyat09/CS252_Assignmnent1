<html>


<?php

$emp_id = $_POST["emp_id"];
$dep_id = $_POST["dep_id"];
$last_name = $_POST["last_name"];
$flag1=0;
$flag2=0;
$flag3=0;
$flag=0;
?>

<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>




<body>


<table>
  <tr>
    <th>Employee No</th>
    <th>Birth Date</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Gender</th>
    <th>Hire Date</th>
  </tr>



<?php
if(!empty($emp_id))
{
	$flag1=1;
}

if(!empty($dep_id))
{
	$flag2=1;
}

if(!empty($last_name))
{
	$flag3=1;
}


$servername = "localhost";
$username = "root";
$password = "";
$db = "employees";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}


if($flag1==1 && $flag2==0 && $flag3==0)
{

$sql = "SELECT * FROM employees  WHERE emp_no=$emp_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
       
        ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php

    }
}
}

if($flag1==0 && $flag2==1 && $flag3==0)
{
$sql = "SELECT * FROM employees INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no WHERE dept_no=\"$dep_id\" LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
        ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php
    }
}
}


if($flag1==0 && $flag2==0 && $flag3==1)
{
$sql = "SELECT * FROM employees WHERE last_name=\"$last_name\" LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
       ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php
    }
}
}

if($flag1==1 && $flag2==1 && $flag3==0)
{

$sql = "SELECT * FROM employees INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no WHERE dept_no=\"$dep_id\" AND employees.emp_no=$emp_id LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
        ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php
    }
}
}

if($flag1==0 && $flag2==1 && $flag3==1)
{

$sql = "SELECT * FROM employees INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no WHERE dept_no=\"$dep_id\" AND last_name=\"$last_name\" LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
        ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php
    }
}
}

if($flag1==1 && $flag2==0 && $flag3==1)
{

$sql = "SELECT * FROM employees WHERE emp_no=$emp_id and last_name=\"$last_name\" LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
        ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php
    }
}
}


if($flag1==1 && $flag2==1 && $flag3==1)
{

$sql = "SELECT * FROM employees INNER JOIN dept_emp ON employees.emp_no = dept_emp.emp_no WHERE dept_no=\"$dep_id\" AND last_name=\"$last_name\" AND employees.emp_no=$emp_id LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $flag=1;
    while($row = $result->fetch_assoc()) {
        ?>
    <tr>
      <td> <?php echo $row["emp_no"] ; ?>  </td>
      <td> <?php echo  $row["birth_date"] ; ?> </td>
      <td> <?php echo $row["first_name"] ; ?>  </td>
      <td> <?php echo  $row["last_name"] ; ?> </td>
      <td> <?php echo $row["gender"] ; ?>  </td>
      <td> <?php echo  $row["hire_date"] ; ?> </td>
    </tr> 
    <?php
    }
}
}




if($flag==0)
{
	?>
    <tr>
      <td> <?php echo "invalid" ; ?>  </td>
      <td> <?php echo "invalid" ; ?> </td>
      <td> <?php echo "invalid" ; ?>  </td>
      <td> <?php echo "invalid" ; ?> </td>
      <td> <?php echo "invalid" ; ?>  </td>
      <td> <?php echo "invalid" ; ?> </td>
    </tr> 
    <?php
}






$conn->close();




?>

</table>


</body>
</html>