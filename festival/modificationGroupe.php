<?php

include("_debut.inc.php");

// MODIFIER UN GROUPE


$action=$_REQUEST['action'];
$id=$_REQUEST['id'];

// Si on ne "vient" pas de ce formulaire, il faut récupérer les données à partir 
// de la base (en appelant la fonction obtenirDetailGoupe) sinon on 
// affiche les valeurs précédemment contenues dans le formulaire
if ($action=='demanderModifGroupe')
{
   $lgGroupe=obtenirDetailGroupe($connexion, $id);
   
	
   $nom=$lgGroupe['nom']; 
   $lgIdentiteResponsable=BenevoleResponsable($connexion, $LaDate, $id);
   $identiteResponsable=$lgIdentiteResponsable['id'];
   
   // $lgbenevoleInitial=benevoleChoisi($identiteReponsable, $connexion);
   // $nomBenevoleInitial=$lgBenevoleInitial['nom'];
   // $prenomBenevoleInitial=$lgBenevoleInitial['prenom'];
   
   $adressePostale=$lgGroupe['adressePostale'];
   $nombrePersonnes=$lgGroupe['nombrePersonnes'];
   $nomPays=$lgGroupe['nomPays'];
   $contacte=$lgGroupe['contacte'];
   $participant=$lgGroupe['participe'];

}
else
{
   $nom=$_REQUEST['nom']; 
   $identiteResponsable=$_POST['identiteResponsable'];
   $adressePostale=$_REQUEST['adressePostale'];
   $nombrePersonnes=$_REQUEST['nombrePersonnes'];
   $nomPays=$_REQUEST['nomPays'];
   $contacte=$_REQUEST['contacte'];
   $participant=$_REQUEST['participant'];

   verifierDonneesGroupeM($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays);
   if (nbErreurs()==0)
   {        
      modifierGroupe($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays, $contacte, $participant, $LaDate);
   }
}

echo "
<form method='POST' action='modificationGroupe.php?'>
   <input type='hidden' value='validerModifGroupe' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='tabNonQuadrille'>
   
         <tr class='enTeteTabNonQuad'>
         <td colspan='3'>$nom ($id)</td>
      </tr>
      <tr>
         <td><input type='hidden' value='$id' name='id'></td>
      </tr>";
     
      echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="40" 
         maxlength="40"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Identit&eacute; responsable*: </td>
         <td><select name="identiteResponsable">';
		 $req=tousLesBenevoles();
		$rsBenevole=mysql_query($req, $connexion);
		$lgBenevole=mysql_fetch_array($rsBenevole);
		while ($lgBenevole!=FALSE)
		{
			$idBenevole=$lgBenevole['id'];
			$nomBenevole=$lgBenevole['nom'];
			$prenomBenevole=$lgBenevole['prenom'];
			if($identiteResponsable==$idBenevole){
				echo "<option value='".$idBenevole."' selected=selected>".$nomBenevole." ".$prenomBenevole."</option>";
			}
			else{
				echo "<option value='".$idBenevole."'>".$nomBenevole." ".$prenomBenevole."</option>";
			}
			$lgBenevole=mysql_fetch_array($rsBenevole);
		}
		echo '</select></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Adresse postal*: </td>
         <td><input type="text" value="'.$adressePostale.'" name="adressePostale" 
         size="60" maxlength="120"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nombre personnes*: </td>
         <td><input type="text" value="'.$nombrePersonnes.'" name="nombrePersonnes" size="11" 
         maxlength="11"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Nom pays*: </td>
         <td><input type="text" value="'.$nomPays.'" name="nomPays" size ="40" 
         maxlength="40"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Contacter ? </td>
         <td>';
            if ($contacte==1)
            {
               echo " 
               <input type='radio' name='contacte' value='1' checked>  
               Oui
               <input type='radio' name='contacte' value='0'>  Non";
             }
             else
             {
                echo " 
                <input type='radio' name='contacte' value='1'> 
                Oui
                <input type='radio' name='contacte' value='0' checked> Non";
              }
           echo '
           </td>
		</tr>
         <tr class="ligneTabNonQuad">
			<td> Participant ? </td>
			<td>';
            if ($participant==1)
            {
               echo " 
               <input type='radio' name='participant' value='1' checked>  
               Oui
               <input type='radio' name='participant' value='0'>  Non";
             }
             else
             {
                echo " 
                <input type='radio' name='participant' value='1'> 
                Oui
                <input type='radio' name='participant' value='0' checked> Non";
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
         <td colspan='2' align='center'><a href='listeGroupe.php'>Retour</a>
         </td>
      </tr>
   </table>
</form>";

// En cas de validation du formulaire : affichage des erreurs ou du message de 
// confirmation
if ($action=='validerModifGroupe')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La modification du groupe a &eacutet&eacute effectu&eacutee</center></h5>";
   }
}

?>
