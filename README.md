# Projet Symfony

Ce projet utilise le framework Symfony.
Ce guide vous permettra de démarrer rapidement avec l'installation, la configuration, et l'exécution du projet.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants sur votre machine :

- **PHP** (version >= 8.0)
- **Composer**
- **Symfony CLI**
- **Serveur de base de données** (MySQL)

## Étapes pour démarrer le projet

### 1. Installer les dépendances

```bash
make install-composer-deps
```

### 2. Configurer l'environnement

```bash
cp .env .env.local
```

Modifiez le fichier .env.local pour configurer les paramètres de votre base de données et autres variables d'environnement :

```bash
DATABASE_URL="mysql://root:mot_de_pase@127.0.0.1:3307/nom_de_votre_base_de_donnees"
```

### 3. Préparer la base de données

Si vous n'avez pas encore cloné le projet, commencez par le faire via Git :

```bash
make drop-db
make create-db
make migrate-db
make fixtures
```

### 4. Démarrer le serveur Symfony

```bash
make start
```

### 5. Accéder à l'application

Ouvrez votre navigateur et accédez à l'URL suivante : [http://localhost:8000](http://localhost:8000)

## Commandes utiles

- **Démarrer le serveur Symfony** : `make start`
- **Arrêter le serveur Symfony** : `make stop`
- **Créer une nouvelle migration** : `make migration`
- **Exécuter les migrations** : `make migrate`

## Documentation

- Des utiliseur de test existent déja dans la base de données :

  - **Utilisateur avec des Bookread** : email: `test2@test.test`, mot de passe: `Azerty123`
  - **Utilisateur sans Bookread** : email: `test@test.test`, mot de passe: `Azerty123`

Pour information, les stories 1/2/4/6/7 et 8 sont fonctionnelles.
la stories 3 marche en sélectionnant de nouveaux un livre déja enregistrer (voir BookController::saveBookRead).
la stories 5 implémente bien le systeme de like mais pas de commentaire.