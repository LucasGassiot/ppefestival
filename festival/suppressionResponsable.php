<?php

include("_debut.inc.php");

$id=$_REQUEST['id'];  

$lgResponsable=Responsabilite($connexion, $annee, $id);
$nomBenevole=$lgResponsable['nomBene'];
$prenomBenevole=$lgResponsable['prenomBene'];
$nomGroupe=$lgResponsable['nomGroupe'];

// Cas 1ère étape (on vient de listeResponsable.php)

if ($_REQUEST['action']=='demanderSupprResponsable')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer la responsabilite du groupe $nomGroupe par le benevole $nomBenevole $prenomBenevole ? 
   <br><br>
   <a href='suppressionResponsable.php?action=validerSupprResponsable&amp;id=$id'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='listeResponsable.php?'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de suppressionResponsable.php)

else
{
   supprimerResponsable($connexion, $id, $LaDate);
   echo "
   <br><br><center><h5>La responsabilite de $nomGroupe par $nomBenevole $prenomBenevole a été supprimee</h5>
   <a href='listeResponsable.php?'>Retour</a></center>";
}

?>
