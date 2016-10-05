<?php
	//kui midagi ei tööta, kommenteeri headerid välja!!! Siis kui viga siis näitab, muidu lihtsalt suunab
	
	require("hw_functions.php");
	
	//kas on sisse loginud, kui ei ole, siis suunata login lehele
	
	if (!isset($_SESSION["userId"])) { //kui ei ole session userId, suuna login lehele 
	//ehk data.php sisestades ribale, pole sisse logind, suunadb login.php lehele
		
		header("Location:hw_login.php");
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location:hw_login.php");
	}
	
	// ei ole tühjad väljad, mida salvestada
	if (isset ($_POST["gender"]) && 
		isset ($_POST["color"]) && 
		!empty ($_POST["gender"]) && 
		!empty ($_POST["color"])
		){
			savePeople ($_POST["gender"], $_POST["color"]); 
		}	
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["firstName"];?>!
	<a href="?logout=1">Logi välja</a>
</p>
<h1>Salvesta inimene</h1>
<form method="POST">
	<label>Sugu:</label>
	<input type="radio" name="gender" value="female" checked>Naine
	<input type="radio" name="gender" value="male" checked>Mees
	<input type="radio" name="gender" value="unknown" checked>Ei oska öelda 
	<br><br>
	<label>Värv:</label>
	<input name="color" type="color"> 
	<br><br>
	<input type="submit" value = "Salvesta">
</form>
