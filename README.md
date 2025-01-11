# Blog Symfony avec Système de Connexion et Publication d'Articles

Ce projet est une application de blog développée avec le framework **Symfony**. Elle permet aux utilisateurs de s'inscrire, de se connecter et de publier des articles à l'aide de l'éditeur enrichi **TinyMCE**. Les administrateurs ont des privilèges supplémentaires pour gérer les utilisateurs et les articles.

## Fonctionnalités

### Utilisateur
- Inscription et connexion sécurisées (gestion des mots de passe hashés avec Symfony Security).
- Possibilité de publier, modifier et supprimer ses propres articles.
- Affichage d'une liste d'articles publiés par les utilisateurs.

### Administrateur
- Gestion des utilisateurs : activation, désactivation, ou suppression de comptes.
- Gestion globale des articles : modification ou suppression de tout contenu.
- Tableau de bord dédié pour une vue d'ensemble des activités.

### Articles
- Création d'articles avec un éditeur enrichi **TinyMCE** (support des mises en forme, images, liens, etc.).
- Liste paginée des articles avec aperçu.
- Consultation détaillée d'un article individuel.

## Installation

### Prérequis
- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- Une base de données (MySQL, PostgreSQL ou autre compatible avec Doctrine)

### Étapes d'installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/votre-utilisateur/blog-symfony.git
   cd blog-symfony
