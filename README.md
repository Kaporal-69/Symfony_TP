# TP Click and Collect

## A propos

Ce projet a été réalisé par Wissale Jerraf et Mélanie Lamy dans le cadre d'un tp noté de la Licence Professionnelle METINET.
## Installation
### 1. Cloner le dépôt

Clonez le dépôt dans le dossier de votre choix

### 2. Installer le projet

Avant toute chose, vérifiez que composer est installé sur votre machine. Ensuite il faut exécuter `composer install`.

### 3. Modifier le .env

- Modifier le .env avec les identifiants de votre base de données MySQL.
- A la fin du fichier, ajouter ces lignes, elles permettront de faire fonctionner swift mailer:
```
###> symfony/swiftmailer-bundle ###
# For Gmail as a transport, use: "gmail://username:password@localhost"
# For a generic SMTP server, use: "smtp://localhost:25?encryption=&auth_mode="
# Delivery is disabled by default via "null://localhost"
MAILER_URL=gmail://usine.swift:ytgviacursjgxscn@localhost
###< symfony/swiftmailer-bundle ###
```

> Remarque: si le .env n'existe pas, utiliser le template dans `.env.template` disponible à la racine du projet.

### 4. Effectuer la migration de la base de données

Entrez la commande ` php bin/console doctrine:migrations:migrate` dans votre terminal pour mettre en place la base de données

### 5. Lancer le serveur

Le serveur se lance à l'aide de la commande `symfony server:start`. Il est disponible en local à l'adresse http://127.0.0.1:8000/.

## Les comptes

### Comptes utilisateur
Tous les nouveaux comptes créés sont des comptes utilisateurs normaux.

### Compte Administrateur
Pour tester le mode administrateur utiliser l'adresse `email@test2.fr` et le mot de passe `testtest`.
