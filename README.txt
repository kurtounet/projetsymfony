Projet examsymfony

PUBLIC:
-> page acceuil.
-> page liste des cartes des personnage.
-> page de détail pour chaque personnage quand on clique sur la page.
-> page formulaire contact + envoyer email
-> page inscription + contrainte de validation // user unique
-> page login authentification JWT

Entity:
-> User
-> Character
-> Planet
-> Transfomation

ADMIN:
-> Ajouter , modifier, supprimer user
-> Ajouter , modifier, supprimer personnage

FIXTURES:
    charger la base de donnée a partir d'une api (https://web.dragonball-api.com/)
    avec HTTPclient.

Commande mise a jours api


# Création du projet
```
symfony new examsymfony --version=6.4 --webapp
```
# Création de la base de donnée
```
symfony console doctrine:database:create
```
# Installation de Tailwind
```
composer require symfonycasts/tailwind-bundle
```
# Initialisaton de tailwind
```
php bin/console tailwind:init
```
# Lance la compilation et recompilera les CSS lors des changements dans le projet
```
php bin/console tailwind:build --watch
```
# Installation bundle pour les Fixtures
```
composer require --dev orm-fixtures
```
# Installation bundle pour http-client
```
composer require symfony/http-client
```
# IndexController 
symfony console make:Controller IndexController