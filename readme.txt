###### Le projet ######

Gestionnaire de personnage de RPG avec Symfony


###### Prérequis ######

Wamp
utiliser php 8.1.0
composer (php 8.1.0)
symfony 6.1.5
node 8.15.0

###### Installation rapide ######

Renommer le fichier .envModel à la racine en .env et le configurer pour la création de la BDD

composer require symfony/runtime
npm install
php bin/console doctrine:database:create
php bin/console --no-interaction doctrine:migration:migrate
php bin/console --no-interaction doctrine:fixtures:load
npm run dev
symfony server:stop
symfony server:start

###### détails de l'installation ######

Installation des dépendances :
composer require symfony/runtime
npm install

Renommer le fichier .envModel à la racine en .env et le configurer pour la création de la BDD : 
php bin/console doctrine:database:create
php bin/console doctrine:migration:migrate

optionnel {
remplir la BDD avec quelques classes et cométences :
php bin/console doctrine:fixtures:load
}

compiler css / js :
npm run dev

lancer le server :
symfony server:start


