<!DOCTYPE html>
<html>
<head>
<title>form php</title>
</head>
<body>
<?php

$servername = "mydb.itap.purdue.edu";
$username = "green253";
$password = "Classof2015";
$dbname = "green253";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
	
$sql="INSERT INTO WareReg (warehouse_name, location, size_storage, conditions, year_built, start_date, end_date, warehouse_price, security, storage) VALUES('$_POST[warehouse_name]','$_POST[location]', '$_POST[size_storage]','$_POST[conditions]','$_POST[year_built]','$_POST[start_date]','$_POST[end_date]','$_POST[warehouse_price]','$_POST[security]','$_POST[storage]')";
	
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

</body>
</html>