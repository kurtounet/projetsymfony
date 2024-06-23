# Projet examen Symfony
## Voici une bref du projet déscription du projet:

## Appel à 2 API
### Pour récupérer les données

> API Dragon Ball Z : <https://web.dragonball-api.com/>

Tapez la commande :

```bash
symfony console call-api  
```
Cette commande appelle l'API pour télécharger les données et les images de chaque personnage.

Elle appelle un service CallApiService, qui utilise HttpClient pour récupérer les données, puis CallApiService appelle DownloadImageService pour télécharger les images avec le composant Filesystem.

Les données sont sauvegardées dans des fichiers JSON :

- Pour les personnages : `src/DataFixtures/charactersApi.json`
- Pour les planètes : `src/DataFixtures/planetsApi.json`

Les images dans :

- Pour les personnages : `public/upload/characters`
- Pour les planètes : `public/upload/planets`
- Pour les transformations : `public/upload/transformations`


### Pour la Géolocalisation

> Géolocalisation : <https://nominatim.openstreetmap.org/>
 ## Cela fonctionne. 
 ### Les coordonnés sont enregistrées dans la table Address, lors de l'inscription de l'utilisateur , et modifier si il modifie sont adresse dans sont profile.

  
## Fixtures

### Pour charger les données en BDD

Tapez la commande :

```bash
symfony console d:f:l  
```

## Les pages Public

- **Page d'accueil** (fait)   
- **Page liste des héros** (fait)   
  - Affiche les cartes des personnage,(cliquez sur la carte pour voir les détails)
  - Formulaire de filtrage fait avec createQueryBuilder (fait)

- **Page détail des héros** (fait)
  - Affiche les information sur le personnage (fait)
  - Affiche les utilisateurs qui aime aussi ce personnage personnage (fait)

- **Page liste des planètes** (fait)
  - Affiche les cartes des planètes,(cliquez sur la carte pour voir les détails).
- **Page détail des planètes** (fait)
  - Affiche les détail de la planètes.

- **Page inscription Newsletter** (fait)
  - Formulaire d'inscription (fait)
  - Email de notification (fait)

- **Page formulaire de contact** (fait)
  - Formulaire (fait)
  - Email de notification (fait)
  -enrigistrement du message en bbd dans la table contact

- **Page authentification**   
    - HashPassword avec Subscriber (fait)
    - Upload de fichier (sans bundle) pour l'avatar dans ProfileController
    - Email de notification (fait)
   
- **Page login et lien vers la réinitialisation du mot de passe** (fait)
  - Formulaire pour accèder a l'espace utilisateur

- **Page réinitialisation du mot de passe** url: /reset-password  (fait)
  - Formulaire (email) pour réinitialisation du mot de passe (fait)
  - Email de notification (fait)
  - Lien pour simuler le lien dans emai, qui redirige vers le formulaire du nouveau mot de passe (fait)
  - Formulaire pour entrer le nouveau mot de passe (ok).
  - Hash le nouveaux mots de passe utilisateur avec un Subscriber updatePersist (fait)

# Entités

- **User**
- **Character**
- **Planet**
- **Contact**
- **Address**
- **Newsletter**

# Espace Utilisateur
- Modification du profil utilisateur (ok) 
- Modification du mot de passe (ok)

# Admin avec EasyAdmin

- Les admin peuvent ajouter, modifier, supprimer chaque entitées.

# Structure du projet

#### Commandes

- `CallApiCommand.php`
- `TestCommand.php`

#### Contrôleurs

- `Admin`
  - `CharacterCrudController.php`
  - `ContactCrudController.php`
  - `DashboardController.php`
  - `NewsletterEmailCrudController.php`
  - `PlanetCrudController.php`
  - `UserCrudController.php`
- `ChangePasswordController.php`
- `CharacterController.php`
- `ContactController.php`
- `GeoController.php`
- `HerosController.php`
- `HomeController.php`
- `NewsletterController.php`
- `PlanetsController.php`
- `ProfileController.php`
- `RegistrationController.php`
- `SecurityController.php`

#### Fixtures

- `AppFixtures.php`
- `charactersApi.json`
- `planetsApi.json`
- `user.json`

#### Entités

- `Address.php`
- `Character.php`
- `Contact.php`
- `NewsletterEmail.php`
- `Planet.php`
- `User.php`

#### Événements

- `AddressRegisteredEvent.php`
- `NewsletterRegisteredEvent.php`

#### Subscribers

- `GeolocationSubscriber.php`
- `HashUserPasswordSubscriber.php`

#### Formulaires

- `AddressType.php`
- `ChangePasswordFormType.php`
- `CharacterFilterType.php`
- `CharacterType.php`
- `ContactType.php`
- `EditProfileUserType.php`
- `NewsletterType.php`
- `RegistrationFormType.php`
- `ResetPasswordType.php`

#### Modèles

- `TransformationModels.php`

#### Repositories

- `AddressRepository.php`
- `CharacterRepository.php`
- `ContactRepository.php`
- `NewsletterEmailRepository.php`
- `PlanetRepository.php`
- `TransformationRepository.php`
- `UserRepository.php`

#### Services

- `CallApiService.php`
- `ContactNotification.php`
- `DownloadImageService.php`
- `EmailNotification.php`
- `EmailResetPasswordNotification.php`
- `GeoService.php`

### Liste des routes

```bash
symfony console debug:router
```

```plaintext
-------------------------- ---------- -------- ------ -----------------------------------
  Name                       Method     Scheme   Host   Path
-------------------------- ---------- -------- ------ -----------------------------------
  dashboard_admin            ANY        ANY      ANY    /admin
  app_change_password        ANY        ANY      ANY    /change/password/{id}
  app_character_index        GET        ANY      ANY    /character/
  app_character_new          GET|POST   ANY      ANY    /character/new
  app_character_show         GET        ANY      ANY    /character/{id}
  app_character_edit         GET|POST   ANY      ANY    /character/{id}/edit
  app_character_delete       POST       ANY      ANY    /character/{id}
  app_contact                ANY        ANY      ANY    /contact
  app_contact_thanks         ANY        ANY      ANY    /contact/thanks
  geocode                    ANY        ANY      ANY    /geocode
  app_heros                  ANY        ANY      ANY    /heros
  app_hero                   ANY        ANY      ANY    /heros/{id}
  app_index                  ANY        ANY      ANY    /
  app_newsletter_subscribe   ANY        ANY      ANY    /newsletter
  app_newsletter_thanks      ANY        ANY      ANY    /newsletter/thanks
  app_planets                ANY        ANY      ANY    /planets
  app_planet                 ANY        ANY      ANY    /planets/{id}
  app_profile_index          GET        ANY      ANY    /profile/
  app_profile_new            GET|POST   ANY      ANY    /profile/new
  app_profile_show           GET        ANY      ANY    /profile/
  app_profile_edit           GET|POST   ANY      ANY    /profile/edit
  app_profile_delete         POST       ANY      ANY    /profile/{id}
  app_register               ANY        ANY      ANY    /register
  app_login                  ANY        ANY      ANY    /login
  app_logout                 ANY        ANY      ANY    /logout
  app_reset_password         ANY        ANY      ANY    /reset-password
```

## Commandes pour la mise à jour de l'API

### Création du projet

```bash
symfony new examsymfony --version=6.4 --webapp
```

### Création de la base de données

```bash
symfony console doctrine:database:create
```

### Installation de Tailwind

```bash
composer require symfonycasts/tailwind-bundle
```

### Initialisation de Tailwind

```bash
php bin/console tailwind:init
```

### Compilation et recompilation des CSS lors des changements dans le projet

```bash
php bin/console tailwind:build
```

```bash
php bin/console tailwind:build --watch
```

### Installation du bundle pour les Fixtures

```bash
composer require --dev orm-fixtures
```

### Installation du bundle pour HTTPClient

```bash
composer require symfony/http-client
```

### Création d'un IndexController

```bash
symfony console make:controller NomduController
```

# Sommaire

1. [Appel à 2 API](#appel-à-2-api)
   1. [Pour récupérer les données](#pour-récupérer-les-données)
   2. [Pour la Géolocalisation](#pour-la-géolocalisation)

2. [Fixtures](#fixtures)
   1. [Commande : `symfony console call-api`](#commande--symfony-console-call-api)

3. [Stucture du projet](#structure-du-projet)  
4. [Public](#public)
5. [Page authentification](#page-authentification)
6. [Entités](#entités)
7. [Utilisateur](#utilisateur)
8. [Admin avec EasyAdmin](#admin-avec-easyadmin)
9. [Commandes pour la mise à jour de l'API](#commandes-pour-la-mise-à-jour-de-lapi)
   1. [Création du projet](#création-du-projet)
   2. [Création de la base de données](#création-de-la-base-de-données)
   3. [Installation de Tailwind](#installation-de-tailwind)
   4. [Initialisation de Tailwind](#initialisation-de-tailwind)
   5. [Compilation et recompilation des CSS lors des changements dans le projet](#compilation-et-recompilation-des-css-lors-des-changements-dans-le-projet)
   6. [Installation du bundle pour les Fixtures](#installation-du-bundle-pour-les-fixtures)
   7. [Installation du bundle pour HTTPClient](#installation-du-bundle-pour-httpclient)
   8. [Création d'un IndexController](#création-dun-indexcontroller)
   9. [Liste des routes](#liste-des-routes)
   10. [Structure du projet](#structure-du-projet)
       - [Commandes](#commandes)
       - [Contrôleurs](#contrôleurs)
       - [Fixtures](#fixtures)
       - [Entités](#entités-1)
       - [Événements](#événements)
       - [Subscribers](#subscribers)
       - [Formulaires](#formulaires)
       - [Modèles](#modèles)
       - [Repositories](#repositories)
       - [Services](#services)
