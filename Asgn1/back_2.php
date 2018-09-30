<html>

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
    <th>Employee Count</th>
    <th>Department</th>
  </tr>


<?php
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



$sql = "SELECT COUNT(emp_no) as cont, dept_no FROM dept_emp GROUP BY dept_no ORDER BY COUNT(emp_no) DESC";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    ?>
    <tr>
      <td> <?php echo $row["cont"] ; ?>  </td>
      <td> <?php echo  $row["dept_no"] ; ?> </td>
    </tr> 
    <?php   
    }

}



$conn->close();




?>



</table>



</body>
</html>