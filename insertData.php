<!DOCTYPE html>
<html>
<head>
<title>form php</title>
</head>
<body>
<?php
$warehouse_name=$_POST['warehouse_name'];
$location=$_POST['location'];
$size_storage=$_POST['size_storage'];
$conditions=$_POST['conditions'];
$year_built=$_POST['year_built'];
$start_date=$_POST['start_date'];
$end_date=$_POST['end_date'];
$price=$_POST['price'];
$security=$_POST['security'];
$storage=$_POST['storage'];

define('DB_NAME', 'green253');
define('DB_USER', 'green253');
define('DB_PASSWORD', 'Classof2015');
define('DB_HOST', 'mydb.ics.purdue.edu');

$link = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);

if(!link){
	die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected){
	die('Can\'t use ' .DB_NAME . ':'.mysql_error());
}


$sql = "INSERT INTO WareReg values('$warehouse_name','$location', '$size_storage', '$conditions', '$year_built','$start_date','$end_date','$price','$security','$storage')");
if(!mysql_query($sql)){
	die('Error: ' .mysql_error());
}
mysql_close();
?>

</body>
</html>