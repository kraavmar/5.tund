<?php
	//functions.php
	
	//alustan sessiooni, et saaks kasutada $_SESSION muutujaid
	session_start(); //sessioon t��tab, isegi kui kasutaja pole veel sisse logind
	
	//********************
	//****** SIGNUP ******
	//********************
	//GLOBALSI SEES k�ik GET, POST, COOKIE ja FILES andmed, n�eme k�iki muutujaid, mis pole funktsioonides
	//var_dump($GLOBALS);
	//$GLOBALS is a PHP super global variable which is used to access global variables from anywhere in the PHP script (also from within functions or methods).
	
	$database = "if16_marikraav"; //database v�ljapoole n�htav
	function signup ($firstName, $lastName, $email, $password, $gender, $phoneNumber){
		//selle sees muutujad pole v�ljapoole n�htavad
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("INSERT INTO user_sample(firstname, lastname, email, password, gender, phonenumber) VALUES(?,?,?,?,?,?)");
		echo $mysqli->error;
		
		$stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $gender, $phoneNumber); //$signupEmail emailiks lihtsalt
		
		if($stmt->execute()) {
			echo "salvestamine �nnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
	}
	
	function login ($email, $password){
		
		$error = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("
			SELECT id, firstname, email, password, created
			FROM user_sample
			WHERE email = ?
		");
		echo $mysqli->error;
		
		//asendan k�sim�rgi
		$stmt->bind_param("s", $email); //s-string
		
		//m��ran tulpadele muutujad
		$stmt->bind_result($id, $firstNameFromDb, $emailFromDb, $passwordFromDb, $created); //Db-database
		$stmt->execute(); //p�ring l�heb l�bi executiga, isegi kui �htegi vastust ei tule
		
		if($stmt->fetch()) { //fetch k�sin rea andmeid
			//oli rida
			//v�rdlen paroole 
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
				echo "kasutaja ".$id." logis sisse";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				$_SESSION["firstName"] = $firstNameFromDb;
				
				//suunaks uuele lehele
				header("Location: hw_data.php");
				
			} else {
				$error = "parool vale";
			}
		} else {
			//ei olnud
			$error = "sellise emailiga ".$email." kasutajat ei olnud.";
		}
		
		return $error;
	}
	
	
	
	/*function sum($x, $y){
		return $x + $y;
	}
	
	echo sum(34,10);
	echo "<br>";
	//v�id hoida meeles ka muutujas $answer = sum(10,15);
	//echo $answer;
	
	//arvude liitmine +, stringide liitmine .
	function hello ($firstName, $lastName) {
		return "Tere tulemast ".$firstName." ".$lastName."!";
	}
	
	echo hello("Mariann", "Kraav");*/
?>