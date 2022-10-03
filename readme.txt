Configuration : 

installer :
Wamp
utiliser php 8.1.0
composer
symfony


Installation des dépendances :
composer require symfony/runtime

Renommer le fichier .envModel à la racine en .env et le configurer pour la création de la BDD : 
php bin/console doctrine:database:create
php bin/console doctrine:migration:migrate

lancer le server :
symfony server:start