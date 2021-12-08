# Constant variables
DOTENV_FILE = --env-file .env.local

# Overridable variables
service = php-fpm

build:
	docker compose $(DOTENV_FILE) build

up:
	docker compose $(DOTENV_FILE) up -d

down:
	docker compose $(DOTENV_FILE) down

logs:
	docker compose $(DOTENV_FILE) logs -f

status:
	docker compose $(DOTENV_FILE) ps

shell:
	docker compose $(DOTENV_FILE) exec $(service) /bin/sh
