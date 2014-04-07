<?php

// FONCTIONS DE CONTRÔLE DE SAISIE

// Si $codePostal a une longueur de 5 caractères et est de type entier, on 
// considère qu'il s'agit d'un code postal
function estUnCp($codePostal)
{
   // Le code postal doit comporter 5 chiffres
   return strlen($codePostal)== 5 && estEntier($codePostal);
}

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
// la fonction retourne vrai
// function estEntier($valeur)
// {
   // return !preg_match("[^0-9]", $valeur);
// }

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres, 
// la fonction retourne vrai
function estEntier($valeur)
{
   return !preg_match("[^0-9]", $valeur);
}

// Si la valeur transmise ne contient pas d'autres caractères que des chiffres  
// et des lettres non accentuées, la fonction retourne vrai
// function estChiffresOuEtLettres($valeur)
// {
   // return !preg_match("[^a-zA-Z0-9]", $valeur);
// }

function estChiffresOuEtLettres($valeur)
{
   return !preg_match("[^a-zA-Z0-9]", $valeur);
}


// Fonction qui vérifie la saisie lors de la modification d'un établissement. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesEtabM($connexion, $id, $nom, $adresseRue, $codePostal, 
                              $ville, $tel, $nomResponsable, $nombreChambresOffertes)
{
   if ($nom=="" || $adresseRue=="" || $codePostal=="" || $ville=="" || 
       $tel=="" || $nomResponsable=="" || $nombreChambresOffertes=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if ($nom!="" && estUnNomEtablissement($connexion, 'M', $id, $nom))
   {
      ajouterErreur("L'établissement $nom existe déjà");
   }
   if ($codePostal!="" && !estUnCp($codePostal))
   {
      ajouterErreur("Le code postal doit comporter 5 chiffres");   
   }
   if ($nombreChambresOffertes!="" && (!estEntier($nombreChambresOffertes) ||
       !estModifOffreCorrecte($connexion, $id, $nombreChambresOffertes)))
   {
      ajouterErreur
      ("La valeur de l'offre est non entière ou inférieure aux attributions effectuées");
   }
}

// Fonction qui vérifie la saisie lors de la création d'un établissement. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesEtabC($connexion, $id, $nom, $adresseRue, $codePostal, 
                              $ville, $tel, $nomResponsable, $nombreChambresOffertes)
{
   if ($id=="" || $nom=="" || $adresseRue=="" || $codePostal=="" || $ville==""
       || $tel=="" || $nomResponsable=="" || $nombreChambresOffertes=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if($id!="")
   {
      // Si l'id est constitué d'autres caractères que de lettres non accentuées 
      // et de chiffres, une erreur est générée
      if (!estChiffresOuEtLettres($id))
      {
         ajouterErreur
         ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
      }
      else
      {
         if (estUnIdEtablissement($connexion, $id))
         {
            ajouterErreur("L'établissement $id existe déjà");
         }
      }
   }
   if ($nom!="" && estUnNomEtablissement($connexion, 'C', $id, $nom))
   {
      ajouterErreur("L'établissement $nom existe déjà");
   }
   if ($codePostal!="" && !estUnCp($codePostal))
   {
      ajouterErreur("Le code postal doit comporter 5 chiffres");   
   }
   if ($nombreChambresOffertes!="" && !estEntier($nombreChambresOffertes)) 
   {
      ajouterErreur ("La valeur de l'offre doit être un entier");
   }
}

// FONCTIONS DE GESTION DES ERREURS

function ajouterErreur($msg)
{
   if (! isset($_REQUEST['erreurs']))
      $_REQUEST['erreurs']=array();
   $_REQUEST['erreurs'][]=$msg;
}

function nbErreurs()
{
   if (!isset($_REQUEST['erreurs']))
   {
	   return 0;
	}
	else
	{
	   return count($_REQUEST['erreurs']);
	}
}
 
function afficherErreurs()
{
   echo '<div class="msgErreur">';
   echo '<ul>';
   foreach($_REQUEST['erreurs'] as $erreur)
	{
      echo "<li>$erreur</li>";
	}
   echo '</ul>';
   echo '</div>';
} 


// Fonction qui vérifie la saisie lors de la création d'un groupe. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesGroupeC($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays)
{
   if ($id=="" || $nom=="" || $identiteResponsable=="" || $adressePostale=="" || $nombrePersonnes==""
       || $nomPays=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if($id!="")
   {
      // Si l'id est constitué d'autres caractères que de lettres non accentuées 
      // et de chiffres, une erreur est générée
      if (!estChiffresOuEtLettres($id))
      {
         ajouterErreur
         ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
      }
      else
      {
         if (estUnIdGroupe($connexion, $id))
         {
            ajouterErreur("Le groupe $id existe déjà");
         }
      }
   }
   if ($nom!="" && estUnNomGroupe($connexion, 'C', $id, $nom))
   {
      ajouterErreur("Le groupe $nom existe déjà");
   }
   if ($nombrePersonnes!="" && !estEntier($nombrePersonnes)) 
   {
      ajouterErreur ("Le nombre de personnes doit être un entier");
   }
}

// Fonction qui vérifie la saisie lors de la modification d'un groupe. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesGroupeM($connexion, $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, 
                            $nomPays)
{
   if ($nom=="" || $identiteResponsable=="" || $adressePostale=="" || $nombrePersonnes==""
       || $nomPays=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if ($nom!="" && estUnNomGroupe($connexion, 'M', $id, $nom))
   {
      ajouterErreur("Le groupe $nom existe déjà");
   }
   if ($nombrePersonnes!="" && !estEntier($nombrePersonnes)) 
   {
      ajouterErreur ("Le nombre de personnes doit être un entier");
   }
}

// Fonction qui vérifie la saisie lors de la modification d'une tache. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesTachM($connexion, $code, $libelle, $lieu, $nbPers)
{
   if ($libelle=="" || $lieu=="" || $nbPers=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if ($nbPers!="" && !estEntier($nbPers))
   {
      ajouterErreur("Le nombre de personnes doit être un entier");   
   }

}

// Fonction qui vérifie la saisie lors de la création d'une tache. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesTachC($connexion, $code, $libelle, $lieu, $nbPers)
{
   if ($code=="" || $libelle=="" || $lieu=="" || $nbPers=="")
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if($code!="")
   {
      // Si le code est constitué d'autres caractères que de lettres non accentuées 
      // et de chiffres, une erreur est générée
      if (!estChiffresOuEtLettres($code))
      {
         ajouterErreur
         ("Le code doit comporter uniquement des lettres non accentuées et des chiffres");
      }
      else
      {
         if (estUnCodeTache($connexion, $code))
         {
            ajouterErreur("La tache $code existe déjà");
         }
      }
   }
   if ($libelle!="" && estUnLibelleTach($connexion, 'C', $code, $libelle))
   {
      ajouterErreur("La tache $libelle existe déjà");
   }
   if ($nbPers!="" && !estEntier($nbPers)) 
   {
      ajouterErreur ("Le nombre de personnes necessaires doit etre un nombre entier");
   }
}
// Fonction qui vérifie la saisie lors de la création d'un benevole. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesBeneC($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail)
{
   if ($id=="" || $nom=="" || $prenom=="" || $anneeNaissance=="" || $anneeDebutBene==""
       || $telephone=="" || $mail=="" )
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if($id!="")
   {
      // Si l'id est constitué d'autres caractères que de lettres non accentuées 
      // et de chiffres, une erreur est générée
      if (!estChiffresOuEtLettres($id))
      {
         ajouterErreur
         ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
      }
      else
      {
         if (estUnIdBene($connexion, $id))
         {
            ajouterErreur("Le b&eacute;n&eacute;vole $id existe d&eacute;jà");
         }
      }
   }
}

// Fonction qui vérifie la saisie lors de la modification d'un benevole. 
// Pour chaque champ non valide, un message est ajouté à la liste des erreurs
function verifierDonneesBenevoleM($connexion, $id, $nom, $prenom, $anneeNaissance, $anneeDebutBene, $telephone, $mail)
{
   if ($id=="" || $nom=="" || $prenom=="" || $anneeNaissance=="" || $anneeDebutBene==""
       || $telephone=="" || $mail=="" )
   {
      ajouterErreur("Chaque champ suivi du caractère * est obligatoire");
   }
   if ($nom!="" && estUnNomBenevole($connexion, 'M', $id, $nom))
   {
      ajouterErreur("Le b&eacute;n&eacute;vole $nom existe d&eacute;jà");
   }
}


?>
