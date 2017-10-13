<?php session_start();
require_once("connect.php");?>
<!DOCTYPE html>
<?php
function tableau(){
	?>
	<form action="Inscription.php" method="post"><br/>

	<input type="text" placeholder="Identifiant" name="user" size="15"><br/><br/>

	<input type="password" placeholder="Mot de passe" name="password" size="15"><br/><br/>

	<input type="button" class="btn btn-danger" onclick="location.href='index.php';" value="Quitter" />
	
	<input type="submit" name="submit" class="btn btn-success" value="S'inscrire">
</form>
<?php
}

?>
<html>
<head>
	<title>Roulette - Inscription</title>
	<link rel="stylesheet" href="css.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
<h1 class="header">Inscription</h1>
<br/>
<br/>
<?php 
tableau();
?>

<?php
if (isset($_POST['submit'])){
	if($_POST['user']!= "" && $_POST['password']!= ""){		

	
	$bdd=connectDB();
	if($bdd){

	$bdd->query('INSERT INTO joueur (nom,argent,mdp) VALUES ("'.$_POST['user'].'", 500,"'.$_POST['password'].'");');

	$_SESSION['user']=$_POST['user'];
	$_SESSION['argent']=500;
	$_SESSION['id']=$bdd->query('SELECT id FROM joueur WHERE nom="'.$_POST['user'].'";');
	header("Location: roulette.php");
		}
	}
	else{
			echo'<h2>Veuillez remplir les deux champs</h2>';
		}
}

?>
</body>
</html>