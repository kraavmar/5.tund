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
		
	$people = getAllPeople();
	//pre näitab ilusti sisu
	/*echo "<pre>";
	var_dump($people);
	//var_dump($people[2]); näitab indeksi järgi ühte muutujat massiivis
	echo "</pre>";*/
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

<h2>Arhiiv</h2>
<?php
	foreach($people as $p){
		echo "<h3 style=' color:" .$p->clothingColor."; '>"
		.$p->gender
		."</h3>";
	} 
?>

<h2>Arhiivtabel</h2>
<?php
	$html = "<table>";
		$html .= "<tr>"; // .= stringide liitmine olemasolevale koguaeg juurde
			$html .= "<th>Id</th>";
			$html .= "<th>Sugu</th>";
			$html .= "<th>Värv</th>";
			$html .= "<th>Loodud</th>";
		$html .= "</tr>";

	foreach($people as $p){
		$html .= "<tr>"; // .= stringide liitmine olemasolevale koguaeg juurde
			$html .= "<td>".$p->id."</td>";
			$html .= "<td>".$p->gender."</td>";
			$html .= "<td style=' background-color:".$p->clothingColor."; '>".$p->clothingColor."</td>";
			$html .= "<td>".$p->created."</td>";
		$html .= "</tr>";

	} 
	
	$html .= "</table>";
	
	echo $html;
?>
