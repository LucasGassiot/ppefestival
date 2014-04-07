<?php

// FONCTIONS DE CONNEXION

// function connect()
// {
   // $hote="localhost";
   // $login="festival";
   // $mdp="secret";
   // return mysql_connect($hote, $login, $mdp);
// }

function connect()
{
   $hote="localhost";
   $login="root";
   $mdp="";
   return mysql_connect($hote, $login, $mdp);
}

function selectBase($connexion)
{
   $bd="festival";
   $query="SET CHARACTER SET utf8";
   // Modification du jeu de caractères de la connexion
   $res=mysql_query($query, $connexion); 
   $ok=mysql_select_db($bd, $connexion);
   return $ok;
}

// FONCTIONS DE GESTION DES ÉTABLISSEMENTS

function obtenirReqEtablissements()
{
   $req="select id, nom from Etablissement order by id";
   return $req;
}

function obtenirReqEtablissementsOffrantChambres()
{
   $req="select id, nom, nombreChambresOffertes from Etablissement where 
         nombreChambresOffertes!=0 order by id";
   return $req;
}

function obtenirReqEtablissementsAyantChambresAttribuées()
{
   $req="select distinct id, nom, nombreChambresOffertes from Etablissement, 
         Attribution where id = idEtab order by id";
   return $req;
}

function obtenirDetailEtablissement($connexion, $id)
{
   $req="select * from Etablissement where id='$id'";
   $rsEtab=mysql_query($req, $connexion);
   return mysql_fetch_array($rsEtab);
}

function supprimerEtablissement($connexion, $id)
{
   $req="delete from Etablissement where id='$id'";
   mysql_query($req, $connexion);
}
 
function modifierEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                               $ville, $tel, $adresseElectronique, $type, 
                               $civiliteResponsable, $nomResponsable, 
                               $prenomResponsable, $nombreChambresOffertes)
{  
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
  
   $req="update Etablissement set nom='$nom',adresseRue='$adresseRue',
         codePostal='$codePostal',ville='$ville',tel='$tel',
         adresseElectronique='$adresseElectronique',type='$type',
         civiliteResponsable='$civiliteResponsable',nomResponsable=
         '$nomResponsable',prenomResponsable='$prenomResponsable',
         nombreChambresOffertes='$nombreChambresOffertes' where id='$id'";
   
   mysql_query($req, $connexion);
}

function creerEtablissement($connexion, $id, $nom, $adresseRue, $codePostal, 
                            $ville, $tel, $adresseElectronique, $type, 
                            $civiliteResponsable, $nomResponsable, 
                            $prenomResponsable, $nombreChambresOffertes)
{ 
   $nom=str_replace("'", "''", $nom);
   $adresseRue=str_replace("'","''", $adresseRue);
   $ville=str_replace("'","''", $ville);
   $adresseElectronique=str_replace("'","''", $adresseElectronique);
   $nomResponsable=str_replace("'","''", $nomResponsable);
   $prenomResponsable=str_replace("'","''", $prenomResponsable);
   
   $req="insert into Etablissement values ('$id', '$nom', '$adresseRue', 
         '$codePostal', '$ville', '$tel', '$adresseElectronique', '$type', 
         '$civiliteResponsable', '$nomResponsable', '$prenomResponsable',
         '$nombreChambresOffertes')";
   
   mysql_query($req, $connexion);
}


function estUnIdEtablissement($connexion, $id)
{
   $req="select * from Etablissement where id='$id'";
   $rsEtab=mysql_query($req, $connexion);
   return mysql_fetch_array($rsEtab);
}

function estUnNomEtablissement($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre établissement (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="select * from Etablissement where nom='$nom'";
   }
   else
   {
      $req="select * from Etablissement where nom='$nom' and id!='$id'";
   }
   $rsEtab=mysql_query($req, $connexion);
   return mysql_fetch_array($rsEtab);
}

function obtenirNbEtab($connexion)
{
   $req="select count(*) as nombreEtab from Etablissement";
   $rsEtab=mysql_query($req, $connexion);
   $lgEtab=mysql_fetch_array($rsEtab);
   return $lgEtab["nombreEtab"];
}

function obtenirNbEtabOffrantChambres($connexion)
{
   $req="select count(*) as nombreEtabOffrantChambres from Etablissement where 
         nombreChambresOffertes!=0";
   $rsEtabOffrantChambres=mysql_query($req, $connexion);
   $lgEtabOffrantChambres=mysql_fetch_array($rsEtabOffrantChambres);
   return $lgEtabOffrantChambres["nombreEtabOffrantChambres"];
}

// Retourne false si le nombre de chambres transmis est inférieur au nombre de 
// chambres occupées pour l'établissement transmis 
// Retourne true dans le cas contraire
function estModifOffreCorrecte($connexion, $idEtab, $nombreChambres)
{
   $nbOccup=obtenirNbOccup($connexion, $idEtab);
   return ($nombreChambres>=$nbOccup);
}

// FONCTIONS RELATIVES AUX GROUPES

function obtenirReqIdNomGroupesAHeberger()
{
   $req="select id, nom from groupe order by id";
   return $req;
}

function obtenirNomGroupe($connexion, $id)
{
   $req="select nom from Groupe where id='$id'";
   $rsGroupe=mysql_query($req, $connexion);
   $lgGroupe=mysql_fetch_array($rsGroupe);
   return $lgGroupe["nom"];
}

// FONCTIONS RELATIVES AUX ATTRIBUTIONS

// Teste la présence d'attributions pour l'établissement transmis    
function existeAttributionsEtab($connexion, $id)
{
   $req="select * From Attribution where idEtab='$id'";
   $rsAttrib=mysql_query($req, $connexion);
   return mysql_fetch_array($rsAttrib);
}

// Retourne le nombre de chambres occupées pour l'id étab transmis
function obtenirNbOccup($connexion, $idEtab)
{
   $req="select IFNULL(sum(nombreChambres), 0) as totalChambresOccup from
        Attribution where idEtab='$idEtab'";
   $rsOccup=mysql_query($req, $connexion);
   $lgOccup=mysql_fetch_array($rsOccup);
   return $lgOccup["totalChambresOccup"];
}

// Met à jour (suppression, modification ou ajout) l'attribution correspondant à
// l'id étab et à l'id groupe transmis
function modifierAttribChamb($connexion, $idEtab, $idGroupe, $nbChambres)
{
   $req="select count(*) as nombreAttribGroupe from Attribution where idEtab=
        '$idEtab' and idGroupe='$idGroupe'";
   $rsAttrib=mysql_query($req, $connexion);
   $lgAttrib=mysql_fetch_array($rsAttrib);
   if ($nbChambres==0)
      $req="delete from Attribution where idEtab='$idEtab' and idGroupe='$idGroupe'";
   else
   {
      if ($lgAttrib["nombreAttribGroupe"]!=0)
         $req="update Attribution set nombreChambres=$nbChambres where idEtab=
              '$idEtab' and idGroupe='$idGroupe'";
      else
         $req="insert into Attribution values('$idEtab','$idGroupe', $nbChambres)";
   }
   mysql_query($req, $connexion);
}

// Retourne la requête permettant d'obtenir les id et noms des groupes affectés
// dans l'établissement transmis
function obtenirReqGroupesEtab($id)
{
   $req="select distinct id, nom from Groupe, Attribution where 
        Attribution.idGroupe=Groupe.id and idEtab='$id'";
   return $req;
}
            
// Retourne le nombre de chambres occupées par le groupe transmis pour l'id étab
// et l'id groupe transmis
function obtenirNbOccupGroupe($connexion, $idEtab, $idGroupe, $annee)
{
   $req="select nombreChambres From Attribution where idEtab='$idEtab'
        and idGroupe='$idGroupe' and annee='$annee'";
   $rsAttribGroupe=mysql_query($req, $connexion);
   if ($lgAttribGroupe=mysql_fetch_array($rsAttribGroupe))
      return $lgAttribGroupe["nombreChambres"];
   else
      return 0;
}

// Function de gestion des groupes

function obtenirReqGroupes()
{
   $req="select id, nom from groupe order by id";
   $req="select id, nom from groupe order by id";
   return $req;
}
//Permet de créer le groupe
//Ainsi que d'associer le responsable au groupe pour une année donnée
function creerGroupe($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays, $contacte, $participant, $date)
{ 
   $nom=str_replace("'", "''", $nom);
   $identiteResponsable=str_replace("'","''", $identiteResponsable);
   $adressePostale=str_replace("'","''", $adressePostale);
   $nomPays=str_replace("'","''", $nomPays);
   
   $req="insert into groupe values ('$id', '$nom', '$adressePostale', '$nombrePersonnes', '$nomPays')";
   mysql_query($req, $connexion);
   $req="insert into contacter values ('$date', '$id', '$contacte', '$participant')";
   mysql_query($req, $connexion);
   $req2="insert into responsable values('$date', '$id', '$identiteResponsable')";
   mysql_query($req2, $connexion);
}

//Permet d'obtenir les détail d'un groupe par rapport à son id
function obtenirDetailGroupe($connexion, $id)
{
   $req="select groupe.*, contacter.contacte, contacter.participe from groupe, contacter where groupe.id=contacter.id and groupe.id='$id'";
   $rsGroupe=mysql_query($req, $connexion);
   return mysql_fetch_array($rsGroupe);
}

//Permet de modifier le groupe
//Ainsi que de modifier l'assocation du responsable au groupe pour une année donnée
function modifierGroupe($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays, $contacte, $participant, $date)
{  
   $nom=str_replace("'", "''", $nom);
   $identiteResponsable=str_replace("'","''", $identiteResponsable);
   $adressePostale=str_replace("'","''", $adressePostale);
   $nomPays=str_replace("'","''", $nomPays);
  
   $req="update groupe set nom='$nom',adressePostale='$adressePostale',nombrePersonnes='$nombrePersonnes',
		nomPays='$nomPays',contacte='$contacte',participant='$participant' where id='$id' and annee='$date'";
   
   $req="update contacter set contacte='$contacte', participe='$participant' where id='$id' and annee='$date'";
   mysql_query($req, $connexion);
   $req2="update responsable set idBenevole='$identiteResponsable' where annee=$date and idGroupe='$id' and annee='$date'";
   mysql_query($req2, $connexion);
   try{
   $req3="insert into responsable values('$date', '$id', '$identiteResponsable')";
   mysql_query($req3, $connexion);
   }
   catch(mysql_error $e){
	
   }
}

//Supprime dans un premier temps les occurrences contenant le groupe dans responsable
//Pour ensuite supprimer le groupe
function supprimerGroupe($connexion, $id)
{	
	$req="delete from contacter where idGroupe='$id'";
	mysql_query($req, $connexion);
	$req="delete from responsable where idGroupe='$id'";
	mysql_query($req, $connexion);
	$req2="delete from groupe where id='$id'";
	mysql_query($req2, $connexion);
}

function estUnIdGroupe($connexion, $id)
{
   $req="select * from Groupe where id='$id'";
   $rsGroupe=mysql_query($req, $connexion);
   return mysql_fetch_array($rsGroupe);
}

function estUnNomGroupe($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre groupe (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="select * from groupe where nom='$nom'";
   }
   else
   {
      $req="select * from groupe where nom='$nom' and id!='$id'";
   }
   $rsGroupe=mysql_query($req, $connexion);
   return mysql_fetch_array($rsGroupe);
}

//Permet d'obtenir une requete rassemblant toutes les annees du festival
function obtenirReqAnnee(){
	$req="Select * from festival";
	return $req;
}

//Permet de récuperer l'année la plus récente présente dans la BDD
function derniereAnnee($connexion){
	$req="Select max(annee) as maximum from festival";
	$rsAnnee=mysql_query($req, $connexion);
	$annee= mysql_fetch_array($rsAnnee);
	return $annee['maximum'];
	
}

//Permet de récuperer le thème du festival par rapport à une année donnée
function themeChoisi($connexion, $annee){
	$req="Select theme from festival where annee=".$annee;
	$rsTheme=mysql_query($req, $connexion);
	return mysql_fetch_array($rsTheme);
}

//Permet de récuperer l'id, le nom et le prenom du responsable d'un groupe donné, sur une année donnée
function benevoleResponsable($connexion, $annee, $idGroupe){
	$req="Select benevole.id, benevole.nom, benevole.prenom from benevole, responsable where 
	responsable.annee=".$annee." and responsable.idGroupe='".$idGroupe."'
	and benevole.id=responsable.idBenevole";
	$rsBeneRespon=mysql_query($req, $connexion);
	return mysql_fetch_array($rsBeneRespon);
}

//Permet de récuperer le nom d'un établissement hebergeant un groupe donné, sur une année donnée
function etablissementHebergeant($connexion, $annee, $idGroupe){
	$req="Select etablissement.nom from etablissement, attribution where attribution.annee=".$annee."
	and attribution.idGroupe='".$idGroupe."' and etablissement.id=attribution.idEtab";
	return mysql_query($req, $connexion);
}

//Permet d'obtenir une requete rassemblant toutes les benevoles
function tousLesBenevoles(){
	$req="Select id, nom, prenom from benevole";
	return $req;
}

function tousLesReponsables(){
	$req="Select * from responsable";
	return $req;
}
function obtenirReqResponsablesAttribués(){
	$req="Select distinct id, nom, prenom from benevole, responsable where id=idBenevole";
	return $req;
}

function nbResponsables($connexion){
	$req="Select count(*) as NbResponsable from responsable";
	$rsNbRespon=mysql_query($req, $connexion);
	$NbRespon=mysql_fetch_array($rsNbRespon);
	return $NbRespon['NbResponsable'];
}

function nbResponsabilite($connexion, $annee, $id){
	$req="Select count(*) as NbResponsabilite from responsable where annee=$annee and idBenevole='$id'";
	$rsNbResponsabilite=mysql_query($req, $connexion);
	$nbResponsabilite=mysql_fetch_array($rsNbResponsabilite);
	return $nbResponsabilite['NbResponsabilite'];
}

function Responsabilite($connexion, $annee, $idGroupe){
	$req="Select benevole.nom as nomBene, benevole.prenom as prenomBene, groupe.nom as nomGroupe from benevole, responsable, groupe where 
	responsable.annee=$annee and responsable.idGroupe='$idGroupe' and benevole.id=responsable.idBenevole
	and groupe.id=responsable.idGroupe";
	$rsRespon=mysql_query($req, $connexion);
	return mysql_fetch_array($rsRespon);
}

function supprimerResponsable($connexion, $id, $annee){
   $req="delete from responsable where idGroupe='$id' and annee=$annee";
   mysql_query($req, $connexion);

}

function obtenirReqGroupesResponsable($id, $annee)
{
   $req="select distinct id, nom from groupe, responsable where 
        idGroupe=groupe.id and idBenevole='$id' and annee=$annee";
   return $req;
}
function obtenirDetailResponsable($connexion, $id, $annee)
{
   $req="select * from responsable where id='$id' and annee=$annee";
   $rsResponsable=mysql_query($req, $connexion);
   return mysql_fetch_array($rsResponsable);
}

// FONCTIONS DE GESTION DES TACHESS

function obtenirReqTaches()
{
   $req="select code, libelle from tache order by code";
   return $req;
}

function obtenirDetailTache($connexion, $code)
{
   $req="select * from tache where code='$code'";
   $rsTach=mysql_query($req, $connexion);
   return mysql_fetch_array($rsTach);
}

function supprimerTache($connexion, $code)
{
   $req="delete from tache where code='$code'";
   mysql_query($req, $connexion);
}
 
function modifierTache($connexion, $code, $libelle, $lieu, 
                               $nbPers)
{  
   $libelle=str_replace("'", "''", $libelle);
   $lieu=str_replace("'","''", $lieu);
   
   $req="update Tache set libelle='$libelle',lieu='$lieu',
         nbPers='$nbPers' where code='$code'";
   
   mysql_query($req, $connexion);
}

function creerTache($connexion, $code, $libelle, $lieu, $nbPers)
{ 
   $libelle=str_replace("'", "''", $libelle);
   $lieu=str_replace("'","''", $lieu);
   
   $req="insert into tache values ('$code', '$libelle', '$lieu', 
         '$nbPers')";
   
   mysql_query($req, $connexion);
}


function estUnCodeTache($connexion, $code)
{
   $req="select * from tache where code='$code'";
   $rsTach=mysql_query($req, $connexion);
   return mysql_fetch_array($rsTach);
}

function estUnLibelleTach($connexion, $mode, $code, $libelle)
{
   $libelle=str_replace("'", "''", $libelle);
   // S'il s'agit d'une création, on vérifie juste la non existence du libelle sinon
   // on vérifie la non existence d'une autre tache (code!='$code') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="select * from tache where libelle='$libelle'";
   }
   else
   {
      $req="select * from tache where libelle='$libelle' and code!='$code'";
   }
   $rsTach=mysql_query($req, $connexion);
   return mysql_fetch_array($rsTach);
}

function obtenirNbTach($connexion)
{
   $req="select count(*) as nombreTach from tache";
   $rsTach=mysql_query($req, $connexion);
   $lgTach=mysql_fetch_array($rsTach);
   return $lgTach["nombreTach"];
}

// FONCTIONS DE GESTION DES BENEVOLES

function obtenirReqBenevoles()
{
   $req="select id, nom, prenom from benevole order by id";
   return $req;
}

function creerBenevole($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail, $moyenTransp)
{ 
   $nom=str_replace("'", "''", $nom);
   $prenom=str_replace("'","''", $prenom);
   $telephone=str_replace("'","''", $telephone);
   $mail=str_replace("'","''", $mail);
   
   $req="INSERT INTO benevole VALUES ('$id', '$nom', '$prenom', '$anneeNaissance', '$anneeDebutBene', '$telephone', '$mail', '$moyenTransp')";
   
   mysql_query($req, $connexion);
}

function estUnIdBene($connexion, $id)
{
   $req="SELECT * FROM benevole WHERE id='$id'";
   $rsBene=mysql_query($req, $connexion);
   return mysql_fetch_array($rsBene);
}

function obtenirDetailBenevole($connexion, $id)
{
   $req="SELECT * FROM benevole WHERE id='$id'";
   $rsBenevole=mysql_query($req, $connexion);
   return mysql_fetch_array($rsBenevole);
}

function modifierBenevole($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail, $moyenTransp)
{  
   $nom=str_replace("'", "''", $nom);
   $prenom=str_replace("'","''", $prenom);
   $telephone=str_replace("'","''", $telephone);
   $mail=str_replace("'","''", $mail);
  
   $req="UPDATE benevole SET nom='$nom',prenom='$prenom',
         anneeNaissance='$anneeNaissance',anneeDebutBene='$anneeDebutBene',telephone='$telephone',mail='$mail',moyenTransp='$moyenTransp' WHERE id='$id'";
    mysql_query($req, $connexion);
}

function estUnNomBenevole($connexion, $mode, $id, $nom)
{
   $nom=str_replace("'", "''", $nom);
   // S'il s'agit d'une création, on vérifie juste la non existence du nom sinon
   // on vérifie la non existence d'un autre benevole (id!='$id') portant 
   // le même nom
   if ($mode=='C')
   {
      $req="SELECT * FROM benevole WHERE nom='$nom'";
   }
   else
   {
      $req="SELECT * FROM benevole WHERE nom='$nom' AND id!='$id'";
   }
   $rsBenevole=mysql_query($req, $connexion);
   return mysql_fetch_array($rsBenevole);
}

function supprimerBenevole($connexion, $id)
{
   $req="DELETE FROM benevole WHERE id='$id'";
   mysql_query($req, $connexion);
}

function PreferenceOuNon($connexion, $id, $code)
{
	$req="Select count(*) as nbPreference from preferer where id='$id' and code='$code'";
	$rsPreference=mysql_query($req, $connexion);
	$lgPreference=mysql_fetch_array($rsPreference);
	if($lgPreference['nbPreference']==0){
		$boo=false;
	}
	else{
		$boo=true;
	}
	return $boo;
}

function recupCoefPreference($connexion, $id, $code)
{
	$req="Select coef from preferer where id='$id' and code='$code'";
	$rsPreference=mysql_query($req, $connexion);
	$lgPreference=mysql_fetch_array($rsPreference);
	return $lgPreference['coef'];
}


?>

