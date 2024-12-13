
# API de gestion des Posts et Commentaires

Cette API permet de gérer des **posts** et des **commentaires** associés à chaque post. Le projet utilise **Laravel Breeze** pour l'authentification et **Sanctum** pour l'authentification via tokens. Cette API expose des ressources pour effectuer des actions CRUD sur les posts et les commentaires.

## Table des matières

- [Prérequis](#prérequis)
- [Installation](#installation)
- [Démarrer le projet](#démarrer-le-projet)
- [Routes API](#routes-api)
- [Tester l'API avec Postman](#tester-lapi-avec-postman)

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- PHP >= 8.1
- Composer
- MySQL ou une autre base de données configurée dans `.env`
- Node.js (si vous utilisez Laravel Breeze pour les assets front-end)

## Installation

### 1. Cloner le dépôt

Clonez ce dépôt sur votre machine locale :

```bash
git clone https://votre-url-de-dépôt.git
cd votre-dossier
```

### 2. Installer les dépendances PHP

Installez les dépendances avec Composer :

```bash
composer install
```

### 3. Configurer le fichier `.env`

Copiez le fichier `.env.example` en `.env` et configurez les informations de votre base de données et l'URL de l'application :

```bash
cp .env.example .env
```

Puis, dans le fichier `.env`, configurez les informations de votre base de données (exemple pour MySQL) :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nom_de_votre_base_de_donnees
DB_USERNAME=utilisateur
DB_PASSWORD=mot_de_passe
```

### 4. Générer la clé d'application

Générez la clé d'application Laravel :

```bash
php artisan key:generate
```

### 5. Exécuter les migrations

Exécutez les migrations pour créer les tables nécessaires dans la base de données :

```bash
php artisan migrate
```

### 6. Installer Laravel Breeze (si non installé)

Si Laravel Breeze n'est pas encore installé, exécutez ces commandes pour configurer l'authentification API avec la version Bootstrap :

```bash
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
php artisan migrate
```

Cela configure l'authentification avec **Sanctum** et **Bootstrap**.

### 7. (Optionnel) Ajouter des données de test avec seeding

Pour ajouter des données de test dans la base de données, exécutez la commande suivante :

```bash
php artisan db:seed
```

Cela remplira votre base de données avec des données par défaut pour les tests.

## Démarrer le projet

Une fois que l'installation est terminée, vous pouvez démarrer le serveur Laravel avec la commande suivante :

```bash
php artisan serve
```

Cela démarrera le serveur de développement à l'adresse `http://127.0.0.1:8000`.

## Routes API

### Authentification

#### **POST** `/api/register`
- Inscription d'un utilisateur avec les champs `name`, `email`, `password`, `password_confirmation`.
  
#### **POST** `/api/login`
- Connexion d'un utilisateur avec les champs `email`, `password`. Retourne un **token** d'authentification.

### Posts

#### **GET** `/api/posts`
- Récupérer tous les posts.

#### **GET** `/api/posts/{id}`
- Récupérer un post spécifique par son ID.

#### **POST** `/api/posts`
- Créer un nouveau post (requiert `title` et `content`).

#### **PUT** `/api/posts/{id}`
- Mettre à jour un post existant par son ID (requiert `title` et `content`).

#### **DELETE** `/api/posts/{id}`
- Supprimer un post spécifique par son ID.

### Commentaires

#### **GET** `/api/posts/{postId}/comments`
- Récupérer tous les commentaires d'un post spécifique.

#### **GET** `/api/posts/{postId}/comments/{commentId}`
- Récupérer un commentaire spécifique d'un post.

#### **POST** `/api/posts/{postId}/comments`
- Ajouter un commentaire à un post (requiert `content`).

#### **PUT** `/api/posts/{postId}/comments/{commentId}`
- Mettre à jour un commentaire d'un post spécifique.

#### **DELETE** `/api/posts/{postId}/comments/{commentId}`
- Supprimer un commentaire d'un post spécifique.

## Tester l'API avec Postman

1. **S'inscrire :**

   Pour tester l'inscription, envoyez une requête `POST` à `/api/register` avec les données suivantes :

   ```json
   {
     "name": "John Doe",
     "email": "johndoe@example.com",
     "password": "password",
     "password_confirmation": "password"
   }
   ```

2. **Se connecter :**

   Pour tester la connexion, envoyez une requête `POST` à `/api/login` avec les données suivantes :

   ```json
   {
     "email": "johndoe@example.com",
     "password": "password"
   }
   ```

   En réponse, vous recevrez un **token** d'authentification, que vous devrez inclure dans les en-têtes des requêtes suivantes :

   ```bash
   Authorization: Bearer <votre_token>
   ```

3. **Récupérer les posts :**

   Une fois authentifié, vous pouvez envoyer une requête `GET` à `/api/posts` pour récupérer tous les posts. N'oubliez pas d'inclure le **token** dans l'en-tête `Authorization`.

4. **Créer un post :**

   Envoyez une requête `POST` à `/api/posts` pour créer un post, en incluant `title` et `content` dans le corps de la requête :

   ```json
   {
     "title": "Mon nouveau post",
     "content": "Voici le contenu de mon nouveau post."
   }
   ```

5. **Ajouter un commentaire :**

   Pour ajouter un commentaire à un post spécifique, envoyez une requête `POST` à `/api/posts/{postId}/comments` avec le `content` du commentaire :

   ```json
   {
     "content": "Voici un commentaire pour le post."
   }
   ```

6. **Mettre à jour un post ou un commentaire :**

   Pour mettre à jour un post ou un commentaire, envoyez une requête `PUT` avec les nouvelles informations.

   Exemple pour un post :

   ```json
   {
     "title": "Mon post mis à jour",
     "content": "Le contenu du post a été mis à jour."
   }
   ```

## Conclusion

Ce projet fournit une API de base pour la gestion des posts et des commentaires, avec une authentification sécurisée via Laravel Breeze et Sanctum. Vous pouvez l'étendre et le personnaliser selon vos besoins.
