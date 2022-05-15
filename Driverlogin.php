
<HTML XMLns="http://www.w3.org/1999/xHTML">
 
  <head> 
    <title>Driver Login Page</title> 
	<link rel="stylesheet" type="text/css" href="style3.css">
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head> 
  <body>
  <nav>
    <div class="menu">
      <div class="logo">
        <a href="home.php">Cabs Service</a>
      </div>
      <ul>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="#">Services</a></li>
        
       
      </ul>
    </div>
  </nav>
	<br><br><br><br>
	<H2>Drivers Login</H2>
  <form class="form4">
		<table> <tr> <td>		
		Email:</td><td><input type="text" name="emailfield" required></td></tr>
		<tr><td>
		Password:</td><td><input type="password" name="passwordfield" required> </label></td></tr>
		<tr><td>
		&nbsp&nbsp&nbsp<button type="submit">Login</button></br></td><td></td></tr></table>
		
  </form>
  
  <h3>New member? <a href="DriverRegister.php">Register now</a></h3>


  </body> 

<?php 
	//Check if email and pwd fields are sent
	if(isset($_GET['emailfield']) && isset($_GET['passwordfield']))
	{
		//check if email and passwords are provided as spaces, if yes trim them and store them in variables
		$email = trim($_GET['emailfield']);
		$password = trim($_GET['passwordfield']);
		//after triming check if they are empty
		if(empty($email) || empty($password))
		{
			//echo "Please enter email address and password";
			exit();
		}
		else
		{
			//Call function to get the customerid, if customer is present in the database
			$Driver_No = ValidateUser($email,$password);
			//Check if database returned empty, that means customer is not registered
			if(!(empty($Driver_No)))
			{
				//if customer id is 1 then, he is treated as admin else normal customer
				
				/*	$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					$query_string = 'admin.php?Driver_Id=' . $Driver_No;
					header("Location: http://$host$uri/$query_string");*/
							
				if($Driver == 1)
				{
					
					//Redirect admin to admin page
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					$query_string = "admin.php";
					header("Location: http://$host$uri/$query_string");
				}
				else
				{
					//Redirect customers to Booking page
					//Redirect drivers to admin page
					$host  = $_SERVER['HTTP_HOST'];
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					$query_string = 'admin.php?Driver_Id=' . $Driver_No;
					header("Location: http://$host$uri/$query_string");
				}
			}
		}
	}

	//function takes email address and password as input then retrieves the customer no from database and returns customer no
	function ValidateUser($email,$password)
	{
		$DBConnect = @mysqli_connect('localhost', 'root', '', 'phani')
		
		
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		"mysqli_connect_errno()</p>");
		//Construct the query based on passed email address and password
		$SQLstring = "select Driver_No from driver where Email = '".$email."' and Password = '".$password."'";
		//Execute the query at database
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		//Fetch the rows returned
		$row = mysqli_fetch_row($queryResult);
		//Check if the returned array has data i.e count
		if(count($row) > 0)
		{
			return $row[0];
		}
		else
		{
			echo "<br>Please provide registered email address and password";
			exit();
		}
	}
?>

</HTML>