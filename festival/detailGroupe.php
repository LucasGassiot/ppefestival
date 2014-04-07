<?php

include("_debut.inc.php");


$id=$_REQUEST['id'];  

// OBTENIR LE DÉTAIL DU GROUPE SÉLECTIONNÉ

$lgGroupe=obtenirDetailGroupe($connexion, $id);
  
$id=$lgGroupe['id']; 
$nom=$lgGroupe['nom']; 
// $identiteResponsable=$lgGroupe['identiteResponsable'];
$Responsable=benevoleResponsable($connexion, $LaDate, $id);
$nomResponsable=$Responsable['nom'];
$prenomResponsable=$Responsable['prenom'];
$adressePostale=$lgGroupe['adressePostale'];
$nombrePersonnes=$lgGroupe['nombrePersonnes'];
$nomPays=$lgGroupe['nomPays'];
$contacte=$lgGroupe['contacte'];
$participant=$lgGroupe['participe'];
echo'
	<table width="85%" align="center" cellspacing="0" cellpadding="0" 
   class="tabNonQuadrille">
   
      <tr class="enTeteTabNonQuad">
         <td colspan="3">'.$nom.'</td>
      </tr>
	<tr class="ligneTabNonQuad">
      <td> Id: </td>
      <td>'.$id.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Nom: </td>
      <td>'.$nom.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Identit&eacute; Responsable: </td>
	  <td>'.$nomResponsable.' '.$prenomResponsable.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Adresse Postale: </td>
      <td>'.$adressePostale.'</td>
	</tr>
	<tr class="ligneTabNonQuad">
      <td> Nombre Personnes: </td>
      <td>'.$nombrePersonnes.'</td>
	</tr>
    <tr class="ligneTabNonQuad">
      <td> Nom Pays: </td>
      <td>'.$nomPays.'</td>
	</tr>
    <tr class="ligneTabNonQuad">
      <td> Contacter ? </td>
      <td>';
            if ($contacte==true)
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
    <tr class="ligneTabNonQuad">
	<td> Participant ? </td>
	<td>';
            if ($participant==true)
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

?>
