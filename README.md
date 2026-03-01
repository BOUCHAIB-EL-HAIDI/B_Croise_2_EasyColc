# 🏠 EasyColoc

**EasyColoc** est une plateforme web moderne conçue pour simplifier la gestion financière et administrative des colocations. Finis les calculs complexes sur papier, EasyColoc automatise la répartition des dépenses et le suivi des remboursements.

## 🚀 Fonctionnalités Clés

### 📊 Gestion des Dépenses & Analytics
- **Ajout de dépenses** : Répartition automatique entre tous les membres actifs.
- **Filtres avancés** : Visualisez vos dépenses mois par mois.
- **Statistiques détaillées** : Tableaux de bord par catégorie et évolution mensuelle.
- **Suppression définitive** : Nettoyage complet des données liées à une dépense.

### 💳 Système de Paiement en Deux Étapes
- **Sécurité & Transparence** : 
    1. Le débiteur marque "J'ai payé" après son transfert (Statut PENDING).
    2. Le créancier confirme la réception pour valider officiellement le remboursement (Statut PAID).
- **Justification des Soldes** : Détail complet des dépenses (Dettes vs Créances) au sein des cartes de balance pour expliquer le calcul du montant net.
- **Calcul automatique des soldes** : Visualisez instantanément la balance nette par membre.

### 👥 Gestion de la Colocation
- **Suivi des Invitations** : Page dédiée pour les propriétaires permettant de suivre en temps réel si une invitation a été **acceptée**, **refusée** ou est toujours **en attente**.
- **Logique de Refus** : Possibilité pour les invités de décliner une invitation s'ils ne souhaitent pas rejoindre la colocation.
- **Rôles & Hiérarchie** : Distinction entre Propriétaire (gestion) et Membres.
- **Invitations par Email** : Rejoignez une coloc en un clic via Mailtrap.
- **Système de Réputation** : Visualisez le sérieux de vos colocataires via des points ⭐.
- **Modération** : Possibilité pour le propriétaire de retirer des membres (si soldes nuls) ou de quitter la coloc.

### 🛡️ Administration Globale (Admin)
- **Dashboard Global** : Statistiques sur le nombre total d'utilisateurs et de colocations.
- **Modération des Utilisateurs** : Bannissement et débannissement instantané avec déconnexion forcée.
- **Statistiques de Dépenses Globales** : Vue d'ensemble des flux financiers sur la plateforme.

## 🛠️ Installation & Configuration (Docker)

Cette application est conteneurisée pour un déploiement facile.

1. **Clonez le projet** :
   ```bash
   git clone [url-du-repo]
   ```

2. **Configuration `.env`** :
   Copiez le fichier `.env.example` en `.env` et configurez vos accès **Mailtrap** pour les invitations.

3. **Lancement avec Docker Compose** :
   ```bash
   docker compose up -d --build
   ```

4. **Migrations & Seeders** (à l'intérieur du conteneur) :
   ```bash
   docker exec php3 php artisan migrate --seed
   ```

5. **Accès** :
   L'application est accessible sur [http://localhost:8000](http://localhost:8000).



---
© 2026 EasyColoc. Conçu avec ♥ pour les colocataires.
