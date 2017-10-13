<?php session_start();
require_once("connect.php");
if (!isset($_SESSION['user'])){
	header("Location: index.php");
}
?>
<?php
function tableau(){
	?>
	<form method="post" action="roulette.php">
				<hr>
						<input type="number" name="mise" min="0" placeholder="Votre mise"/></br>
				<hr>
						<label class="switch">
 							 <input type="checkbox" id="selectionneur" checked>
 							 <span class="slider round"></span>
						</label>
				<hr>		
						<div id="affichernb">
							Choix du nombre: <input type="number" name="nb" min="0" max="36"/>
							</br>
						</div>
						<div id="afficherparite">
							<label class="container">Pair
								<input type="radio" name="bool" value="pair" checked>
								<span class="checkmark"></span>
							</label>
							<label class="container">Impair
  								<input type="radio" name="bool" value="impair">
 								 <span class="checkmark"></span>	
							</label>
						</div>
				<hr>
						<input type="submit" name="miser" class="btn btn-success" value="Jouer">
		</form>	
<?php
}

?>
<!Doctype html>
<html>
    <head>
    <meta charset="utf-8">
   
    <title>roulette </title>
    	   <link href="parite.css" rel="stylesheet">
		   <link href="css.css" rel="stylesheet">
		   <link href="switch.css" rel="stylesheet">
		   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    </head>
	
<body>
<nav class="navbar navbar-inverse bg-primary">
		<form method="post" action="roulette.php">
			<input type="submit" class="btn btn-danger" name="deco" value="Déconnexion">
		</form>
	</nav>

<?php
if (isset($_POST['deco'])) {
		unset($_SESSION['user']);
		unset($_SESSION['argent']);
		unset($_SESSION['id']);
		header("Location: index.php");
}
if(isset($_POST['miser'])){ //Si on appuis sur le bouton

	if($_POST['mise']>0){//Si la mise est positive

		if($_POST['mise']!=0){//Si la mise est différente de 0

			if($_SESSION['argent']>=$_POST['mise']){//Si la mise est inférieur au solde

				if($_POST['nb']!="" || isset($_POST['bool'])){//Si on a choisi nombre où parité
					$num=rand(1,36);
					$gain=0;
					$bdd=connectDB();
					if($bdd){
						$_SESSION['argent']-=$_POST['mise'];
						?>
						<h4 class="lancer"><?php echo 'Le nombre tiré est '.$num.'.'; ?></h4>
						<?php 
						if ($_POST['nb']!=''){//si on choisi le nombre
							if($_POST['nb']==$num){//si le nombre est bon alors mise *35
								$_SESSION['argent']+=$_POST['mise']*35;
								$gain=$_POST['mise']*35;
								?><h5 class="gainouperte"><?php echo 'Vous avez gagné '.$gain.'€ ! :)';?></h5>
								<?php
							}
							else{
								?><h5 class="gainouperte"><?php echo 'Perdu ! :(';?></h5>
								<?php
							}
						}
						else{//si on choisi la parité

							if($num%2==0 && $_POST['bool']=="pair" || $num%2==1 && $_POST['bool']=="impair"){//si le nombre est bon alors mise *2
								$_SESSION['argent']+=$_POST['mise']*2;
								$gain=$_POST['mise']*2;
								?><h5 class="gainouperte"><?php echo 'Vous avez gagné '.$gain.'€ ! :)';?></h5>
								<?php
							}
							else{
								?><h5 class="gainouperte"><?php echo 'Perdu ! :(';?></h5>
								<?php
							}
						}
						$bdd -> query('UPDATE joueur SET argent='.$_SESSION['argent'].' WHERE nom="'.$_SESSION['user'].'";');
						$val='INSERT INTO partie(joueur, date, mise, gain) VALUES ("'.$_SESSION['id'].'", NOW(), '.$_POST['mise'].', '.$gain.');';
								$bdd -> query($val);

					}
					else{
						?><h5 class="erreur"><?php echo 'La connexion à la base de données a echouée';?></h5>
								<?php
						
					}
				}
	 			else {//else du choix de la parité ou du nombre
	 				?><h5 class="erreur"><?php echo 'Veuillez choisir une parité ou un nombre !';?></h5>
								<?php
	 				
				 }

			}
			else{//else de la vérif du solde
				?><h5 class="erreur"><?php echo 'Vous ne pouvez pas miser plus que vous avez !';?></h5>
								<?php
				
			}

			}
		else{//else de la mise diffente de 0
			?><h5 class="erreur"><?php echo 'Vous devez miser quelque chose !';?></h5>
								<?php
			
		}

	}
	else{//else de la mise positive
		?><h5 class="erreur"><?php echo 'Vous devez miser une valeur positive !';?></h5>
								<?php
		
	} 

}
//unset case du tableau
?>
	 <h1> Jeu de la roulette </h1>
	 
	 </br></br>
	<div class="centrer">
		<h3><?php echo $_SESSION['user'].'<br/>'.$_SESSION['argent'].'€';?></h4>
		<?php tableau();?>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			var jeu="nombre";//nombre ou parité
			$("#afficherparite").hide();
			$(".slider").click(function(){
				if(jeu=="nombre"){
					jeu="parité";	
					$("#afficherparite").show();
					$("#affichernb").hide();
				}
				else{
					jeu="nombre";
					$("#affichernb").show();
					$("#afficherparite").hide();
				}
			});
		});
	</script>
</body>
</html>