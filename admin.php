
<HTML XMLns="http://www.w3.org/1999/xHTML"> 

  <head> 
    <title>Admin Page</title> 
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
        <li><a href="home.php">Logout</a></li>
       
      </ul>
    </div>
  </nav>

  <br><br><br><br>
	<H2>Cab Service Management</H2><br>
	<H4>Click for booking requests & History with a pick-up time within 4 hours.</H5>
  <form>
		
		<table>
		<tr><td>&nbsp&nbsp&nbsp<button type="submit" name="submit">Cab Requests</button></td><td></td></tr>
		<tr><td>&nbsp&nbsp&nbsp<button onclick="location.href='BookingHistory.php'" type="button">
         Booking History</button></td><td></td></tr>
	    </table>
  </form>
       
  </body> 

<?php 
	//Check if the reference id is provided for updating the booking status
	if(isset( $_GET['submit']) || isset($_GET['update']))
	{
		if(isset($_GET['reference_id']))
		{	
			//If reference number is provided update the status of the reference number
			
			
			$DBConnect = @mysqli_connect('localhost', 'root', '', 'phani')
			
			Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
			mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
			$SQLstring = "SELECT COUNT(*) FROM booking where Booking_Number='".$_GET['reference_id']."'";
			$queryResult = @mysqli_query($DBConnect, $SQLstring)
			Or die ("<p>Unable to query the Booking table.</p>"."<p>Error code ".
			mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
			
			$row = mysqli_fetch_row($queryResult);
			if($row[0] > 0)
			{
				$SQLstring = "UPDATE booking SET Booking_Status='assigned' where Booking_Number=".$_GET['reference_id'];
				$queryResult = @mysqli_query($DBConnect, $SQLstring)
				Or die ("<p>Unable to update the Booking table.</p>"."<p>Error code ".
				mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
				echo "Reference number: <b>" . $_GET['reference_id'] . "</b> is assigned successfully";
				ListAllBookings();
			}
			else
			{
				//echo "Please provide valid reference number<br><br><a href=home.php>Sign out</a>";
				exit();
			}
		}
		else
		{
			ListAllBookings();
		}
	}

	function ListAllBookings()
	{
		//Build the where clause since it requires date formating
		$TodayDate = date('Y-n-j');
		$StartTime = date('H:i:s');
		$EndTime = date('H:i:s',strtotime("+4 hours"));
		$dateClause = " AND B.Pickup_Date = '$TodayDate' AND B.Pickup_Time < '$EndTime' AND B.Pickup_Time > '$StartTime'"; 
		$TableName = "booking or customer";
		
		
		$DBConnect = @mysqli_connect('localhost', 'root', '', 'phani')
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ".
		mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
		
		$SQLstring = "SELECT B.Booking_Number,C.Customer_Name,B.Passenger_Name,B.Passenger_Phone,B.Unit_Number,B.Street_Number,
				B.Street_Name,B.Suburb,B.Destination_Suburb,B.Pickup_Date,B.Pickup_Time 
				FROM booking B, customer C WHERE B.Customer_ID = C.Customer_No AND B.Booking_Status = 'unassigned'".$dateClause;
		//echo $SQLstring; 
		$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to query the $TableName table.</p>"."<p>Error code ".
		mysqli_errno($DBConnect). ": ". mysqli_error($DBConnect)). "</p>";
		$row = mysqli_fetch_row($queryResult);
		//Check if there are any bookings 
	
		if(count($row) > 0)
		{
			echo "<table width='100%' border='1'>";
			echo "<th>Reference #</th><th>Customer name</th><th>Passenger name</th><th>Passenger contact phone</th><th>Pick-up address</th>
			<th>Destination suburb</th><th>Pick-up time</th>";
			while ($row) 
			{	 
			
				echo "<tr><td>{$row[0]}</td>"; 
				echo "<td>{$row[1]}</td>"; 
				echo "<td>{$row[2]}</td>";
				echo "<td>{$row[3]}</td>";
				if(empty($row[4]))
					$address = $row[5]." ".$row[6].",".$row[7];
				else
					$address = $row[4]."/".$row[5]." ".$row[6].",".$row[7];
				echo "<td>$address</td>";
				echo "<td>{$row[8]}</td>";
				$dt = $row[9].":".$row[10];
				$dt = date_create_from_format('Y-n-j:H:i:s',$dt);
				$dt = date_format($dt,'d M H:i');
				echo "<td> $dt </td></tr>"; 
				$row = mysqli_fetch_row($queryResult);
			}
			echo "</table><br/><br/>";
			echo "<form><H3>Input a reference number below and click \"update\" button to assign a taxi to that request.</H3><br/>";
			echo "Reference number:<input type=\"text\" name=\"reference_id\"/> <input type=\"submit\" value=\"Update\" name=\"update\"/><br><br></form>";
		
		}
		else
		{
			echo "<H3> There are no pickups within 2 hours from now </H3><br><br>";
		}
		mysqli_close($DBConnect);
	}
?>
    
</HTML>