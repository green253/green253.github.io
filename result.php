<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
  <script src="//search.med.upenn.edu/jquery.gsaEmbed.js"></script>
  <title>WareBnB</title>
<link rel = "stylesheet"
   type = "text/css"
   href = "styles.css" />	
 <style type="text/css">
.result {
	float: left;
	background: #ccc;
    padding: 20px;
	border-style: solid;
	font-color:red;
	font-size: 15px!important;
	width: 33.3333%;
}
.result img {
	text-align: center;
	width: 350px;
	height: auto;
}
.result p {
	text-align: left;
	font-size: 15px!important;
}
.result h1{
	font-size: 20px!important;
	text-align: center;
}
</style>
   
</head>
<body> 
<?php
$servername = "mydb.itap.purdue.edu";
$username = "g1090436";
$password = "Warebnb456!";
$dbname = "g1090436";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
include_once('recommendation.php');
$sql="SELECT warehouse_name, location, warehouse_price, rating FROM warehouses WHERE warehouse_id = 1 || warehouse_id = 2";	
$result = $conn->query($sql);
echo "<h1 style=\"font-size: 26px!important;\"> Search Results: </h1>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo "<div class=\"result\">";
		echo "<img src=\"Final Logo.png\" alt=\"WareBnBLogo\" style=\"text-align: center\">";
		echo "<h1>";
		echo $row["warehouse_name"];
		echo "</h1>";
		echo "<p>";
		echo $row["location"]."<br>";
		echo $row["warehouse_price"]. " per sq/ft<br>";
		echo $row["rating"] . " star rating <br>";
		echo "</p>";
		echo "</div>";
	}
} else {
    echo "0 results";
}

$conn->close();
?> 
</script>
</body>
</html>
