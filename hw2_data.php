<?php
	//kui midagi ei tööta, kommenteeri headerid välja!!! Siis kui viga siis näitab, muidu lihtsalt suunab
	
	require("hw2_functions.php");
	
	//kas on sisse loginud, kui ei ole, siis suunata login lehele
	
	if (!isset($_SESSION["userId"])) { //kui ei ole session userId, suuna login lehele 
	//ehk data.php sisestades ribale, pole sisse logind, suunadb login.php lehele
		
		header("Location:hw2_login.php");
	}
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location:hw2_login.php");
	}
	
	$topics = addPostToArray();
	
	if (isset ($_POST["headline"]) && 
		isset ($_POST["content"]) && 
		!empty ($_POST["headline"]) && 
		!empty ($_POST["content"])
		){
			createNewPost ($_POST["headline"], $_SESSION["firstName"]);
			createNewContent ($_POST["content"]); 	
			echo $_SESSION["firstName"];
	}	
?>

<h1>Data</h1>
<p>
	Tere tulemast <?=$_SESSION["firstName"];?>!
	<a href="?logout=1">Logi välja</a>
</p>
<h2>Loo uus postitus</h2>
<form method="POST">
	<label>Pealkiri:</label>
	<input type="text" name="headline">
	<br><br>
	<label>Sisu:</label>
	<textarea cols="40" rows="5" name="content" ></textarea>
	<br><br>
	<input type="submit" value = "Postita">
</form>

<h1>Foorum</h1>
<?php
	$html = "<table>";
		$html .= "<tr>"; // 
			//$html .= "<th>Id</th>";
			$html .= "<th>Teema</th>";
			$html .= "<th>Kasutaja</th>";
			$html .= "<th>Lisamise kuupäev</th>";
		$html .= "</tr>";

	foreach($topics as $t){
		$html .= "<tr>";
			//$html .= "<td>".$t->id."</td>";
			$html .= "<td> <a href='#heading' onclick='changeTitle()'>".$t->subject."</a></td>";
			$html .= "<td>".$t->user."</td>";
			$html .= "<td>".$t->created."</td>";
		$html .= "</tr>";
	} 
	
	$html .= "</table>";
	
	echo $html;
	
	$headingName = "";
?>

<h1 id="heading"> <?php echo $headingName; ?> </h1>
<p>
<script>
	function changeTitle(){
		/*<?php $headingName =  $_SESSION["subject"];?> 
		document.getElementById('heading').innerHTML = '<?php echo $headingName; ?>';*/
		document.getElementById('heading').innerHTML = 'Valitud teema sisu: ';
	}
</script>
</p>