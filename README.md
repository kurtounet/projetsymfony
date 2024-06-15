# Projet examen Symfony

# PUBLIC :
##### Page acceuil. (fait)
##### Page des héros. (fait)

##### Page de détail pour chaque héros (clique sur la carte). (fait)

##### Page formulaire inscription Newsletter (fait)

    - formulaire (fait)
    - validation: 
        unique(fait) 
        champ vide (fait)
    - email de notification (fait)

##### Page formulaire contact (fait)

    - formulaire (fait)
    - validation:         
        champ vide(fait)
    - email de notification (fait)

##### Page formulaire contact (fait) + envoyer email de notification (à faire)

## Page inscription + contrainte de validation // user unique

->  authentification (fait)
    page login (fait)
    authentification (fait)

# Entity :

##### User

##### Character

##### Planet

##### Transfomation

# Espace utilisateur

# Espace admin

-> Ajouter , modifier, supprimer user
-> Ajouter , modifier, supprimer personnage

# FIXTURES:
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