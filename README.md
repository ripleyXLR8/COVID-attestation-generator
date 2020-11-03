# Générateur d'attestations COVID
## Introduction
Ce script PHP permet de générer sur une attestation dérogatoire COVID. Le fichier est créé et enregistré sur le serveur dans le même répertoire que le script.
## Installation
1 - Placer l'ensemble des fichiers sur votre serveur Web.

2 - Modifier le fichier index.php pour qu'il corresponde à vos besoins :
  
  Ligne 13 : Choisir le type d'attestation par défaut (si aucun argument n'est passé). ("travail", "achats", "sante", "famille", "handicap", "sport_animaux", "convocation", "missions", "enfants")
  
  Ligne 17 : Choisir le nom l'identité par défaut (si aucun argument n'est passé).
  
  Ligne 33-55 : Modifier les identité à votre guise. Vous pouvez rajouter autant d'identité que vous le souhaitez.
  
## Usage

1) Accéder à l'URL du fichier index.php. Vous pouvez passer en paramètre les variables "name" et "reasons" qui contiendront respectivement l'identité et les raisons.
2) La page web retourne le chemin absolu du fichier généré.
