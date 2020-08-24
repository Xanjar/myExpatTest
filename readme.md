# MyExpatTest

* Mini application web qui récupère des données via une api et affiche les différents articles à la une de plusieurs éditeurs français.
* Possibilité d'ajouter des articles en favoris et de les partager.


## Installation

* Installer php si ça n'est pas déjà fait
* Installer "composer"
* creer la base à l'aide du script sql
* pull ce projet
* lancer à la racine du projet: ```composer install```
* créer un .env si il n'est pas là en copiant le .env.example
* modifier les valeurs associé à database, username, password dans le .env
* exécuter les deux commandes ci dessous pour mettre en place la BD.
* ```php bin/console make:migration```
* ```php bin/console doctrine:migrations:migrate```
* Enfin lancez la commande ```symfony server:start``` à la racine et allez au localhost dans votre navigateur

## Dépendances

* php
* Symfony 4
* Bootsrap
