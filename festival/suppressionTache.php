<?php

include("_debut.inc.php");


// SUPPRIMER UN TACHE

$code=$_REQUEST['code'];  

$lgTach=obtenirDetailTache($connexion, $code);
$libelle=$lgTach['libelle'];

// Cas 1�re �tape (on vient de listeTache.php)

if ($_REQUEST['action']=='demanderSupprTach')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer la tache $libelle ? 
   <br><br>
   <a href='suppressionTache.php?action=validerSupprTach&amp;code=$code'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='listeTache.php?'>Non</a></h5></center>";
}

// Cas 2�me �tape (on vient de suppressionTache.php)

else
{
   supprimerTache($connexion, $code);
   echo "
   <br><br><center><h5>La tache $libelle a &eacute;t&eacute; supprim&eacute;e</h5>
   <a href='listeTache.php?'>Retour</a></center>";
}

?>
