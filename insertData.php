<!DOCTYPE html>
<html>
<head>
<title>form php</title>
</head>
<body>
<?php

$servername = "mydb.itap.purdue.edu";
$username = "g1090436";
$password = "Warebnb456!";
$dbname = "g1090436";

 //Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

 //Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully <br>";

 $conditions = $_POST["conditions"];
 $year_built = $_POST["year_built"];
 $rating = 0;
 
 if ($conditions == 'very_poor') {
	 $rating = $rating + .5;
 }
 elseif ($conditions == 'poor') {
	 $rating = $rating + 1;
 }
 elseif ($conditions == 'average') {
	 $rating = $rating + 1.5;
 }
 elseif ($conditions == 'good') {
	 $rating = $rating + 2;
 }
 else {
	 $rating = $rating + 2.5;
 }
 
 $date = date("Y");
 $age = $date - $year_built; 
 
 if ($age <= 5) {
	 $rating = $rating + 2.5;
 }
 elseif ($age > 5 & $age <= 10) {
	 $rating = $rating + 2;
 }
 elseif ($age > 10 & $age <= 15) {
	 $rating = $rating + 1.5;
 }
 elseif ($age > 15 & $age <= 20) {
	 $rating = $rating + 1;
 }
 else{
	 $rating = $rating + .5;
 }
 echo gettype($rating);
 
$sql="INSERT INTO warehouses (warehouse_name, location, size_storage, conditions, year_built, warehouse_price, security, storage, rating) VALUES('$_POST[warehouse_name]','$_POST[location]', '$_POST[size_storage]','$_POST[conditions]','$_POST[year_built]','$_POST[warehouse_price]','$_POST[security]','$_POST[storage]',$rating)";
	
if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

</body>
</html>