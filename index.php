<?php session_start();?>
<!DOCTYPE html>
<?php
function tableau(){
	?>
	<form action="index.php" method="post"><br/>

	<input type="text" placeholder="Identifiant" name="user" size="15"><br/><br/>

	<input type="password" placeholder="Mot de passe" name="password" size="15"><br/><br/>

	<input type="reset" name="reset" class="btn btn-danger" value="Effacer">
	<a href="inscription.php"><input type="button" class="btn btn-warning" name="inscrire" value="S'inscrire"></a>
	<input type="submit" name="submit" class="btn btn-success" value="Jouer">
</form>
<?php
}

?>
<html>
<head>
	<title>Roulette - Identification</title>
	<link rel="stylesheet" href="css.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	

</head>
<body>
<nav class="header">
		<h1>Connectez vous pour jouer à la roulette</h1>
</nav>

<br/>
<br/>
<?php 
tableau();
?>
<br/><br/>
<p>La roulette est un jeu de hasard. Elle comporte 36 cases numérotées de 1 à 36, une bille est lancée dedans et s'arrête à un moment dans une case. Le but est de prévoir où la bille va s'arrêter en misant sur le résultat.</p>

<p>Les règles sont ici simplifiées:<br/>
-Avant chaque partie, le joueur mise de l’argent. Il peut miser sur le résultat exact ou sur sa parité<br/>
-Si le joueur mise sur un nombre et que la bille tombe dans la case numérotée à ce nom, le joueur gagne 35 fois sa mise.<br/>
-Si le joueur mise sur la parité du résultat (le résultat est pair ou impair) et qu'il voit juste, il gagne deux fois sa mise.
</p>
<?php
if (isset($_POST['submit'])){


require_once("connect.php");
$bdd=connectDB();
if($bdd){
	$query = $bdd->query('SELECT * FROM joueur WHERE nom="'.$_POST['user'].'";');
	$data = $query->fetch();
	if($_POST['user']!= "" && $_POST['password']!= ""){
		if($data['nom']==$_POST['user'] && $data['nom']!= ""){
		if($data['mdp']==$_POST['password']){
			$_SESSION['user']=$data['nom'];
			$_SESSION['argent']=$data['argent'];
			$_SESSION['id']=$data['id'];
			header("Location: roulette.php");
		}
		else{
			echo '<h2>Mauvais mot de passe</h2>';
		}


	}
	else{
			echo '<h2>Mauvais utilisateur</h2>';
		}
	/*echo "<pre>";
	print_r($data);
	echo "</pre>";*/
	}
	else{
		echo'<h2>Veuillez remplir les deux champs</h2>';
	}
	
	
}
}

?>
</body>
</html>