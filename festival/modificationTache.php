<?php

include("_debut.inc.php");

// MODIFIER UNE TACHE

$action=$_REQUEST['action'];
$code=$_REQUEST['code'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailEtablissement) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($action=='demanderModifTache')
{
   $lgTach=obtenirDetailTache($connexion, $code);
  
   $libelle=$lgTach['libelle'];
   $lieu=$lgTach['lieu'];
   $nbPers=$lgTach['nbPers'];
}

else
{
   $libelle=$_REQUEST['libelle']; 
   $lieu=$_REQUEST['lieu'];
   $nbPers=$_REQUEST['nbPers'];

   verifierDonneesTachM($connexion, $code, $libelle, $lieu, $nbPers);      
   if (nbErreurs()==0)
   {        
      modifierTache($connexion, $code, $libelle, $lieu, $nbPers);
   }
}

echo "
<form method='POST' action='modificationTache.php?'>
   <input type='hidden' value='validerModifTach' name='action'>
   <table width='85%' cellspacing='0' cellpadding='0' align='center' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>$libelle ($code)</td>
      </tr>
      <tr>
         <td><input type='hidden' value='$code' name='code'></td>
      </tr>";
      
      echo '
      <tr class="ligneTabNonQuad">
         <td> Libell&eacute;*: </td>
         <td><input type="text" value="'.$libelle.'" name="libelle" size="50" 
         maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Lieu*: </td>
         <td><input type="text" value="'.$lieu.'" name="lieu" 
         size="50" maxlength="45"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombre de personnes n&eacute;cessaire*: </td>
         <td><input type="text" value="'.$nbPers.'" name="nbPers" 
         size="4" maxlength="5"></td>
      </tr>';
   
   echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
      <tr>
         <td colspan='2' align='center'><a href='listeTache.php'>Retour</a>
         </td>
      </tr>
   </table>
  
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerModifTach')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La modification de la tache a &eacute;t&eacute; effectu&eacute;e</center></h5>";
   }
}

?>
