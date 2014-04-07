<?php

include("_debut.inc.php");


$id=$_REQUEST['id'];  

// OBTENIR LE DÉTAIL DU BENEVOLE SÉLECTIONNÉ

   $lgBenevole=obtenirDetailBenevole($connexion, $id);
	
   $nom=$lgBenevole['nom']; 
   $prenom=$lgBenevole['prenom'];
   $anneeNaissance=$lgBenevole['anneeNaissance'];
   $anneeDebutBene=$lgBenevole['anneeDebutBene'];
   $telephone=$lgBenevole['telephone'];
   $mail=$lgBenevole['mail'];
   $moyenTransp=$lgBenevole['moyenTransp'];
echo'
	<table width="85%" align="center" cellspacing="0" cellpadding="0" 
   class="tabNonQuadrille">
   
      <tr class="enTeteTabNonQuad">
         <td colspan="3">'."B&eacute;n&eacute;vole : ".$nom." ".$prenom.'</td>
      </tr>
	<tr class="ligneTabNonQuad">
      <td> Id : </td>
      <td>'.$id.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Nom : </td>
      <td>'.$nom.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Prenom : </td>
      <td>'.$prenom.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Ann&eacute;e de naissance : </td>
      <td>'.$anneeNaissance.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Ann&eacute;e de d&eacute;but de b&eacute;n&eacute;vola : </td>
      <td>'.$anneeDebutBene.'</td>
	</tr>
    <tr class="ligneTabNonQuad">
      <td> Telephone : </td>
      <td>'.$telephone.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Mail : </td>
      <td>'.$mail.'</td>
	</tr>
    <tr class="ligneTabNonQuad">
      <td> Moyen de transport ?  </td>
      <td>';
            if ($moyenTransp==1)
            {
               echo "Oui";
             }
             else
             {
                echo "Non";
              }
           echo '
      </td>
	</tr>
</table>';
           
echo"<table align='center' cellspacing='15' cellpadding='0'>
      <tr>
         <td colspan='2' align='center'><a href='listeBenevoles.php'>Retour</a>
         </td>
      </tr>
</table>";

?>
