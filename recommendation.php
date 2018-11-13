<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
<link rel = "stylesheet"
   type = "text/css"
   href = "styles.css" />	
<style>
#warehouseList {
	border-collapse: collapse;
	width: 100%;
}
#warehouseList td, #warehouseList th {
	border: 1px solid #ddd;
	padding: 8px;
}
#warehouseList tr:nth-child(even){background-color:#f2f2f2;}

#warehouseList tr:hover {background-color: #ddd;}

#warehouseList th {
	padding-top: 12px;
	padding-bottom: 12px;
	text-align: center;
	background-color: #A9A9A9;
	color: white;
}
</style>
</head>

<body>

<?php

// Connection information
$servername = "mydb.itap.purdue.edu";
$username = "g1090436";
$password = "Warebnb456!";
$dbname = "g1090436";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error);
} 
//pulls info from user inputs
$location = $_POST[search_location];
$security = $_POST[search_security];
$storage = $_POST[search_storage];

//Pull IDs from database to use in Scheduling Algorithm
$stmt = "SELECT warehouse_id FROM warehouses WHERE location='". $location ."' AND Security ='" . $security ."' AND storage ='" . $storage ."'";
$result = mysqli_query($conn, $stmt);
//creates an array with for the results of the query
$potential_warehouses = array();
$i=0;
while($row=$result->fetch_assoc()){
	$potential_warehouses[$i] = $row['warehouse_id'];
	$i++;
}

//Sets base date to do math to
$baseDate = strtotime("Jan 1, 2018");
//gets start and end date from user's search
$PD1 = strtotime($_POST[search_start_date]) - $baseDate;
$PD2 = strtotime($_POST[search_end_date]) - $baseDate;
//creates an array of 1s to set default warehouse availability to yes
$availableWareID = array_fill(0, count($potential_warehouses), 1);

//Loop that checks if the dates are available
for($i = 0; $i < count($availableWareID);$i++)
{
	//Sets List to have nothing in it
	$contractList = array();
	//Need contract id, start date, end date
	$currentID = $potential_warehouses[$i];
	$query = $conn -> query("SELECT start_date, end_date From contracts WHERE warehouse_id = '". $currentID ."'");
	$k = 0;
	//inputs the information from the query into the contractList array to analyze
	while($row=$query->fetch_assoc()){
		$contractList[$k]['start_date'] = $row["start_date"];
		$contractList[$k]['end_date'] = $row["end_date"];
		$k++;
	}
	//check to see if its still zero there are no contracts associated with the id
	if(empty($contractList) != 1)
	{	
		for($j = 0; $j < count($contractList); $j++)
		{
			//Sets contract dates
			//Need to see how sql handles this transfer, assuming col 2 = sD, col 3 = eD
			$CD1 = strtotime($contractList[$j]['start_date']) - $baseDate;
			//$mysqldate = date( 'Y-m-d', $contractDate1);
			$CD2 = strtotime($contractList[$j]['end_date']) - $baseDate;
			//$mysqldate = date( 'Y-m-d', $contractDate2);
			$score = 0;
			
			if($PD1 > $CD1){
				$score++;
			}
			if($PD1 > $CD2){
				$score++;
			}
			if($PD2 > $CD1){
				$score++;
			}
			if($CD2 > $CD2){
				$score++;
			}
			if($score == 4 || $score == 0)
			{
				//do nothing
			}
			else
			{
				//Sets the availability to no
				$availableWareID[$i] = 0;
				//ends loop
				break;
			}
		}
	}
}

//We believe everything above this is fine
//creates a list of available warehouses
$goodValues = array();
$x=0;
while($x < count($availableWareID)){
	if($availableWareID[$x] == 1){
		$goodValues[] = $potential_warehouses[$x];
	}
	$x++;
}
//end of scheduling algorithm

//finds the information on the good warehouses to be sent to recommendation algorithm in R NEED TO ADD RATING
$stmt2 = "SELECT warehouse_id, rating, warehouse_price, size_storage FROM warehouses WHERE warehouse_id IN (".implode(',',$goodValues).")";
$query2 = mysqli_query($conn, $stmt2);

//creates an array with the results of the query
$warehouse_info = array();
$r=0;
while($row=$query2->fetch_assoc()){
	$warehouse_info[$r]["id"] = $row['warehouse_id'];
	$warehouse_info[$r]["rating"] = $row['rating'];
	$warehouse_info[$r]["price"] = $row['warehouse_price'];
	$warehouse_info[$r]["size"] = $row['size_storage'];
	$r++;
}

//sets the star value to a numeric value
$star = $_POST[min_star_rating];
if($star == "1star"){
	$star = 1;
} else if($star == "2star"){
	$star = 2;
} else if($star == "3star"){
	$star = 3;
} else if($star == "4star"){
	$star = 4;
} else if($star == "5star"){
	$star = 5;
}
//gets inputs from user
$uprice = $_POST[max_price];
$lprice = $_POST[min_price];
$usize = $_POST[max_storage];
$lsize = $_POST[min_storage];
 
$size = count($warehouse_info);
//creates a list of scores for each warehouse
$warehouse_list = array();
for($n=0; $n < $size; $n++){
	$warehouse_list[$n]["id"] = $warehouse_info[$n]["id"];
	$warehouse_list[$n]["score"] = 0;
}

for($n=0; $n < $size; $n++){
	//checks size
	if($usize - $warehouse_info[$n]["size"] < 0){ //checks if size is higher than upper bound
		$warehouse_list[$n]["score"] += ($warehouse_info[$n]["size"]-$usize) / $usize * 10;
	} else if($lsize - $warehouse_info[$n]["size"] > 0){ //checks if size is lower than lower bound
		$warehouse_list[$n]["score"] += ($warehouse_info[$n]["size"]-$lsize) / $lsize * 20;
	} else{ //checks if size is within the range
		$warehouse_list[$n]["score"] += 20;
	}
	
	//checks rating
	if($star == $warehouse_info[$n]["rating"]){ //checks if the rating is equal
		$warehouse_list[$n]["score"] += 5;
	} else if($star < $warehouse_info[$n]["rating"]){ //checks if rating is greater
		$warehouse_list[$n]["score"] += ($warehouse_info[$n]["score"]-$star) / $star * 5;
	} else{ //checks if rating is smaller
		$warehouse_list[$n]["score"] -= ($warehouse_info[$n]["score"]-$star) / $star * 5;
	}
	
	//checks price
	if($uprice - $warehouse_info[$n]["price"] < 0){ //checks if price is higher than upper bound
		$warehouse_list[$n]["score"] -= ($warehouse_info[$n]["price"]-$uprice) / $uprice * 20;
	} else if($lprice - $warehouse_info[$n]["price"] > 0){ //checks if price is lower than upper bound
		$warehouse_list[$n]["score"] += ($warehouse_info[$n]["price"]-$lprice) / $lprice * 20;
	} else{ //checks if price is within the range
		$warehouse_list[$n]["score"] += 20;
	}		
}

//sort the warehouse list according to the score - high to low
$score = array();
foreach($warehouse_list as $item){
	$score[] = $item['score'];
}
array_multisort($score, SORT_DESC, SORT_NUMERIC, $warehouse_list);
//end of recommendation algorithm

//get an array of the sorted ids
$ID = array();
foreach($warehouse_list as $item){
	$ID[] = $item['id'];
}

//get all information on the sorted list of warehouses
$stmt3 = "SELECT * FROM warehouses WHERE warehouse_id IN (".implode(',',$ID).")";
$query3 = mysqli_query($conn, $stmt3);
//creates an array of the results
$final_list = array();
$f=0;
while($row=$query3->fetch_assoc()){
	$final_list[$f]["warehouse_id"] = $row['warehouse_id'];
	$final_list[$f]["name"] = $row['warehouse_name'];
	$final_list[$f]["location"] = $row['location'];
	$final_list[$f]["size"] = $row['size_storage'];
	$final_list[$f]["condition"] = $row['conditions'];
	$final_list[$f]["built"] = $row['year_built'];
	$final_list[$f]["security"] = $row['security'];
	$final_list[$f]["storage"] = $row['storage'];
	$final_list[$f]["price"] = $row['warehouse_price'];	
	$final_list[$f]["rating"] = $row['rating'];
	$f++;
}

//close database connection
mysqli_close($conn);

?>
 
 <div id="main">
   <div class="container">
	   <div class="header">
    		<a href="http://web.ics.purdue.edu/~g1090436/WareBnb/home.html"><img src="Final Logo.png" alt="WareBnBLogo" id="logomain">
			</a>
			<a href="home.html"<p id="login">Login </p></a> 	
        </div>
		<div style="clear:both"></div>
	<div class = "topnav">
	<ul>
	<li><a class="active" href="http://web.ics.purdue.edu/~g1090436/WareBnb/home.php">Home</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/search.php">Search</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/createAccount.php">Create Account</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/index.php">Register Warehouse</a></li>
	</ul>

	<div style="clear:both"></div><p></p>	
	<div style="overflow-x:auto;">
	<table id = "warehouseList">
		<tr>
			<th>Warehouse Name</th>
			<th>Location</th>
			<th>Size</th>
			<th>Condition</th>
			<th>Year Built</th>
			<th>Security</th>
			<th>Storage</th>
			<th>Price</th>
			<th>Rating</th>
		</tr>
<?php	
	//echo "<tr>";
	$size = count($final_list);
	$id <-$final_list["warehouse_id"];
	echo $id;
	for($t=0; $t < $size; $t++){
		echo "<tr>";
		echo "<td> <a href=details.php?name=$final_list[name]>".$final_list[$t]["name"]."</a></td>";
		echo "<td>".$final_list[$t]["location"]."</td>";
		echo "<td>".$final_list[$t]["size"]."</td>";
		echo "<td>".$final_list[$t]["condition"]."</td>";
		echo "<td>".$final_list[$t]["built"]."</td>";
		echo "<td>".$final_list[$t]["security"]."</td>";
		echo "<td>".$final_list[$t]["storage"]."</td>";
		echo "<td>$".$final_list[$t]["price"]."</td>";
		echo "<td>".$final_list[$t]["rating"]."</td>";			
		echo "</tr>";
	}
?>		
	</table>
	</div>
	
</body>
</html>