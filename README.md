# AnySphere - Documentation

## Description

AnySphere est une application Symfony permettant de gérer une collection d'animes et de films d'animation japonais. L'application permet l'ajout, la modification, la suppression et la visualisation des animes et des films, ainsi que l'association de plusieurs genres pour chaque œuvre.

## Installation

```bash
# Cloner le dépôt
git clone <repository-url>

# Aller dans le dossier du projet
cd anysphere

# Installer les dépendances
composer install
npm install
npm run build

# Configurer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Charger les données initiales
php bin/console doctrine:fixtures:load

# Lancer le serveur Symfony & le front
symfony server:start
npm run watch
```

---

## Routes disponibles

### 🔹 Accueil

* `/` - Affichage des derniers animes et films ajoutés

### 🔹 Animes

* `/anime` - Liste paginée des animes
* `/anime/new` - Formulaire d'ajout d'un nouvel anime
* `/anime/{id}` - Affichage des détails d'un anime
* `/anime/{id}/edit` - Formulaire d'édition d'un anime

### 🔹 Films

* `/movie` - Liste paginée des films (à implémenter)
* `/movie/new` - Formulaire d'ajout d'un nouveau film
* `/movie/{id}` - Affichage des détails d'un film
* `/movie/{id}/edit` - Formulaire d'édition d'un film


---

## Fonctionnalités principales

* 🔄 **Formulaires d'ajout et de modification** pour les Animes et les Films
* 🎭 **Genres dynamiques** générés via Foundry et associés automatiquement
* 📌 **Pagination** propre et stylisée sur les listes
