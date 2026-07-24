# ── Laravel Starter Kit - Docker Makefile ──
# Usage: make <command>

.PHONY: help up down restart build logs shell migrate seed fresh

# Default target
help: ## Show this help
	@echo "Laravel Starter Kit - Docker Commands"
	@echo "======================================"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'

up: ## Start all containers
	@cp -n .env.docker .env 2>/dev/null || true
	docker compose up -d
	@echo "\n✓ Application running at http://localhost:8000"

down: ## Stop all containers
	docker compose down

restart: ## Restart all containers
	docker compose restart

build: ## Build/rebuild containers
	docker compose build --no-cache

logs: ## View container logs
	docker compose logs -f

shell: ## Open shell in app container
	docker compose exec app sh

tinker: ## Open Laravel Tinker
	docker compose exec app php artisan tinker

migrate: ## Run migrations
	docker compose exec app php artisan migrate --force

seed: ## Seed database
	docker compose exec app php artisan db:seed --force

fresh: ## Fresh migration with seeding
	docker compose exec app php artisan migrate:fresh --seed --force

cache: ## Clear and rebuild caches
	docker compose exec app php artisan config:cache
	docker compose exec app php artisan route:cache
	docker compose exec app php artisan view:cache

clear: ## Clear all caches
	docker compose exec app php artisan cache:clear
	docker compose exec app php artisan config:clear
	docker compose exec app php artisan route:clear
	docker compose exec app php artisan view:clear

npm: ## Install npm dependencies
	docker compose exec node npm install

vite: ## Build frontend assets
	docker compose exec node npm run build

postgres: ## Open PostgreSQL CLI
	docker compose exec postgres psql -U postgres -d laravel_starter

redis: ## Open Redis CLI
	docker compose exec redis redis-cli

status: ## Show container status
	docker compose ps

destroy: ## Stop and remove all containers + volumes
	docker compose down -v --remove-orphans
	@echo "✓ All containers and volumes removed"
