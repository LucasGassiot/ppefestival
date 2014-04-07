<?php

include("_debut.inc.php");

// AFFICHER L'ENSEMBLE DES BENEVOLES
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

echo "
<table width='70%' cellspacing='0' cellpadding='0' align='center' 
class='tabNonQuadrille'>
   <tr class='enTeteTabNonQuad'>
      <td colspan='6'>B&eacute;n&eacute;voles</td>
   </tr>";
     
   $req=obtenirReqBenevoles();
   $rsBene=mysql_query($req, $connexion);
   $lgBene=mysql_fetch_array($rsBene);
   // BOUCLE SUR LES BENEVOLES
   while ($lgBene!=FALSE)
   {
      $id=$lgBene['id'];
      $nom=$lgBene['nom'];
      $prenom=$lgBene['prenom'];
      echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>$nom $prenom</td>
        
         
         
         <td width='16%' align='center'> 
         <a href='detailBenevole.php?id=$id'>
         Voir d&eacute;tail</a></td>
         
         <td width='16%' align='center'> 
         <a href='modificationBenevole.php?action=demanderModifBenevole&amp;id=$id'>
         Modifier</a></td>";
      	
      

         // S'il existe déjà des attributions pour le benevole, il faudra
         // d'abord les supprimer avant de pouvoir supprimer l'établissement
			//if (!existeAttributionsBene($connexion, $id))
			//{
            echo "
            <td width='16%' align='center'> 
            <a href='suppressionBenevole.php?action=demanderSupprBenevole&amp;id=$id'>
            Supprimer</a></td>";
			
			echo "
            <td width='16%' align='center'> 
            <a href='preferenceBenevole.php?action=demanderPreferenceBenevole&amp;id=$id'>
            Preferences</a></td>";
         //}
         //else
         //{
            echo "
            <td width='16%'>&nbsp; </td>";          
			//}
			echo "
      </tr>";
      $lgBene=mysql_fetch_array($rsBene);
   }   
   echo "
   <tr class='ligneTabNonQuad'>
      <td colspan='4'><a href='creationBenevole.php?action=demanderCreBene'>
      Cr&eacute;ation d'un B&eacute;n&eacute;vole</a ></td>
  </tr>
</table>";

?>