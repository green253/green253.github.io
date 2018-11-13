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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
	
$sql="INSERT INTO users (first_name,last_name, email, password, password_check, phone_number, role) VALUES('$_POST[first_name]','$_POST[last_name]', '$_POST[email]','$_POST[password]','$_POST[password_check]','$_POST[phone_number]','$_POST[role]')";
	
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

</body>
</html>