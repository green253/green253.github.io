<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
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
	<li><a class="active" href="http://web.ics.purdue.edu/~g1090436/WareBnb/home.php">Home</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/search.php">Search</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/createAccount.php">Create Account</a></li>
	<li><a href="http://web.ics.purdue.edu/~g1090436/WareBnb/index.php">Register Warehouse</a></li>
	</ul>

	<div style="clear:both"></div><p></p>
<div class="flex-container">	
<form action="/action_page.php">
  
  <div>
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required><p></p>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required><p></p>   
    <button type="submit" >Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div><p></p>

  <div>
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw"><a href="#">Forgot password?</a></span>
  </div>
</form><p></p>
</div>
</div>
	</div>
	</div>
<form name="results testing" action="resultsLoad.php" method="post">
	<button type="submit" onclick= "hello();" >Testing</button>
								   
<script type="text/javascript">
function hello()
{
alert ("hello");
}
</script>
</form>
</body></html>