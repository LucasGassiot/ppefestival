<?php

include("_debut.inc.php");


// MODIFIER UN BENEVOLE


$action=$_REQUEST['action'];
$id=$_REQUEST['id'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailBenevole) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($action=='demanderModifBenevole')
{
   $lgBenevole=obtenirDetailBenevole($connexion, $id);
	
   $nom=$lgBenevole['nom']; 
   $prenom=$lgBenevole['prenom'];
   $anneeNaissance=$lgBenevole['anneeNaissance'];
   $anneeDebutBene=$lgBenevole['anneeDebutBene'];
   $telephone=$lgBenevole['telephone'];
   $mail=$lgBenevole['mail'];
   $moyenTransp=$lgBenevole['moyenTransp'];

}
else
{ 
   $nom=$_REQUEST['nom']; 
   $prenom=$_REQUEST['prenom'];
   $anneeNaissance=$_REQUEST['anneeNaissance'];
   $anneeDebutBene=$_REQUEST['anneeDebutBene'];
   $telephone=$_REQUEST['telephone'];
   $mail=$_REQUEST['mail'];
   $moyenTransp=$_REQUEST['moyenTransp'];

   verifierDonneesBenevoleM($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail);
   if (nbErreurs()==0)
   {        
      modifierBenevole($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail, $moyenTransp);
   }
}

echo "
<form method='POST' action='modificationBenevole.php?'>
   <input type='hidden' value='validerModifBenevole' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='tabNonQuadrille'>
   
         <tr class='enTeteTabNonQuad'>
         <td colspan='3'>".'Modifier b&eacute;n&eacute;vole '.$nom." ".$prenom."</td>
      </tr>
      <tr>
         <td><input type='hidden' value='$id' name='id'></td>
      </tr>";
     
       echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="20" 
         maxlength="20"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Pr&eacute;nom* : </td>
         <td><input type="text" value="'.$prenom.'" name="prenom" 
         size="20" maxlength="20"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ann&eacute;e de naissance*: </td>
         <td><input type="year" value="'.$anneeNaissance.'" name="anneeNaissance" 
         size="4" maxlength="4"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ann&eacute;e de d&eacute;but du b&eacute;n&eacute;volat*: </td>
         <td><input type="year" value="'.$anneeDebutBene.'" name="anneeDebutBene" size="4" 
         maxlength="4"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Telephone*: </td>
         <td><input type="text" value="'.$telephone.'" name="telephone" size ="10" 
         maxlength="10"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Mail* : </td>
         <td><input type="text" value="'.$mail.'" name=
         "mail" size ="30" maxlength="30"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Moyen de transport ? </td>
         <td>';
            if ($moyenTransp==1)
            {
               echo " 
               <input type='radio' name='moyenTransp' value='1' checked>  
               Oui
               <input type='radio' name='moyenTransp' value='0'>  Non";
             }
             else
             {
                echo " 
                <input type='radio' name='moyenTransp' value='1'> 
                Oui
                <input type='radio' name='moyenTransp' value='0' checked> Non";
              }
           echo '
           </td>
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
         <td colspan='2' align='center'><a href='listeBenevoles.php'>Retour</a>
         </td>
      </tr>
   </table>
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerModifBenevole')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La modification du b&eacute;n&eacute;vole a &eacute;t&eacute; effectu&eacute;e</center></h5>";
   }
}

?>
