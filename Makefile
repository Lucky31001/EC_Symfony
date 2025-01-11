# Définir les variables de l'environnement
PHP=php
DOCTRINE=php bin/console doctrine
SYMFONY_SERVER=symfony server:start --daemon
STOP_SYMFONY_SERVER=symfony server:stop
SYNFONY_SERVER_STATUS=symfony server:status
XAMPP_CMD=sudo /Applications/XAMPP/xamppfiles/xampp
COMPOSER=composer

# Nom de la base de données
DATABASE_NAME=symfony_db

# Commande pour lancer XAMPP (Apache et MySQL)
start-xampp:
	@echo "Démarrage de XAMPP..."
	$(XAMPP_CMD) startapache
	$(XAMPP_CMD) startmysql

drop-db:
	@echo "Suppression de la base de données..."
	$(DOCTRINE):database:drop --force || true

# Commande pour créer la base de données
create-db:
	@echo "Création de la base de données..."
	$(DOCTRINE):database:create

# Commande pour créer le schéma de la base de données (tables)
migrate-db:
	@echo "Création des tables dans la base de données..."
	$(DOCTRINE):schema:create

# Commande pour installer les dépendances avec Composer
install-composer-deps:
	@echo "Installation des dépendances Composer..."
	$(COMPOSER) install --no-interaction

# Commande pour injecter les fixtures (si vous en avez)
fixtures:
	@echo "Injection des fixtures dans la base de données..."
	$(DOCTRINE):fixtures:load --no-interaction

# Commande pour démarrer le serveur Symfony
start:
	@echo "Démarrage du serveur Symfony..."
	$(SYMFONY_SERVER)

# Commande pour arrêter le serveur Symfony
stop:
	@echo "Arrêt du serveur Symfony..."
	$(STOP_SYMFONY_SERVER)

# Commande pour créer une nouvelle migration basée sur les changements dans les entités
migration:
	@echo "Création de la migration..."
	$(DOCTRINE):migrations:diff

# Commande pour appliquer les migrations non exécutées dans la base de données
migrate:
	@echo "Application des nouvelles migrations..."
	$(DOCTRINE):migrations:migrate --no-interaction

# Commande combinée pour lancer XAMPP, créer la base de données, créer les tables, injecter les fixtures et démarrer le serveur Symfony
run: start-xampp install-composer-deps drop-db create-db migrate-db fixtures start
