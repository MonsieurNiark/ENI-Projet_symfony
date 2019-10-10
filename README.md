#ENI Projet Symfony : Sortir

Etapes de la mise en place du site Sortir.com
- Installer wamp
- Extraire le dossier zip dans le dossier C:\wamp\www
- Dans le fichier .env ligne 27:
DATABASE_URL=mysql://[user]:[password]@127.0.0.1:3306/[nom_base]
remplacer les éléments entre crochet par vos données correspondant à la connexion à votre base local

- Ouvrir un invite de commande et aller à la racine du projet
- Exécuter la commande : composer install
- Si votre base n'est pas encore créer
	- Exécuter la commande : php bin/console doctrine:database:create
- Exécuter les commandes :
	php bin/console doctrine:schema:validate
	php bin/console doctrine:schema:update --force
- Insérer le jeux de données des fixtures en base grâce à la commande :
	php bin/console doctrine:fixtures:load
répondre y à la demande de purge de la base


Maintenant tout est près pour utiliser le site, rendez-vous sur votre navigateur et accédez-y via l'adresse suivante:
http://localhost/ENI-Projet_sortir/public/


Compte test (pseudo / password):
- administrateur:
    - admin / admin
- utilisateur : 
	- user2 / test
	- user3 / test
	- user4 / test
	- user5 / test
	- user6 / test
		
nb: KONAMI CODE?