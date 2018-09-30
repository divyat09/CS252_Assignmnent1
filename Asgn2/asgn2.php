</body>
</html>

<!DOCTYPE html>
<html>
<body>
<h1>Employees database</h1>
<?php
	$servername = "localhost";
	$username = "test_user";
	$password = "pass";
	$db = "employees";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $db);
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$sql = 'SELECT * FROM departments';
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "The various departments are <ul>";
		while($row = $result->fetch_assoc()) {
			echo "<li>", $row["dept_name"],"</li>";
		}
		echo "</ul>";
	} else {
		echo "Connection to database failed";
	}
	$sql = 'SELECT DISTINCT title FROM titles';
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo "The various titles are <ul>";
		while($row = $result->fetch_assoc()) {
			echo "<li>", $row["title"],"</li>";
		}
		echo "</ul>";
	} else {
		echo "Connection to database failed";
	}
?>
<form action="back_1.php" method="post">
<h3> Search for employee </h3>
By Id: <input type="text" name="emp_id"> By Last Name: <input type="text" name="last_name"> By Department: <input type="text" name="dep_id">
<input type="submit" name="submit4">
</form>
<form action="back_2.php" method="post">
<h3> To get count of  employees in a department </h3>

<input type="submit" name="submit">
</form>
<form action="asgn2.php" method="post">
<h3> To get gender ratio of a department </h3>
Enter Department Name <input type="text" name="deptname">
<input type="submit" name="submit1">
</form>
<form action="asgn2.php" method="post">
<h3> To get gender pay ratio of a department </h3>
Enter Department Name <input type="text" name="deptname">
<input type="submit" name="submit2">
</form>
<?php
	if(isset($_POST["submit"])){
		$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["deptname"] . '"';
		$result = $conn->query($sql);
		$x = $result->fetch_assoc()["dept_no"];
		if ($result->num_rows > 0) {
			$sql = 'SELECT * FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") ORDER BY hire_date';
			$result = $conn->query($sql);
			echo "<table><tr><th>Employee ID</th><th>Name</th><th>Start Date</th></tr>";
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<tr><td>",$row["emp_no"],"</td><td>",$row[first_name]," ",$row[last_name],"</td><td>",$row["hire_date"],"</td></tr>";
				}
				echo "</table>";
			} else {
				echo "No employees in the department";
			}
		}else{
			echo "No such department";
		}
	}
	if(isset($_POST["submit1"])){
		$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["deptname"] . '"';
		$result = $conn->query($sql);
		$x = $result->fetch_assoc()["dept_no"];
		if ($result->num_rows > 0) {
			$sql = 'SELECT count(*) AS males FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") AND gender="M"';
			$sql1 = 'SELECT count(*) AS females FROM employees WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'") AND gender="F"';
			$result = $conn->query($sql);
			$result1 = $conn->query($sql1);
			echo "<h4>",$_POST["deptname"],"</h4>";
			echo "<table><tr><th>Number of Males</th><th>Number of Females</th></tr>";
			echo "<tr><td>", $result->fetch_assoc()["males"],"</td><td>",$result1->fetch_assoc()["females"],"</td></tr>";
		}else{
			echo "No such department";
		}
	}
	if(isset($_POST["submit2"])){
		$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["deptname"] . '"';
		$result = $conn->query($sql);
		$x = $result->fetch_assoc()["dept_no"];
		if ($result->num_rows > 0) {
			$sql = 'SELECT DISTINCT title FROM titles WHERE emp_no IN (SELECT emp_no FROM dept_emp WHERE dept_no="'. $x .'")';
			$result = $conn->query($sql);
			echo "<h3>Gende Pay Ratio</h3><table border='1'><th>Title</th><th>Male salry</th><th>Female Salary</th>";
			while ($row = $result->fetch_assoc()){
				// echo "Hi";
				$t = $row["title"];
				// echo $t;
				$sql1 = 'SELECT emp_no from employees WHERE emp_no in (SELECT emp_no FROM titles WHERE title="' . $t . '")';
				$sqlm = 'SELECT SUM(salary) AS male_salary FROM salaries where emp_no in (' .$sql1 . 'AND gender="M")';
				$result_m = $conn->query($sqlm);
				$sqlf = 'SELECT SUM(salary) AS female_salary FROM salaries where emp_no in (' .$sql1 . 'AND gender="F")';
				$result_f = $conn->query($sqlf);
				echo "<tr><td>",$t,"</td><td>",$result_m->fetch_assoc()["male_salary"],"</td><td>",$result_f->fetch_assoc()["female_salary"],"</td></tr>";
			}
			echo "</table>";
		}else{
			echo "No such department";
		}
	}
	if(isset($_POST["submit4"])){
		echo "<table border = 1><tr><th>Employee ID</th><th>Name</th><th>Hire Date</th><th>Department</th></tr>";
		if ($_POST["id"] != ""){
			$sql = 'SELECT * FROM employees WHERE emp_no ="' . $_POST["id"] . '"';
			$result = $conn->query($sql);
			if ($result->num_rows>0){
				$row = $result->fetch_assoc();
				$sql1 = 'SELECT dept_no FROM dept_emp where emp_no="'. $_POST["id"] . '"';
				$result1 = $conn->query($sql1);
				$dno = $result1->fetch_assoc()["dept_no"];
				echo $dno;
				$sql2 = 'SELECT dept_name FROM departments where dept_no="'. $dno . '"';
				$result1 = $conn->query($sql2);
				$dname = $result1->fetch_assoc()["dept_name"];
				echo $dname;
				echo "<tr><td>",$row["emp_no"],"</td><td>",$row[first_name]," ",$row[last_name],"</td><td>",$row["hire_date"],"</td><td>",$dname,"</td></tr>";
			}

		}
		if ($_POST["dept"] != ""){
			$sql = 'SELECT dept_no FROM departments WHERE dept_name="' . $_POST["dept"] . '"';
			$result = $conn->query($sql);
			$sql1 = 'SELECT emp_no FROM dept_emp where dept_no ="'.$result->fetch_assoc()["dept_no"].'"';
			$sql = 'SELECT * from employees where emp_no in ('. $sql1 . ')';
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()){
				echo "<tr><td>",$row["emp_no"],"</td><td>",$row[first_name]," ",$row[last_name],"</td><td>",$row["hire_date"],"</td><td>",$_POST["dept"],"</td></tr>";
			}
		}
		if ($_POST["lname"] != ""){
			$sql = 'SELECT * from employees where last_name ="' .$_POST["lname"]. '"';
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()){
				$sql1 = 'SELECT dept_no FROM dept_emp where emp_no="'. $row["emp_no"] . '"';
				$result1 = $conn->query($sql1);
				$dno = $result1->fetch_assoc()["dept_no"];
				$sql2 = 'SELECT dept_name FROM departments where dept_no="'. $dno . '"';
				$result1 = $conn->query($sql2);
				$dname = $result1->fetch_assoc()["dept_name"];
				echo "<tr><td>",$row["emp_no"],"</td><td>",$row[first_name]," ",$row[last_name],"</td><td>",$row["hire_date"],"</td><td>",$dname, "</td></tr>";
			}
		}
		echo "</table";
	}
	$conn->close();
?>


</body>
</html>
