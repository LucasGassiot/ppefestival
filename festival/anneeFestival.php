<?php
//La session permet de conserver l'année même si les pages changent
session_start();

//Recupération de toute les années et de l'annee la plus récente du festival
	$req=obtenirReqAnnee();
   $rsAnnee=mysql_query($req, $connexion);
   $lgAnnee=mysql_fetch_array($rsAnnee);
   $derniereDate=derniereAnnee($connexion);
   
echo "<form action='#' method='POST'>
	<fieldset><legend>Choix de la date</legend>
	<select name='date'>";
	//Boucle permettant d'afficher dans une liste déroulante, les différentes annees du festival
	//Si aucune annee n'a été selectionner, ce sera la plus récente qui sera automatiquement selectionner
	//Sinon ce sera l'année selectionner
		while ($lgAnnee!=FALSE)
		{
			$annee=$lgAnnee['annee'];
			if(isset($_POST['choixAnnee'])){
				$DateChoisi=$_POST['date'];
				if($annee==$DateChoisi){
					echo "<option value='".$annee."' selected='selected'>".$annee."</option>";
				}
				else{
					echo "<option value='".$annee."'>".$annee."</option>";
				}
			}
			elseif(isset($_SESSION['Date'])){
				if($annee==$_SESSION['Date']){
					echo "<option value='".$annee."' selected='selected'>".$annee."</option>";
				}
				else{
					echo "<option value='".$annee."'>".$annee."</option>";
				}
			}
			else{
				if($annee==$derniereDate){
					echo "<option value='".$annee."' selected='selected'>".$annee."</option>";
				}
				else{
					echo "<option value='".$annee."'>".$annee."</option>";
				}
			}
			$lgAnnee=mysql_fetch_array($rsAnnee);
		}
echo"</select><br/>";

//Permet d'afficher le theme choisi, si une annee est selectionnée
//Ce sera le theme de l'année selectionnée
if(isset($_POST['choixAnnee'])){
	
	$theme=themeChoisi($connexion, $DateChoisi);
	echo "Theme : ".$theme[0];
}
elseif(isset($_SESSION['Date'])){
	$theme=themeChoisi($connexion, $_SESSION['Date']);
	echo "Theme : ".$theme[0];
}

//Sinon ce sera l'année la plus récente
else{
	$theme=themeChoisi($connexion,$derniereDate);
	echo "Theme : ".$theme[0];
}

	echo"<br/><input type='submit' name='choixAnnee' value='Mise a jour'/>
	</fieldset>
	</form>";

	
//Variable contenant l'année choisis ou celle par défaut (la plus récente)
if(isset($_POST['choixAnnee'])){
	$_SESSION['Date']=$DateChoisi;
	$LaDate=$DateChoisi;
}
elseif(isset($_SESSION['Date'])){
	$LaDate=$_SESSION['Date'];
}
else{
	$_SESSION['Date']=$derniereDate;
	$LaDate=$derniereDate;
}

?>