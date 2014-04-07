<?php

include("_debut.inc.php");


// AFFICHER L'ENSEMBLE DES TACHES
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// TACHE

echo "
<table width='70%' cellspacing='0' cellpadding='0' align='center' 
class='tabNonQuadrille'>
   <tr class='enTeteTabNonQuad'>
      <td colspan='4'>Taches</td>
   </tr>";
     
   $req=obtenirReqTaches();
   $rsTach=mysql_query($req, $connexion);
   $lgTach=mysql_fetch_array($rsTach);
   // BOUCLE SUR LES TACHES
   while ($lgTach!=FALSE)
   {
      $code=$lgTach['code'];
      $libelle=$lgTach['libelle'];
      echo "
		<tr class='ligneTabNonQuad'>
         <td width='52%'>$libelle</td>
         
         <td width='16%' align='center'> 
         <a href='detailTaches.php?code=$code'>
         Voir d&eacute;tail</a></td>
         
         <td width='16%' align='center'> 
         <a href='modificationTache.php?action=demanderModifTache&amp;code=$code'>
         Modifier</a></td>";
      	
         // S'il existe déjà des attributions pour la tâche, il faudra
         // d'abord les supprimer avant de pouvoir supprimer la tâche
			// if (!existeEffectuerTach($connexion, $code))
			// {
            echo "
            <td width='16%' align='center'> 
            <a href='suppressionTache.php?action=demanderSupprTach&amp;code=$code'>
            Supprimer</a></td>";
         // }
         // else
         // {
            // echo "
            // <td width='16%'>&nbsp; </td>";          
			// }
			echo "
      </tr>";
      $lgTach=mysql_fetch_array($rsTach);
   }   
   echo "
   <tr class='ligneTabNonQuad'>
      <td colspan='4'><a href='creationTache.php?action=demanderCreTach'>
      Creation d'une Tache</a></td>
  </tr>
</table>";

?>
