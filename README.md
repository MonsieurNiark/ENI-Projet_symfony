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
- Pour créer les events, executer sur MySQL les lignes suivantes :

--
-- Évènements
--

CREATE DEFINER=`root`@`localhost` EVENT `ENCOURS_TO_TERMINEE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 6 WHERE DATE_ADD(`datedebut`, INTERVAL `duree` MINUTE) <=  NOW() AND `etat_sortie_id`=5$$

CREATE DEFINER=`root`@`localhost` EVENT `OUVERT_TO_FERMETURE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 10:18:40' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 2 WHERE `datecloture` <=  NOW() AND `etat_sortie_id`=1$$

CREATE DEFINER=`root`@`localhost` EVENT `FERMETURE_TO_ENCOURS` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 5 WHERE `datedebut` <= NOW() AND `etat_sortie_id`=2$$

CREATE DEFINER=`root`@`localhost` EVENT `TERMINEE_TO_NONVISIBLE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 3 WHERE DATE_ADD(DATE_ADD(`datedebut`, INTERVAL `duree` MINUTE),INTERVAL 1 MONTH) <= NOW() AND `etat_sortie_id`=6$$

CREATE DEFINER=`root`@`localhost` EVENT `OUVERT_TO_ENCOURS` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 10:18:32' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 5 WHERE `datedebut` <= NOW() AND `etat_sortie_id`=1$$

CREATE DEFINER=`root`@`localhost` EVENT `ANNULEE_TO_NONVISIBLE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 10:18:25' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 3 WHERE DATE_ADD(`datedebut`, INTERVAL 1 MONTH) <= NOW() AND `etat_sortie_id`=7$$
