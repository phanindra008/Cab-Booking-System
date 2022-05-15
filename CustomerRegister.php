
<HTML XMLns="http://www.w3.org/1999/xHTML"> 

  <head> 
    <title>Customer Register Page</title> 
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
	<H2>Register to Cab Services</H2>

  <form class="form3">
		<table> <tr> <td>		
		Name:</td><td><input type="text" name="namefield" required> </label></td></tr>
		<tr><td>
		Password:</td><td><input type="password" name="passwordfield" required> </label></td></tr>
		<tr><td>
		Confirm Password:</td><td><input type="password" name="confirmpasswordfield" required> </label></td></tr>
		<tr><td>
		Email:</td><td><input type="text" name="emailfield" required> </label></td></tr>
		<tr><td>
		Phone:</td><td><input type="text" name="phonefield"  required> </label></td></tr>
		<tr><td>
		&nbsp&nbsp&nbsp<button type="submit">Register</button></br></td><td></td></tr></table>
		
  </form>
 
  <H2>Already registered? <a href="Customerlogin.php">Login</a></H2>
  </body> 

<?php 
	//Validate if all the input field values are provided
	if(isset($_GET['namefield']) && isset($_GET['passwordfield']) && isset($_GET['confirmpasswordfield']) && isset($_GET['emailfield']) && isset($_GET['phonefield']))
	{
		
		//Assigning the entered input values to the variables 
		//$string = $_GET['stringfield'];
		$name = trim($_GET['namefield']);
		$password = trim($_GET['passwordfield']);
		$confirm_password = trim($_GET['confirmpasswordfield']);
		$email = trim($_GET['emailfield']);
		$phone = trim($_GET['phonefield']);
		//Check if any input values is empty
		if(empty($name) || empty($password) || empty($confirm_password) || empty($email) || empty($phone))
		{
			echo "Please provide inputs to all the fields";
			exit();
		}
		else
		{
			//Check if password and confirm passwords are same
			if($password === $confirm_password)
			{
				//Call function to validate email address which returns boolean value
				if(ValidateEmail($email,$name))
				{
					//Call function to register user
					RegisterUser($name,$password,$email,$phone);
				}
				else
				{
					echo "Please enter valid email address";
					exit();
				}
			}
			else
			{
				echo "Password and Confirm password should be same";
					exit();
			}
		}
	}
	//This function takes email address and name as input paramenters and return boolen value true if the email format and address are correct else returns false.
	
	//$emailid = $email;
	function ValidateEmail($emailid,$name1)
	{
		//Check for correct email format
		if(strpos($emailid, '@') > 0 && strpos($emailid, '.') > strpos($emailid, '@')+1 && strpos(strrev($emailid), '.') > 0)
		{
			$email_to = $emailid;
			$subject = "Welcome to CabsOnline!";
			$message = "Dear ". $name1 . ", welcome to use Cab Services!";
			
			
			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: Your name <info@address.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	
			//Send welcome mail to the email address provided
			if(mail($email_to,$subject,$message,$headers))
			{
				//return true if email is sent
				return true;
			}
			else
			{
				echo "Registration failed, email could not be sent!";
				exit();
			}
		}
		return false;
	}
	//This function takes name, password,email address and phone number as input parameters and stores the values in database if validations are passed else error message is displayed
	function RegisterUser($name,$password,$email,$phone)
	{
		$DBConnect = mysqli_connect('localhost', 'root', '', 'phani')
		
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		// get language names from db
	
		$SQLstring = "select count(*) from customer where Email = '".$email."'";
		
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to query the table.</p>"."<p>Error code ".
		mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
		
		$row = mysqli_fetch_row($queryResult);
		if($row[0] == 1)
		{
			echo "This email is already registered!";
			exit();
		}
		else
		{
			$SQLstring = "Insert into customer values(null,'".$name."','".$password."','".$email."','".$phone."')";	
			$queryResult = @mysqli_query($DBConnect, $SQLstring)
			Or die ("<p>Unable to insert into the table.</p>"."<p>Error code ".
			mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
			echo "Thank you for registration, Please check your email addess for a new mail";

		}
	}
?>

</HTML>