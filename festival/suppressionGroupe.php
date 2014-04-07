<?php

include("_debut.inc.php");


// SUPPRIMER UN ÉTABLISSEMENT 

$id=$_REQUEST['id'];  

$lgGroupe=obtenirDetailGroupe($connexion, $id);
$nom=$lgGroupe['nom'];

// Cas 1ère étape (on vient de listeEtablissements.php)

if ($_REQUEST['action']=='demanderSupprGroupe')    
{
   echo "
   <br><center><h5>Souhaitez-vous vraiment supprimer le groupe $nom ? 
   <br><br>
   <a href='suppressionGroupe.php?action=validerSupprGroupe&amp;id=$id'>
   Oui</a>&nbsp; &nbsp; &nbsp; &nbsp;
   <a href='listeGroupe.php?'>Non</a></h5></center>";
}

// Cas 2ème étape (on vient de suppressionEtablissement.php)

else
{
   supprimerGroupe($connexion, $id);
   echo "
   <br><br><center><h5>Le groupe $nom a &eacutet&eacute supprim&eacute</h5>
   <a href='listeGroupe.php?'>Retour</a></center>";
}

?>
