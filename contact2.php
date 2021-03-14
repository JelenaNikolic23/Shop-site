<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prodavnica sportske opreme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      
    <!-- bootstrap cdn-->
	<link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    
    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

    <!--font awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>

    <!-- header/meni -->
	<header class="header">
		<div class="logo">
            <img src="logo2.jpg" alt="LOGO" class="center">
        </div>
        <hr/>
        
        <div class="row justify-content-center">
    		<ul style="list-style-type:none">
				<li><a href="index2.php">HOME</a></li>
				<li><a href="oprema2.php">OPREMA</a></li>
				<li><a href="contact2.php">KONTAKT</a></li>
			</ul>
        </div> 
        <hr/>
    </header>
    			
    <div class="container-fluid"> 
        <div class="row">   <!--sluzi nam da podelimo ekran-->
            <div class="col-sm-7 col-sm-push-5" >  
            <h2>Kontakt podaci:</h2>
            <ul>
                <li>
                <div id="Adresa"> 
                <b>Adresa:</b> Kraljice Marije 8 
                </div>
                <div id="Telefon">
		         <b>Telefon: </b> 011 3345145 
                </div>
                 <div id="Mapa"> 
                     
		       <p><br> <h2> Mapa </h2>
				</div>
			<div class="mapouter">
			<div class="gmap_canvas">
				<iframe width="500" height="500" id="gmap_canvas" 
				src="https://maps.google.com/maps?q=kraljice marije 8&t=&z=15&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
				</iframe>	
			</div>
			<style>.mapouter{overflow:hidden;height:500px;width:600px;}.gmap_canvas {background:none!important;height:500px;width:600px;}
			</style>
			</div>
                </li>
             </ul>
        </div>
        <div class="col-sm-5 col-sm-pull-7">
        <?php
session_start();
include("konekcija.php");
$message="";
if(count($_POST)>0) {
	if( !empty($_POST["user_name"] and $_POST["password"])) {
		$_SESSION["user_id"] = 1001;
		$_SESSION["user_name"] = $_POST["user_name"];
		$_SESSION['loggedin_time'] = time();  
	} else {
		$message = "Invalid Username or Password!";
	}
}

if(isset($_SESSION["user_id"])) {
	if(!isLoginSessionExpired()) {
		header("Location:oprema2.php");
	} else {
		header("Location:logout.php?session_expired=1");
	}
}

if(isset($_GET["session_expired"])) {
	$message = "Login Session is Expired. Please Login Again";
}
?>
<h2>User Login</h2>
	<form name="frmUser" method="post" action="">
	<?php if($message!="") { ?>
	<div class="message"><?php echo $message; ?></div>
<?php } ?>
	<table 	 cellpadding="10" cellspacing="1" width="100%" class="tblLogin">
<tr class="tableheader">
<td 	 colspan="2">Enter Login Details</td>
</tr>
<tr class="tablerow">
<td	>Username</td>
<td><input type="text" name="user_name"></td>
</tr>
<tr class="tablerow">
<td 	>Password</td>
<td><input type="password" name="password"></td>
</tr>
<tr class="tableheader">
<td  colspan="2"><input type="submit" name="submit" value="Submit"></td>
</tr>
</table>
</form>

<footer>
        <hr/>
        <div class="row justify-content-center">    
            <h4>Pratite nas: </h4>
            <ul>
                <li><a href="http://instragram.com"><i class="fab fa-instagram"></i></a></li>
                <li><a href="http://facebook.com"><i class="fab fa-facebook-square"></i></a></li>
            </ul>
        </div>
    </footer>
     

</body>
</html>