<p align="center">
  <img src="public/assets/images/favicon.png" width="48" height="48" alt="Logo Ecommerce">
</p>

# Ecommerce — boutique en ligne

Petit site e-commerce de démonstration construit avec **Laravel 11** : catalogue, panier, commandes, avis produits, livraison et paiement **Stripe Checkout**. Une couche UI commune (`app-ui`) harmonise vitrine, espace client et administration.

## Fonctionnalités (aperçu)

- Vitrine, recherche, fiche produit avec avis
- Comptes clients / administrateurs (rôles)
- Panier persisté, paiement Stripe, commandes idempotentes (retour succès)
- Back-office produits (CRUD) et suivi des commandes

## Prérequis

PHP 8.2+, Composer, Node.js, MySQL, compte Stripe (mode test).

## Démarrage rapide

```bash
composer install
cp .env.example .env && php artisan key:generate
# Configurer la base dans .env, puis :
php artisan migrate
php artisan db:seed
npm install && npm run build
php artisan serve
```

Variables utiles : `STRIPE_KEY`, `STRIPE_SECRET`, `DB_*`. Pour le serveur de dev, voir `PHP_CLI_SERVER_WORKERS` dans `.env.example`.

## Documentation

La documentation du projet (architecture, routes, modèles, configuration) est disponible en **HTML statique** :

**[Ouvrir la documentation →](docs/index.html)**

*(En local : ouvrir le fichier `docs/index.html` dans le navigateur, ou servir le dossier `docs/` avec un serveur HTTP.)*

## Licence

Projet de démonstration — voir les licences des dépendances (Laravel, Stripe, etc.).
