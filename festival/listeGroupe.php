<?php

include("_debut.inc.php");


// AFFICHER L'ENSEMBLE DES GROUPES
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// GROUPE

echo "
<table width='70%' cellspacing='0' cellpadding='0' align='center' 
class='tabNonQuadrille'>
   <tr class='enTeteTabNonQuad'>
      <td colspan='4'>Groupes</td>
   </tr>";
     
   $req=obtenirReqGroupes();
   $rsGroupe=mysql_query($req, $connexion);
   $lgGroupe=mysql_fetch_array($rsGroupe);
   // BOUCLE SUR LES GROUPE
   while ($lgGroupe!=FALSE)
   {
      $id=$lgGroupe['id'];
      $nom=$lgGroupe['nom'];
      echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>$nom</td>
         
        <td width='16%' align='center'> 
         <a href='detailGroupe.php?id=$id'>
         Voir d&eacute;tail</a></td>
         
        <td width='16%' align='center'> 
         <a href='modificationGroupe.php?action=demanderModifGroupe&amp;id=$id'>
         Modifier</a></td>";
      	
		// NE pas oubliez de modifier ça par la suite
		echo "
            <td width='16%' align='center'> 
            <a href='suppressionGroupe.php?action=demanderSupprGroupe&amp;id=$id'>
            Supprimer</a></td>";
         
        echo "
        <td width='16%'>&nbsp; </td>";          
			
		echo "
      </tr>";
      $lgGroupe=mysql_fetch_array($rsGroupe);
   }   
   echo "
   <tr class='ligneTabNonQuad'>
      <td colspan='4'><a href='creationGroupe.php?action=demanderCreGroupe'>
      Cr&eacute;ation d'un groupe</a ></td>
  </tr>
</table>";

?>
