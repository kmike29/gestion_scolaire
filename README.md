Installation 
Composer require  # installer les dépendences
php bin/console doctrine:database:create
php bin/console make:migration
symfony console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

Commande utiles

php-cs-fixer/vendor/bin/php-cs-fixer fix src 
#Utiliser php-cs-fixer