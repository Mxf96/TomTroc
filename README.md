# 📚 TomTroc

TomTroc est une application web de partage et d'échange de livres entre particuliers.

Le site permet aux utilisateurs de créer un compte, gérer leur bibliothèque personnelle, consulter les livres proposés par les autres membres et échanger directement grâce à une messagerie privée.

Ce projet a été réalisé en **PHP orienté objet** avec une architecture **MVC**, dans le cadre de ma formation OpenClassrooms.

---

## 🎯 Objectif du projet

L'objectif de TomTroc est de proposer une plateforme simple permettant aux passionnés de lecture de mettre leurs livres à disposition et d'entrer en contact avec d'autres lecteurs.

Le projet permet notamment de mettre en pratique :

- PHP orienté objet
- architecture MVC
- PDO et MySQL
- gestion des sessions
- authentification utilisateur
- manipulation de fichiers
- requêtes SQL préparées
- validation des formulaires côté serveur
- développement responsive
- JavaScript

---

## ✨ Fonctionnalités

### 📖 Livres

- affichage des derniers livres ajoutés sur la page d'accueil
- affichage de l'ensemble des livres disponibles
- recherche dynamique par titre ou auteur
- consultation de la fiche détaillée d'un livre
- affichage du propriétaire du livre
- ajout d'un nouveau livre
- modification d'un livre
- suppression d'un livre
- gestion de la disponibilité d'un livre
- ajout et modification d'une image
- prévisualisation d'une image avant son envoi

### 👤 Utilisateurs

- inscription
- connexion
- déconnexion
- gestion de session
- consultation de son compte
- modification du pseudo
- modification de l'adresse email
- modification du mot de passe
- modification de l'avatar
- consultation du profil public d'un utilisateur
- affichage de la bibliothèque d'un utilisateur

### 💬 Messagerie

- création automatique d'une conversation entre deux utilisateurs
- consultation des conversations
- envoi de messages privés
- affichage des messages envoyés et reçus
- gestion des messages lus / non lus
- compteur de messages non lus
- mise en avant des conversations contenant des messages non lus
- accès au profil d'un utilisateur depuis une conversation

### 🔐 Sécurité

- mots de passe protégés avec `password_hash()`
- vérification avec `password_verify()`
- requêtes SQL préparées avec PDO
- échappement des données affichées avec `htmlspecialchars()`
- validation des formulaires côté PHP
- vérification des autorisations avant modification ou suppression d'un livre
- vérification de l'accès aux conversations
- contrôle des formats et de la taille des images envoyées
- génération de noms uniques pour les fichiers uploadés
- identifiants de connexion à la base stockés dans un fichier `.env`

---

## 🛠️ Technologies utilisées

| Technologie | Utilisation                          |
| ----------- | ------------------------------------ |
| PHP         | Backend et logique métier            |
| MySQL       | Base de données                      |
| PDO         | Communication avec MySQL             |
| HTML5       | Structure des pages                  |
| CSS3        | Mise en page et responsive           |
| JavaScript  | Interactions dynamiques              |
| Git         | Gestion des versions                 |
| GitHub      | Hébergement du repository            |
| WampServer  | Environnement de développement local |

---

## 🏗️ Architecture

Le projet utilise une architecture **MVC (Model - View - Controller)**.

```text
TomTroc/
│
├── config/
|   ├── _config.php
│   ├── autoload.php
│   └── config.php
│
├── controllers/
│   ├── BookController.php
|   ├── HomeController.php
│   ├── MessageController.php
│   └── UserController.php
│
├── models/
│   ├── Book.php
│   ├── BookManager.php
│   ├── ConversationManager.php
│   ├── MessageManager.php
│   └── UserManager.php
│
├── services/
│   ├── UploadService.php
│   └── ValidatorService.php
│
├── views/
│   ├── templates/
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── main.php
│   │
│   ├── account.php
│   ├── addBook.php
│   ├── bookDetails.php
│   ├── books.php
│   ├── editBook.php
│   ├── errorPage.php
│   ├── home.php
│   ├── login.php
│   ├── messages.php
│   ├── profile.php
│   ├── register.php
│   └── View.php
│
├── assets/
│   ├── img/
│   │   ├── books/
│   │   ├── icons/
│   │   ├── logos/
│   │   └── pictures/
│   │
│   └── styles/
│       ├── account.css
│       ├── addBook.css
│       ├── bookDetails.css
│       ├── books.css
│       ├── editBook.css
│       ├── errorPage.css
│       ├── footer.css
│       ├── header.css
│       ├── home.css
│       ├── login.css
│       ├── messages.css
│       ├── profile.css
│       └── style.css
│
├── JS/
│   ├── dynamicSorting.js
│   ├── loadSpin.js
│   ├── menuBurger.js
│   ├── previewIMG.js
│   └── previewIMGEdit.js
│
├── .env
├── .env.test
├── .gitignore
└── index.php
```

---

## 🔄 Fonctionnement MVC

### Models

Les modèles et Managers permettent de communiquer avec la base de données.

Exemples :

```text
BookManager
UserManager
MessageManager
ConversationManager
```

Ils centralisent notamment les requêtes SQL de l'application.

### Views

Les vues contiennent principalement le HTML affiché à l'utilisateur.

Exemples :

```text
home.php
books.php
bookDetails.php
account.php
messages.php
```

### Controllers

Les contrôleurs font le lien entre les vues et les modèles.

Ils :

- récupèrent les données envoyées par l'utilisateur
- vérifient les données
- appellent les Managers
- choisissent la vue à afficher
- effectuent les redirections nécessaires

---

## 🧭 Routage

Le routage est centralisé dans :

```text
index.php
```

L'action demandée est récupérée avec :

```php
$action = Utils::request('action', 'home');
```

Exemple d'URL :

```text
index.php?action=books
```

ou :

```text
index.php?action=book&id=3
```

Le routeur appelle ensuite le contrôleur correspondant.

Exemple :

```php
case 'book':

    $id = (int) Utils::request('id');

    $bookController = new BookController($db);
    $bookController->showBook($id);

    break;
```

---

## 🗄️ Base de données

La base de données utilisée est :

```text
tomtroc
```

Elle contient principalement les tables suivantes :

### `Users`

Stocke les comptes utilisateurs.

Principales informations :

```text
id_user
username
email
password
avatar
created_at
updated_at
```

### `Books`

Stocke les livres mis en ligne.

```text
id_book
title
author
image
description
status
created_at
updated_at
id_user
```

Chaque livre appartient à un utilisateur.

### `Conversations`

Stocke les conversations privées.

```text
id_conversation
created_at
```

### `Messages`

Stocke les messages envoyés.

```text
id_message
content
is_read
created_at
id_user
id_conversation
```

### `Users_Conversation`

Table de liaison permettant d'associer les utilisateurs aux conversations.

```text
id_user
id_conversation
```

---

## ⚙️ Installation

### 1. Cloner le projet

```bash
git clone https://github.com/Mxf96/TomTroc
```

Puis entrer dans le projet :

```bash
cd TomTroc
```

---

### 2. Installer un serveur local

Le projet nécessite notamment :

```text
PHP
MySQL
Apache
```

Il peut par exemple être exécuté avec :

```text
WampServer
XAMPP
MAMP
```

---

### 3. Créer la base de données

Dans phpMyAdmin, créer une base nommée :

```sql
CREATE DATABASE tomtroc
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;
```

Puis importer les tables et les données SQL du projet.

---

### 4. Configurer `.env`

Créer un fichier `.env` à la racine du projet.

Exemple :

```env
DB_HOST=
DB_NAME=
DB_USER=
DB_PASS=
```

Le fichier `.env` contient des informations sensibles et ne doit pas être envoyé sur GitHub.

Il doit donc être présent dans `.gitignore` :

```gitignore
.env
```

---

### 5. Lancer le projet

Placer le projet dans le dossier utilisé par votre serveur local.

Avec WampServer, par exemple :

```text
C:\wamp64\www\TomTroc
```

Puis accéder au projet depuis le navigateur :

```text
http://localhost/TomTroc/
```

---

## 📤 Gestion des images

Les images envoyées par les utilisateurs sont contrôlées avant leur enregistrement.

Les formats acceptés sont :

```text
PNG
JPG / JPEG
WEBP
AVIF
```

Les fichiers sont vérifiés côté serveur à l'aide de leur type MIME.

Les images de livres sont enregistrées dans :

```text
assets/img/books/
```

Les avatars utilisateurs sont enregistrés dans :

```text
assets/img/pictures/
```

Un nom unique est généré lors de l'enregistrement afin d'éviter les collisions entre les fichiers.

---

## ✅ Validation des formulaires

La validation principale des formulaires est réalisée côté serveur en PHP.

Les formulaires utilisent :

```html
novalidate
```

afin de pouvoir afficher des messages d'erreur personnalisés par l'application.

Exemples :

```text
Le pseudo est obligatoire.
L'adresse email n'est pas valide.
Le mot de passe doit contenir au moins 8 caractères.
Veuillez renseigner le titre du livre.
Veuillez sélectionner une photo du livre.
Veuillez écrire un message avant de l'envoyer.
```

Les données sont systématiquement vérifiées côté serveur avant leur utilisation.

---

## 🔎 Recherche de livres

La page des livres propose une recherche par :

```text
titre
auteur
```

Une recherche côté serveur permet de filtrer les résultats avec SQL.

Une recherche dynamique en JavaScript permet également de filtrer les livres directement lors de la saisie de l'utilisateur.

---

## 📱 Responsive

L'interface est adaptée aux différentes tailles d'écran.

Les principales pages sont utilisables sur :

```text
ordinateur
tablette
mobile
```

Un menu burger est notamment utilisé sur les écrans mobiles.

La messagerie dispose également d'un affichage adapté : la liste des conversations et la conversation sélectionnée sont affichées séparément sur les petits écrans.

---

## ⏳ Animations et interactions

Plusieurs interactions JavaScript améliorent l'expérience utilisateur :

- menu burger responsive
- recherche dynamique des livres
- prévisualisation des images
- animation de chargement entre certaines pages
- désactivation du loader après l'envoi d'un message
- animation de confirmation après une inscription réussie
- redirection vers la connexion après création du compte

---

## 📌 Statut du projet

Le projet répond aux principales fonctionnalités prévues dans le MVP de TomTroc :

- navigation publique
- authentification
- gestion du compte
- gestion des livres
- profils publics
- recherche de livres
- messagerie privée
- interface responsive

---