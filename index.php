		    
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WareBnB</title>
<link rel = "stylesheet"
   type = "text/css"
   href = "styles.css" />	
   
</head>
<body>
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
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/home.php">Home</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/search.php">Search</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/createAccount.php">Create Account</a></li>
	<li><a class="active" href="http://web.ics.purdue.edu/~g1090436/WareBnb/index.php">Register Warehouse</a></li>
	</ul>
<div class="flex-container">		
        <div class="search">
          <h1> Warehouse Registration Criteria</h1>
		  <form name="warehouse_reg" action="insertData.php" method="post" onsubmit="return validateForm()">
		  <div class="search-flex-container">
		  <div class="column">
		  <div class="form-field">
		  <label for="warehouse_name">Warehouse Name *</label>
		  <input required type="text" name="warehouse_name" id="warehouse_name"><p></p>
		  </div>
		  <div class="form-field">
		  <label for="location">Location *</label>
		  <select required name="location" id="location">
		  <option value="Atlanta"> Atlanta </option>
		  <option value="Chicago"> Chicago </option>
		  <option value="Dallas"> Dallas </option>
		  <option value="Denver"> Denver </option>
		  <option value="Detroit"> Detroit </option>
		  <option value="LosAngeles"> Los Angeles </option>
		  <option value="Newark"> Newark </option>
		  <option value="Orlando"> Orlando </option>
		  <option value="Philadelphia"> Philadelphia </option>
		  <option value="Phoenix"> Phoenix </option>
		  </select><p></p>
		  </div>
		  <div class="form-field">
		  <label for="size_storage">Size of Storage *</label>
		  <input required type="text" name="size_storage" id="size_storage"><p></p>
		  </div>
		  <div class="form-field">
		  <label for="conditions">Condition of Warehouse *</label>
		  <select required name="conditions" id="conditions">
		  <option value="very_poor"> Very Poor </option>
		  <option value="poor"> Poor </option>
		  <option value="average"> Average </option>
		  <option value="good"> Good </option>
		  <option value="very_good"> Very Good </option>
		  </select></div><p></p>
		  <div class="form-field"><label for="year_built">Year Built (----) *</label>
		  <input required type="text" name="year_built" id="year_built" pattern="[0-9]{4}"><p></p>
		  </div>
		  </div>
		  <div class="column">
		  <div class="form-field">
		  <label for="start_date">Start Date *</label>
		  <input required type="date" name="start_date" id="start_date"><p></p>
		  </div>
		  <div class="form-field">
		  <label for="end_date">End Date *</label>
		  <input required type="date" name="end_date" id="end_date"><p></p>
		  </div>
		  <div class="form-field">
		  <label for="warehouse_price">Price *</label>
		  <input required type="text" name="warehouse_price" id="warehouse_price"><p></p>
		  </div>
		  </div>
		  
		  <div class="column">
		  <div class="form-field">
		  <label for="security">Type of Security Provided: *</label><br>
		  <select required name="security" id="security">
		  <option value="none"> None Required </option>  
          <option value="alarm"> Alarm System</option>
		  <option value="heatSensor"> Heat Sensor </option>
		  <option value="guards"> 24 Hour Guards </option>
		  </select>
		  </div><p></p>
		  <!-- form field-->
		  <div class="form-field">
		  <label for="storage">Type of Storage Provided: *</label><br>
		  <select required name="storage" id="storage">
		  <option value="chemical"> Chemical </option>
		  <option value="industrial">Industrial </option>
		  <option value="Electrical">Electrical </option>
		  <option value="Nuclear">Nuclear </option>
			  </select>
			  </div><p></p>
		  <input type="submit" name="warehouse_submit" value="Submit" onclick="warehouseSubmit()">
		  </div>
		</div>
		</form>
        </div>
     </div>

   <div style="clear:both"></div>
   <div id="footer">
        <div class="container">
            <p>Footer</p>
        </div>
    </div>
</div>

<script type="text/javascript">
function validateForm() {
	var start_date = document.forms["warehouse_reg"]["start_date"].getTime();
	print(start_date);
	var end_date = document.forms["warehouse_reg"]["end_date"].getTime();
	var difference = end_date - start_date;
	

	if (difference < 0) {
        alert("Input not valid");
		return false;
    }
	
}
function warehouseSubmit()
{
var xmlhttp;
xmlhttp= new XMLHttpRequest();
xmlhttp.open("GET", "insertData.php?warehouse_name="+document.getElementById("warehouse_name").value+"&location="+document.getElementById("location").value+"&size_storage="+document.getElementById("size_storage").value+"&conditions="+document.getElementById("conditions").value+"&year_built="+document.getElementById("year_built").value+"&start_date="+document.getElementById("start_date").value+"&end_date="+document.getElementById("end_date").value+"&price="+document.getElementById("price").value+"&security="+document.getElementById("security").value+"&storage="+document.getElementById("storage").value,false);
xmlhttp.send(null);
	}
}
</script>
</body></html>