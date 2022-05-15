<?php
// PHP code to establish connection
// with the localserver
// Username is root
$user = 'root';
$password = ''; 
  
// Database name is phani
$database = 'phani'; 
  
// Server is localhost with
// port number 3308
$servername='localhost';
$mysqli = new mysqli($servername, $user, 
                $password, $database);
  
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . 
    $mysqli->connect_errno . ') '. 
    $mysqli->connect_error);
}
  
// SQL query to select data from database
$sql = "SELECT * FROM booking ORDER BY Booking_Number DESC ";
$result = $mysqli->query($sql);
$mysqli->close(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking History</title>
    <!-- CSS FOR STYLING THE PAGE -->
    <link rel="stylesheet" type="text/css" href="style3.css">
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
    <style>
        table {
            margin: 0 auto;
            font-size: 15px;
            border: 1px solid black;
        }
  
        h1 {
            text-align: center;
            color: #006600;
            font-size: 15px;
            font-family: 'Gill Sans', 'Gill Sans MT', 
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }
  
        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }
  
        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }
  
        td {
            font-weight: lighter;
        }
    </style>
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
    <section>
        <h3>Booking History</h3>
        <!-- TABLE CONSTRUCTION-->
        <table>
            <tr>
                <th>Booking_Number</th>
                <th>Customer_ID</th>
                <th>Passenger_Name</th>
                <th>Passenger_Phone</th>
                <th>Unit_Number</th>
                <th>Street_Number</th>
                <th>Street_Name</th>
                <th>Suburb</th>
                <th>Destination_Suburb</th>
                <th>Pickup_Date</th>
                <th>Pickup_Time</th>
                <th>Booking_DT</th>
                <th>Booking_status</th>
                               
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM ROWS-->
            <?php   // LOOP TILL END OF DATA 
                while($rows=$result->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows['Booking_Number'];?></td>
                <td><?php echo $rows['Customer_ID'];?></td>
                <td><?php echo $rows['Passenger_Name'];?></td>
                <td><?php echo $rows['Passenger_Phone'];?></td>
                <td><?php echo $rows['Unit_Number'];?></td>
                <td><?php echo $rows['Street_Number'];?></td>
                <td><?php echo $rows['Street_Name'];?></td>
                <td><?php echo $rows['Suburb'];?></td>
                <td><?php echo $rows['Destination_Suburb'];?></td>
                <td><?php echo $rows['Pickup_Date'];?></td>
                <td><?php echo $rows['Pickup_Time'];?></td>
                <td><?php echo $rows['Booking_DT'];?></td>
                <td><?php echo $rows['Booking_status'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
    </section>
</body>
  
</html>