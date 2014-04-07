<?php

//Etant donnée le include de anneeFestival.php (en dessous)
//La connection ne se fera plus qu'une seule fois, sur cette page
//Ainsi que le include de gestionBase et controlesEtGestionErreurs
//Cela évite les conflits de connection, étant donné qu'elle est obligatoire
//Pour selectionner l'année (sinon tentative de reconnection et conflit à cause des autres pages)
include("_gestionBase.inc.php"); 
include("_controlesEtGestionErreurs.inc.php");
$connexion=connect();
if (!$connexion)
{
   ajouterErreur("Echec de la connexion au serveur MySql");
   afficherErreurs();
   exit();
}
if (!selectBase($connexion))
{
   ajouterErreur("La base de données festival est inexistante ou non accessible");
   afficherErreurs();
   exit();
}
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<!-- TITRE ET MENUS -->
<html lang="fr">
<head>
<title>Festival</title>
<meta http-equiv="Content-Language" content="fr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/cssGeneral.css" rel="stylesheet" type="text/css">
</head>
<body class="basePage">
<div id="anneeFestival">';
	//On include la page permettant la selection de l'année
	//Cela permet de l'avoir sur toutes les pages du site
	include_once('anneeFestival.php');
echo'
</div>
<!--  Tableau contenant le titre -->
<table width="100%" cellpadding="0" cellspacing="0">
   <tr> 
      <td class="titre">Festival Folklores du Monde <br>
      <span id="texteNiveau2" class="texteNiveau2">
      H&eacute;bergement des groupes</span><br>&nbsp;
      </td>
   </tr>
</table>

<!--  Tableau contenant les menus -->
<table width="80%" cellpadding="0" cellspacing="0" class="tabMenu" align="center">
   <tr>
      <td class="menu"><a href="index.php">Accueil</a></td>
      <td class="menu"><a href="listeEtablissements.php">
      Gestion établissements</a></td>
	  <td class="menu"><a href="listeGroupe.php">
	  Gestion groupes</a></td>
	  <td class="menu"><a href="listeBenevoles.php">
	  Gestion benevoles</a></td>
	</tr><tr>
      <td class="menu"><a href="consultationAttributions.php">
      Attributions chambres</a></td>
	  <td class="menu"><a href="listeResponsable.php">
	  Liste responsables</a></td>
	  <td class="menu"><a href="listeTache.php">
	  Liste taches</a></td>
	  
   </tr>
</table>
<br>';


