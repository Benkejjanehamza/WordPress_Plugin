# WordPress_Plugin
WordPress Quiz - Jeux Vidéo

Bienvenue dans WordPress Quiz - Jeux Vidéo, un projet permettant aux utilisateurs de créer et de participer à des quiz sur leurs jeux préférés.
Description

Ce projet est une plateforme interactive développée avec WordPress, où les utilisateurs peuvent :

    Créer des quiz sur les jeux vidéo de leur choix.
    Répondre aux questions et obtenir un score final.
    Consulter les résultats et les partager.
    Naviguer à travers une interface personnalisée grâce à un thème développé spécifiquement pour le projet.

Installation

    Installer un serveur HTTP avec PHP et MySQL (ou MariaDB).
    Télécharger et installer WordPress en suivant la documentation officielle : Installation de WordPress.
    Cloner ce dépôt dans le dossier wp-content/themes/ pour le thème et wp-content/plugins/ pour le plugin.
    Activer le thème et le plugin dans l'administration WordPress.
    Configurer les paramètres du quiz et tester les fonctionnalités.

Fonctionnalités
Front-end

    Inscription et connexion des utilisateurs.
    Choix entre poser des questions ou y répondre.
    Affichage des questions et validation des réponses.
    Résultats consultables et partageables.

Back-end

    Création, mise à jour et suppression de quiz via le panneau d'administration.
    Enregistrement des réponses en base de données.
    Gestion des utilisateurs et des statistiques.
    Intégration de Google Site Kit pour suivre les performances du site.

Base de données

Le projet utilise une base de données MySQL pour stocker :

    Les utilisateurs.
    Les quiz et leurs questions.
    Les réponses enregistrées.
    Les statistiques de participation.

Développement du thème

Un thème personnalisé a été créé pour correspondre à l'univers du jeu sélectionné. Il est stocké dans wp-content/themes/. Les fichiers principaux incluent :

    style.css : Feuille de style du thème.
    index.php : Structure principale du site.
    functions.php : Fonctions personnalisées pour le thème.

Développement du plugin

Un plugin a été développé pour gérer la création et la gestion des quiz. Il est stocké dans wp-content/plugins/ et inclut :

    Un formulaire de création de quiz.
    Une gestion des réponses et des utilisateurs.
    Une interface d'administration pour consulter et modifier les quiz.

Personnalisation

Les utilisateurs peuvent modifier le thème et les fonctionnalités du plugin en ajustant les fichiers situés dans wp-content/themes/ et wp-content/plugins/. La documentation WordPress est disponible ici : Développement de thèmes et Développement de plugins.
Licence

Ce projet est sous licence MIT.
