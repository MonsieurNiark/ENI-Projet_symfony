 ENI-Projet_symfony

https://www.jetbrains.com/help/phpstorm/github.html add compte github
https://www.jetbrains.com/help/phpstorm/manage-projects-hosted-on-github.html add le projet
https://www.jetbrains.com/help/phpstorm/commit-and-push-changes.html commit push et tutti quanti 

git config --global http.proxy http://proxy-sh.ad.campus-eni.fr:8080

http://www.sqlines.com/online  : conversion sql

Installation nouveau bundle friendsofsymfony/jsrouting-bundle :
- Créer une nouvelle variable d'environnement (user et admin)
        nom: https_proxy
        valeur: http://10.0.0.248:8080
- Lancer PowerShell (le relancer si ouvert auparavant pour qu'il prenne la nouvelle variable)
- Installation du bundle : php bin/console assets:install --symlink public


Configuration MySQL:
- Pour activer les events, connectez-vous à votre base de données projet_sortie -> Evenements et activé
le planificateur d'évènements