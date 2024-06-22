# Projet examen Symfony
Démarrer le projet:
git clone 

php bin/console tailwind:build
## Fixtures

### La Commande: `symfony console call-api`

Appelle l'API pour télécharger les données et les images de chaque personnage. Les données sont sauvegardées dans des fichiers JSON: `src\DataFixtures`.

Cette commande permet de charger la base de données à partir de l'API (<https://web.dragonball-api.com/>) en utilisant HTTPClient.

La commande appel un service CallApiService , qui utilise HttpClient pour récuper les données, puis CallApiServcice appel DownloadImageService pour télécharger les images  avec le composant Filesystem.


## À faire

- Redirection du profil après édition + suppression du champ mot de passe
 
# Public

- **Page d'accueil** (fait)
- **Page liste des héros** (fait)   
  - Formulaire de filtrage avec createQueryBuilder (fait)
- **Page liste des planètes** (fait)
- **Page détail des planètes** (fait)
- **Page Page inscription Newsletter** (fait)   
  - Formulaire d'inscription (fait)
  - Email de notification (fait)
    
- **Page formulaire de contact** (fait)
  - Formulaire (fait)
  - Email de notification (fait)

## Page authentification

- **Authentification** (fait)
  - HashPassword avec Subscriber (fait)
  - Upload de fichier (sans bundle) pour l'avatar dans profileController  
  - Email de notification (fait)
  - Changer les mot de passe utilisateur avec subscriber updatePersit (fait)
- **Page login** (fait)
  - Formulaire (email) pour réinitialise du mots de passe + Email de notification (fait)
  **Page réinitialise du mots de passe url: /reset-passowrd ->** (fait)
  - 1.Formulaire (email) pour réinitialisation du mots de passe + Email de notification +
  lien pour simuler lien vers le fomulaire du nouveau mode passe (fait)
  - 2.Formulaire pour entrer le nouveau mots de passe (ok).

# Entités
- User
- Character
- Planet
- Contact

# Utilisateur
- Profile 


  Étape 1 : Créer le formulaire de changement de mot de passe
  Étape 2 : Créer le contrôleur pour gérer le changement de mot de passe
  Étape 3 : Créer la vue pour le formulaire
- Inscription d'un nouvel utilisateur (ok)
- Modification du profil utilisateur (ok), reste la modification du mot de passe

# Admin avec EasyAdmin

- CRUD pour les utilisateurs (à faire)
- CRUD pour les héros (à faire)
- CRUD pour les planètes (à faire)

## Commandes pour la mise à jour de l'API

### Création du projet

```
symfony new examsymfony --version=6.4 --webapp
```

### Création de la base de données

```
symfony console doctrine:database:create
```

### Installation de Tailwind

```
composer require symfonycasts/tailwind-bundle
```

### Initialisation de Tailwind

```
php bin/console tailwind:init
```

### Compilation et recompilation des CSS lors des changements dans le projet

```
php bin/console tailwind:build --watch
```

### Installation du bundle pour les Fixtures

```
composer require --dev orm-fixtures
```

### Installation du bundle pour HTTPClient

```
composer require symfony/http-client
```

### Création d'un IndexController

```
symfony console make:Controller IndexController
```
