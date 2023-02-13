# Spy Agency - Evaluation Studi
Créé avec PHP 8.1.4

### Description

Il s'agit du dépôt Github du projet d'évaluation d'entraînement Studi "Agence d'espionnage".

Dans le dossier Annexes de ce dépot se trouvent :

- Le schéma de conception
- Un fichier sql pour création rapide de la base données

---

## Déploiement du projet en local

Ce projet est réalisé avec PHP 8.1.4

### Clonage dépôt Git:
- Rendez-vous sur le dépot GIT fourni

- Copiez le lien https dans le bouton vert "Code"

- Sur votre terminal, dirigez-vous vers votre dossier de travail

- Utilisez la commande git clone et collez le lien

- Sur VSC, ouvrez le dossier de travail et accédez au code


### Installation dépendances:
- Installez les dépendances PHP via la commande : `composer install`


### Base de données:
- Sur votre gestionnaire de bases de données, vous pouvez exécuter les requêtes SQL fourni en annexes pour créer la base de données, puis les tables et enfin insérer les données.

- Dans le fichier .env, à la racine du projet, configurez la LOCAL_DATABASE_URL en ligne 1 pour qu'elle corresponde à vos informations de base de données.

### Lancement du projet:

- Lancez le projet avec la commande : `php -S localhost:8000 -t public/`

---


## Déploiement du projet en ligne

- Le site est actuellement en ligne ici : https://spy-agency-studi.herokuapp.com/


### Deploiement sur Heroku

- Crééz un compte sur heroku.com

- Crééz ensuite une app

- Liez votre dépôt GitHub (créé au préalable)

- Ajoutez la ressource ClearDB MySQL

- Sur votre gestionnaire de bases de données, ajoutez cette nouvelle base de données. Vous trouverez les information d'identification dans les settings sur Heroku au niveau des Config Vars : CLEARDB_DATABASE_URL
mysql://'username':'password'@'host'/'databse'?reconnect=true

- Il ne reste plus qu'à executer les commande GIT habituelles (add, commit et push)