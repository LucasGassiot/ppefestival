<?php

include("_debut.inc.php");

$code=$_REQUEST['code'];  

// OBTENIR LE DÉTAIL DE LA TACHE SÉLECTIONNÉ

$lgTach=obtenirDetailTache($connexion, $code);

$libelle=$lgTach['libelle'];
$lieu=$lgTach['lieu'];
$nbPers=$lgTach['nbPers'];

echo "
<table width='60%' cellspacing='0' cellpadding='0' align='center' 
class='tabNonQuadrille'>
   
   <tr class='enTeteTabNonQuad'>
      <td colspan='3'>$libelle</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td  width='20%'> Code : </td>
      <td>$code</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Lieu : </td>
      <td>$lieu</td>
   </tr>
   <tr class='ligneTabNonQuad'>
      <td> Nombre de personne n&eacute;cessaires : </td>
      <td>$nbPers</td>
   </tr>
</table>
<table align='center'>
   <tr>
      <td align='center'><a href='listeTache.php'>Retour</a>
      </td>
   </tr>
</table>";
?>
