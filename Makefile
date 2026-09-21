COMPOSE := docker compose
SERVICE := laravel.test

.PHONY: help install up down rebuild logs shell artisan migrate seed fresh build dev

help:
	@echo "Targets:"
	@echo "  make install   Fresh one-command setup (build, composer, npm, migrate, seed)"
	@echo "  make up        docker compose up -d"
	@echo "  make down      docker compose down"
	@echo "  make rebuild   Rebuild images and start"
	@echo "  make logs      Tail container logs"
	@echo "  make shell     Open a bash shell in the app container"
	@echo "  make artisan   Run php artisan (e.g. make artisan migrate)"
	@echo "  make migrate   Run database migrations"
	@echo "  make seed      Run database seeders"
	@echo "  make fresh     Drop all tables, migrate and reseed"
	@echo "  make build     Compile frontend assets (npm run build)"
	@echo "  make dev       Start Vite dev server (HMR on :5173)"

install:
	@test -f .env || (cp .env.example .env && echo "==> .env created from .env.example")
	$(COMPOSE) up -d --build
	$(COMPOSE) exec -T $(SERVICE) composer install --no-interaction --prefer-dist --optimize-autoloader
	$(COMPOSE) exec -T $(SERVICE) npm install
	$(COMPOSE) exec -T $(SERVICE) npm run build
	$(COMPOSE) exec -T $(SERVICE) php artisan key:generate
	$(COMPOSE) exec -T $(SERVICE) php artisan migrate --force --seed
	$(COMPOSE) exec -T $(SERVICE) php artisan storage:link
	@echo "==> Done. Site: http://localhost  Admin: /admin/login (admin@innovus.com.bd / Innovus@2026)"

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

rebuild:
	$(COMPOSE) up -d --build

logs:
	$(COMPOSE) logs -f $(SERVICE)

shell:
	$(COMPOSE) exec $(SERVICE) bash

artisan:
	$(COMPOSE) exec $(SERVICE) php artisan $(filter-out $@,$(MAKECMDGOALS))

migrate:
	$(COMPOSE) exec $(SERVICE) php artisan migrate --force

seed:
	$(COMPOSE) exec $(SERVICE) php artisan db:seed --force

fresh:
	$(COMPOSE) exec $(SERVICE) php artisan migrate:fresh --seed --force

build:
	$(COMPOSE) exec $(SERVICE) npm run build

dev:
	$(COMPOSE) exec $(SERVICE) npm run dev

%:
	@: