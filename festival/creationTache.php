<?php

include("_debut.inc.php");


// CRÉER UNE TACHE 

$action=$_REQUEST['action'];

// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
// les champs à vide sinon on affichera les valeurs précédemment saisies
if ($action=='demanderCreTach') 
{  
   $code='';
   $libelle='';
   $lieu='';
   $nbPers='';
}
else
{
   $code=$_REQUEST['code']; 
   $libelle=$_REQUEST['libelle']; 
   $lieu=$_REQUEST['lieu'];
   $nbPers=$_REQUEST['nbPers'];
   
   verifierDonneesTachC($connexion, $code, $libelle, $lieu, $nbPers);      
   if (nbErreurs()==0)
   {        
      creerTache($connexion, $code, $libelle, $lieu, $nbPers);
   }
}

echo "
<form method='POST' action='creationTache.php?'>
   <input type='hidden' value='validerCreTach' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>Nouvelle tache</td>
      </tr>
      <tr class='ligneTabNonQuad'>
         <td> Code*: </td>
         <td><input type='text' value='$code' name='code' size ='5' 
         maxlength='5'></td>
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
         <td> Nombre de personnes n&eacute;cessaires*: </td>
         <td><input type="text" value="'.$nbPers.'" name="nbPers" 
         size="4" maxlength="5"></td>
      </tr>
   </table>';
   
   echo "
   <table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td align='right'><input type='submit' value='Valider' name='valider'>
         </td>
         <td align='left'><input type='reset' value='Annuler' name='annuler'>
         </td>
      </tr>
      <tr>
         <td colspan='2' align='center'><a href='listetache.php'>Retour</a>
         </td>
      </tr>
   </table>
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerCreTach')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La cr&eacute;ation de la tache a &eacute;t&eacute; effectu&eacute;e</center></h5>";
   }
}

?>
