<?php

include("_debut.inc.php");

$nbResponsable=nbResponsables($connexion);
   // POUR CHAQUE RESPONSABLE : AFFICHAGE D'UN TABLEAU COMPORTANT 2 LIGNES 
   // D'EN-TÊTE ET LE DÉTAIL DES ATTRIBUTIONS
   $req=obtenirReqResponsablesAttribués();
   $rsResponsables=mysql_query($req, $connexion);
   $lgResponsables=mysql_fetch_array($rsResponsables);
   // BOUCLE SUR LES RESPONSABLES
   while($lgResponsables!=FALSE)
   {
      $idResponsable=$lgResponsables['id'];
      $nomResponsable=$lgResponsables['nom'];
	  $prenomResponsable=$lgResponsables['prenom'];
	  $nbResponsabilite=nbResponsabilite($connexion, $LaDate, $idResponsable);
	if($nbResponsabilite!=0)
	{
      echo "
      <table width='75%' cellspacing='0' cellpadding='0' align='center' 
      class='tabQuadrille'>";
      
      // AFFICHAGE DE LA 1ÈRE LIGNE D'EN-TÊTE 
      echo "
      <tr class='enTeteTabQuad'>
         <td colspan='2' align='left'>Benevole : <strong>$nomResponsable $prenomResponsable</strong>
		 (Responsable de <strong>$nbResponsabilite</strong> groupe(s))</td>
      </tr>";
          
      // AFFICHAGE DE LA 2ÈME LIGNE D'EN-TÊTE 
      echo "
      <tr class='ligneTabQuad'>
         <td colspan ='2' width='65%' align='left'><i><strong>Responsable de :</strong></i></td>
      </tr>";
        
      // AFFICHAGE DU DÉTAIL DES RESPONSABLES : UNE LIGNE PAR GROUPE AFFECTÉ       
      $req=obtenirReqGroupesResponsable($idResponsable, $LaDate);
      $rsGroupe=mysql_query($req, $connexion);
      $lgGroupe=mysql_fetch_array($rsGroupe);
               
      // BOUCLE SUR LES GROUPES (CHAQUE GROUPE EST AFFICHÉ EN LIGNE)
      while($lgGroupe!=FALSE)
      {
         $idGroupe=$lgGroupe['id'];
         $nomGroupe=$lgGroupe['nom'];
		echo "
         <tr class='ligneTabQuad'>
            <td width='65%' align='left'>$nomGroupe</td>";
			echo "
            <td> 
            <a href='suppressionResponsable.php?action=demanderSupprResponsable&amp;id=$idGroupe'>
            Supprimer</a></td>";
         $lgGroupe=mysql_fetch_array($rsGroupe);
      } // Fin de la boucle sur les groupes
      
      echo "
      </table><br>";
	  }
      $lgResponsables=mysql_fetch_array($rsResponsables);
	  
   } // Fin de la boucle sur les responsables

?>