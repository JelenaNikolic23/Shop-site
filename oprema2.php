<?php
session_start();
require_once("dbcontroller.php");

$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByCode = $db_handle->runQuery("SELECT * FROM oprema WHERE OpremaId='" . $_GET["OpremaId"] . "'");
			$itemArray = array($productByCode[0]["OpremaId"]=>array('naziv'=>$productByCode[0]["naziv"],'OpremaId'=>$productByCode[0]["OpremaId"], 'quantity'=>$_POST["quantity"], 'cena'=>$productByCode[0]["cena"], 'slika'=>$productByCode[0]["slika"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByCode[0]["OpremaId"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["OpremaId"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["id"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
	break;	
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prodavnica sportske opreme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      
    <!-- bootstrap cdn-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="dodatno.css" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
    
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

<!-- -->
<?php

include("konekcija.php");
if(isset($_SESSION["user_id"])) {
	if(isLoginSessionExpired()) {
		header("Location:logout.php?session_expired=1");
	}
}
?>
<?php
if(isset($_SESSION["user_name"])) {
?>
<h1>Welcome <?php 
echo $_SESSION["user_name"]; ?>. Click here to  <a href="logout.php" tite="Logout">Logout. </h1>
<?php
}
?>
    
    <!-- galerija -->
    <div id="omotac" class="row"> 
		<?php
		include 'konekcija2.php';
		$r = $GLOBALS['konekcija2']->query("SELECT * FROM oprema");
		if ($r->num_rows >0) { 
			while($rez = $r->fetch_assoc()) {
		?>
			<div class="image">
			    <form method="post" action="oprema2.php?action=add&OpremaId=<?php echo $rez["OpremaId"]; ?>">
				<img src="<?php echo $rez["slika"]; ?>"><br>
				<?php echo $rez["naziv"] ." - ".$rez["cena"]. " din <br>"; ?>
				 <div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
				</form>
			</div>
		<?php
			}
		}
		else{
			echo "nema";
		}
		?>
	</div>
	
	<!-- korpa -->
		<div class="col align-self-center">
			<br><h5>Korpa:</h5>
			<a id="btnEmpty" href="oprema2.php?action=empty">Empty Cart</a>
		</div>


	<?php
	if(isset($_SESSION["cart_item"])){
		$total_quantity = 0;
		$total_price = 0;
	?>
	<table class="tbl-cart" cellpadding="10" cellspacing="1">
		<tr>
           
            <th>Ime</th>
            <th>Kolicina</th>
            <th>Cena</th>
			<th>Ukloni</th>
		</tr>
		<?php		
		foreach ($_SESSION["cart_item"] as $item){
			$item_price = $item["quantity"]*$item["cena"];
			?>
			<tr>
				<td><?php echo $item["naziv"]; ?></td>
				<td><?php echo $item["quantity"]; ?></td>
				<td><?php echo $item["cena"]; ?></td>
				<td><a href="oprema2.php?action=remove&id=<?php echo $item["OpremaId"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
			</tr>
			<?php
			$total_quantity += $item["quantity"];
			$total_price += ($item["cena"]*$item["quantity"]);
		}
		?>		
	</table>
<br>
	<h3>Ukupno proizvoda: <br> <?php echo $total_quantity; ?>,<br> koji ukupno kostaju: <?php echo $total_price . " din " ?><br></h3>	

	<?php
	} else {
	?>
	<div class="no-records">Your Cart is Empty</div>
	<?php 
	}
	?>
	</div>

   <!-- -->
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