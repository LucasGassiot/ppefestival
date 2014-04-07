<?php

include("_debut.inc.php");

$id=$_REQUEST['id'];
$req=obtenirReqTaches();
$rsTaches=mysql_query($req, $connexion);
$lgTaches=mysql_fetch_array($rsTaches);
echo" <table width='75%' cellspacing='0' cellpadding='0' align='center' 
      class='tabQuadrille'>
		<tr class='enTeteTabQuad'><td>Nom Tache</td><td>Coef</td><td>Validation</td></tr>";

while($lgTaches!=FALSE)
{
	$code=$lgTaches['code'];
	$libelleTache=$lgTaches['libelle'];
	$boo=PreferenceOuNon($connexion, $id, $code);

	
	if($boo){
		$coefActuel=recupCoefPreference($connexion, $id, $code);
		echo"<form method='POST' action='preferenceBenevole.php?'>
		<input type='hidden' value='validerPrefBene' name='action'>"
		;
		echo"<tr class='ligneTabQuad'><td><strong> $libelleTache </strong></td>";
		echo"<td><select name='coefPreference'>";
		for($i=0;$i<=5;$i++){
			if($i==$coefActuel){
			echo "<option value='".$i."' selected='selected'>".$i."</option>";
			}
			else{
			echo "<option value='".$i."'>".$i."</option>";
			}
		}
			
		echo"</select></td>";
		
		
		echo "<td align='right'><input type='submit' value='Valider' name='valider'></tr>";
	
	}
	else{
		echo"<form method='POST' action='preferenceBenevole.php?'>
		<input type='hidden' value='validerCreGroupe' name='action'>";
		echo"<tr class='ligneTabQuad'><td><strong> $libelleTache </strong></td>";
		echo"<td><select name='coefPreference'>";
		for($i=0;$i<=5;$i++){
			echo "<option value='".$i."'>".$i."</option>";
		}
			
		echo"</select></td>";
		
		
		echo "<td align='right'><input type='submit' value='Valider' name='valider'></tr>";
	
	
	
	}






$lgTaches=mysql_fetch_array($rsTaches);
}
echo"</table>";



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
?>