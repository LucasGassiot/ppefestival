<?php

include("_debut.inc.php");


// CR�ER UN BENEVOLE


$action=$_REQUEST['action'];

// S'il s'agit d'une cr�ation et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut d�finir 
// les champs � vide sinon on affichera les valeurs pr�c�demment saisies
if ($action=='demanderCreBene') 
{  
   $id='';
   $nom='';
   $prenom='';
   $anneeNaissance='';
   $anneeDebutBene='';
   $telephone='';
   $mail='';
   $moyenTransp=0;
   
}
else
{
   $id=$_REQUEST['id']; 
   $nom=$_REQUEST['nom']; 
   $prenom=$_REQUEST['prenom'];
   $anneeNaissance=$_REQUEST['anneeNaissance'];
   $anneeDebutBene=$_REQUEST['anneeDebutBene'];
   $telephone=$_REQUEST['telephone'];
   $mail=$_REQUEST['mail'];
   $moyenTransp=$_REQUEST['moyenTransp'];

   verifierDonneesBeneC($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail);  
   if (nbErreurs()==0)
   {        
      creerBenevole($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail, $moyenTransp);
   }
}

echo "
<form method='POST' action='creationBenevole.php?'>
   <input type='hidden' value='validerCreeBene' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>Nouveau B&eacute;n&eacute;vole</td>
      </tr>
      <tr class='ligneTabNonQuad'>
         <td> Id* : </td>
         <td><input type='text' value='$id' name='id' size ='4' 
         maxlength='4'></td>
      </tr>";
     
      echo '
      <tr class="ligneTabNonQuad">
         <td> Nom* : </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="20" 
         maxlength="20"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Pr&eacute;nom* : </td>
         <td><input type="text" value="'.$prenom.'" name="prenom" 
         size="20" maxlength="20"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ann&eacute;e de naissance* : </td>
         <td><input type="year" value="'.$anneeNaissance.'" name="anneeNaissance" 
         size="4" maxlength="4"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Ann&eacute;e de d&eacute;but du b&eacute;n&eacute;volat* : </td>
         <td><input type="year" value="'.$anneeDebutBene.'" name="anneeDebutBene" size="4" 
         maxlength="4"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Telephone* : </td>
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
if ($action=='validerCreeBene')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La cr&eacute;ation du b&eacute;n&eacute;vole a &eacute;t&eacute; effectu&eacute;e</center></h5>";
   }
}

?>