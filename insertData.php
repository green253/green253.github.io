<!DOCTYPE html>
<html>
<head>
<title>form php</title>
</head>
<body>
<?php
$warehouse_name=$_GET["warehouse_name"];
$location=$_GET["location"];
$size_storage=$_GET["size_storage"];
$conditions=$_GET["conditions"];
$year_built=$_GET["year_built"];
$start_date=$_GET["start_date"];
$end_date=$_GET["end_date"];
$price=$_GET["price"];
$security=$_GET["security"];
$storage=$_GET["storage"];

$conn = mysql_connect("mydb.ics.purdue.edu","green253","Classof2015");
mysql_select_db("WareReg");
mysql_query("insert into WareReg values('$warehouse_name','$location', '$size_storage', '$conditions', '$year_built','$start_date','$end_date','$price','$security','$storage')");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

?>

</body>
</html>