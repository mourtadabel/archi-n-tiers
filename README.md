# Documentation de l'API de Gestion de Stock bières

## Introduction

Mon API Stock bières permet d'aider les serveurs ou les patrons de bar à recevoir les commandes et à gérer leur stock tout en vérifiant les quantités disponibles. Le stock change en fonction des commandes validées.

### Technologies Utilisées

- **Framework**: [Laravel](https://laravel.com/)
- **Base de données**: MySQL
- **Outils de conception**: MySQL Workbench

## Modèle Conceptuel et Logique de Données (MCD et MLD)

- **MCD et MLD**:
  ![mcd mld](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/f405c01b-88f7-4117-98d6-598e37c1f775)
![mysql_workbench](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/4a26d868-83ac-421c-94ff-3584615e0ed2)


## Gestion des Bières

### Ajouter des Bières

- **URL**: `/api/bieres`
- **Méthode**: POST
- **Description**: Ajoute une nouvelle bière dans la base de données.
- **Paramètres**:
  - `nom` (string, obligatoire): Nom de la bière.
  - `prix` (float, obligatoire): Prix de la bière.

### Récupérer Toutes les Bières

- **URL**: `/api/bieres`
- **Méthode**: GET
- **Description**: Récupère la liste de toutes les bières disponibles.
- **Paramètres**: Aucun
![postman_get_bieres](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/c7aba9a9-d751-4b6a-a5d4-292fb1a8dfb3)

### Mettre à Jour une Bière

- **URL**: `/api/bieres/{id}`
- **Méthode**: PUT
- **Description**: Met à jour les informations d'une bière existante.
- **Paramètres**:
  - `id` (int, obligatoire): ID de la bière à mettre à jour.
  - `nom` (string, optionnel): Nouveau nom de la bière.
  - `prix` (float, optionnel): Nouveau prix de la bière.

### Supprimer une Bière

- **URL**: `/api/bieres/{id}`
- **Méthode**: DELETE
- **Description**: Supprime une bière de la base de données.
- **Paramètres**:
  - `id` (int, obligatoire): ID de la bière à supprimer.

## Gestion des Stocks

### Ajouter un Stock de Bière

- **URL**: `/api/stocks`
- **Méthode**: POST
- **Description**: Ajoute un nouveau stock de bière.
- **Paramètres**:
  - `biere_id` (int, obligatoire): ID de la bière.
  - `quantite_stock` (int, obligatoire): Quantité en stock.

### Récupérer Tous les Stocks

- **URL**: `/api/stocks`
- **Méthode**: GET
- **Description**: Récupère la liste de tous les stocks de bières.
- **Paramètres**: Aucun
![postman_get_stock](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/94dca687-3388-46f1-b519-dd0b5ee421ed)

### Mettre à Jour un Stock de Bière

- **URL**: `/api/stocks/{id}`
- **Méthode**: PUT
- **Description**: Met à jour les informations d'un stock de bière existant.
- **Paramètres**:
  - `id` (int, obligatoire): ID du stock à mettre à jour.
  - `quantite_stock` (int, optionnel): Nouvelle quantité en stock.

### Supprimer un Stock de Bière

- **URL**: `/api/stocks/{id}`
- **Méthode**: DELETE
- **Description**: Supprime un stock de la base de données.
- **Paramètres**:
  - `id` (int, obligatoire): ID du stock à supprimer.

## Gestion des Commandes

### Ajouter une Commande

- **URL**: `/api/commandes`
- **Méthode**: POST
- **Description**: Crée une nouvelle commande.
- **Paramètres**:
  - `bieres` (array, obligatoire): Liste des bières et quantités commandées.
![postman_post_commandes](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/539df0ce-73f4-4415-b164-960d23849fb9)

### Récupérer une Commande par ID

- **URL**: `/api/commandes/{id}`
- **Méthode**: GET
- **Description**: Récupère les détails d'une commande spécifique par son ID.
- **Paramètres**:
  - `id` (int, obligatoire): ID de la commande.
![postman_get_commandes_id](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/ce941375-6330-4c33-96c9-9951bd4cc7ac)

### Récupérer Toutes les Commandes Validées

- **URL**: `/api/commandes`
- **Méthode**: GET
- **Description**: Récupère la liste de toutes les commandes validées.
- **Paramètres**: Aucun
![postman_get_commandes](https://github.com/mourtadabel/archi-n-tiers/assets/146818987/a45ed630-d048-4295-af66-de87ccba7a11)
