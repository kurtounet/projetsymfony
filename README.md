# Projet examen Symfony

# FIXTURES: les donneés sont dans les json: src\DataFixtures

- appel API : symfony console call-api
- 

    pour charger la base de donnée a partir d'une api (https://web.dragonball-api.com/)
    avec HTTPclient.
commande pour :


#### A faire:
##### Filtre les heros par planets
##### Filtre par sexe, séries  
#### redirection profile edit + supp champ password
#### dir avatar + image
#### download image dbz call-api
##### Ajouter createdat et updateat aux entity
 
 
en cour download image

# PUBLIC :
##### Page acceuil. (fait)
##### Page liste des héros. (fait)
##### Page détail héros. (fait)
##### Page liste planets (fait)
##### Page détail planets fait
##### Page formulaire inscription fait ##### Page inscription Newsletter (fait)
##### Page formulaire inscription  (fait)
    - formulaire (fait)
    - validation (fait)         
    - email de notification (fait)
    - HashPassword avec Subcriber (fait)

##### Page formulaire contact (fait)
    - formulaire (fait)
    - validation  (fait)
    - email de notification (fait)
    
## Page authentification 
#####  authentification (fait)
#####  Page login (fait)

# Entity :

##### User
##### Character
##### Planet
##### Contact
 

#  Utilisateur
 
-> Inscription nouveau utilisateur (ok)
-> Modifier profile utilisateur (ok), reste modife pwd()

#  Admin easyadmin
-> CRUD user (a faire) 
-> CRUD heros (a faire)
-> CRUD Planète (a faire)



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