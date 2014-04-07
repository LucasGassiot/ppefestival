<?php

include("_debut.inc.php");
// CRÉER UN GROUPE 


$action=$_REQUEST['action'];

// S'il s'agit d'une création et qu'on ne "vient" pas de ce formulaire (on 
// "vient" de ce formulaire uniquement s'il y avait une erreur), il faut définir 
// les champs à vide sinon on affichera les valeurs précédemment saisies
if ($action=='demanderCreGroupe') 
{  
   $id='';
   $nom='';
   $identiteResponsable='';
   $adressePostale='';
   $nombrePersonnes='';
   $nomPays='';
   $contacte=0;
   $participant=0;
}
else
{
   $id=$_REQUEST['id']; 
   $nom=$_REQUEST['nom']; 
   $identiteResponsable=$_POST['identiteResponsable'];
   $adressePostale=$_REQUEST['adressePostale'];
   $nombrePersonnes=$_REQUEST['nombrePersonnes'];
   $nomPays=$_REQUEST['nomPays'];
   $contacte=$_REQUEST['contacte'];
   $participant=$_REQUEST['participant'];

   verifierDonneesGroupeC($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                           $nomPays);  
   if (nbErreurs()==0)
   {        
      creerGroupe($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays, $contacte, $participant, $LaDate);
   }
}

echo "
<form method='POST' action='creationGroupe.php?'>
   <input type='hidden' value='validerCreGroupe' name='action'>
   <table width='85%' align='center' cellspacing='0' cellpadding='0' 
   class='tabNonQuadrille'>
   
      <tr class='enTeteTabNonQuad'>
         <td colspan='3'>Nouveau Groupe</td>
      </tr>
      <tr class='ligneTabNonQuad'>
         <td> Id*: </td>
         <td><input type='text' value='$id' name='id' size ='10' 
         maxlength='4'></td>
      </tr>";
     
      echo '
      <tr class="ligneTabNonQuad">
         <td> Nom*: </td>
         <td><input type="text" value="'.$nom.'" name="nom" size="40" 
         maxlength="40"></td>
      </tr>
      <tr class="ligneTabNonQuad">
         <td> Identit&eacute; responsable*: </td>
         <td>
		 <select name="identiteResponsable">';
		 //Permet d'afficher sous forme de liste déroulante tous les benevoles
		 $req=tousLesBenevoles();
		$rsBenevole=mysql_query($req, $connexion);
		$lgBenevole=mysql_fetch_array($rsBenevole);
		while ($lgBenevole!=FALSE)
		{
			$idBenevole=$lgBenevole['id'];
			$nomBenevole=$lgBenevole['nom'];
			$prenomBenevole=$lgBenevole['prenom'];
			echo "<option value='".$idBenevole."'>".$nomBenevole." ".$prenomBenevole."</option>";
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
if ($action=='validerCreGroupe')
{
   if (nbErreurs()!=0)
   {
      afficherErreurs();
   }
   else
   {
      echo "
      <h5><center>La cr&eacuteation du groupe a &eacutet&eacute effectu&eacutee</center></h5>";
	  echo $identiteResponsable;
   }
}

?>
