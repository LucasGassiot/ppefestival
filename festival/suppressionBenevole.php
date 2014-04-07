<?php

include("_debut.inc.php");


// SUPPRIMER UN BENEVOLE

$id=$_REQUEST['id'];

$lgBenevole=obtenirDetailBenevole($connexion, $id);
$nom=$lgBenevole['nom'];
$prenom=$lgBenevole['prenom'];

// Cas 1ère étape (on vient de gestionBenevole.php)

if ($_REQUEST['action']=='demanderSupprBenevole')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer le b&eacute;n&eacute;vole $nom $prenom? 
   <br><br>
   <a href='suppressionBenevole.php?action=validerSupprBenevole&amp;id=$id'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='listeBenevoles.php?'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de supprimerBenevole.php)

else
{
   supprimerBenevole($connexion, $id);
   echo "
   <br><br><center><h5>Le b&eacute;n&eacute;vole $nom a &eacute;t&eacute; supprim&eacute;</h5>
   <a href='listeBenevoles.php'>Retour</a></center>";
}

?>
