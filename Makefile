## Variables
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m
COLOR_ERROR   = \033[0;31m

CURRENT_FOLDER_NAME = $(shell basename $(CURDIR))

## Aliases
DC = docker-compose

## Help
help:
	@echo "$(COLOR_COMMENT)Usage:$(COLOR_RESET)"
	@echo " make [target]\n"
	@echo "$(COLOR_COMMENT)Available targets:$(COLOR_RESET)"
	@awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " $(COLOR_INFO)%-16s$(COLOR_RESET) %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Build and start all application components
setup:
	@echo "$(COLOR_INFO)==> Building and running docker images ...$(COLOR_RESET)"
		@$(DC) build --no-cache
		@$(DC) up -d --remove-orphans

	@echo "$(COLOR_INFO)==> Installing composer dependencies ...$(COLOR_RESET)"
		@$(DC) exec app composer install

	@echo "$(COLOR_INFO)==> Verifying .env and generating encryption key ...$(COLOR_RESET)"
		@$(DC) exec app php -r "file_exists('.env') || copy('.env.example', '.env');"
		@$(DC) exec app php artisan key:generate --ansi

	@echo "$(COLOR_INFO)==> Creating public symbolic link from storage ...$(COLOR_RESET)"
		@$(DC) exec app php artisan storage:link

	@echo "$(COLOR_INFO)==> Running migrations & seeding ...$(COLOR_RESET)"
		@$(DC) exec app php artisan migrate --seed

	@echo "$(COLOR_INFO)==> Generating passport keys ...$(COLOR_RESET)"
		@$(DC) exec app php artisan passport:install $(out)

	@echo "$(COLOR_INFO)==> Installing NPM dependencies ...$(COLOR_RESET)"
		@$(DC) exec front npm ci

	@echo "$(COLOR_INFO)==> Building NPM ...$(COLOR_RESET)"
		@$(DC) exec -d front npm run dev

	@echo "$(COLOR_COMMENT)Admin: $(COLOR_RESET)http://localhost"
	@echo "$(COLOR_COMMENT)Mailhog: $(COLOR_RESET)http://localhost:8025"

## Clear all application data and components
clean:
	@echo "$(COLOR_INFO)==> Cleaning node_modules NPM ...$(COLOR_RESET)"
		@$(DC) run front npm cache clean --force
		@$(DC) run front rm -rf node_modules

	@echo "$(COLOR_INFO)==> Cleaning all laravel caches ...$(COLOR_RESET)"
		@make cache_clear

	@echo "$(COLOR_INFO)==> Removing containers ...$(COLOR_RESET)"
		@$(DC) down

	@echo "$(COLOR_INFO)==> Cleaning volumes ...$(COLOR_RESET)"
		@make remove_volumes

	@echo "$(COLOR_COMMENT)Completed!$(COLOR_RESET)"

## Initialize docker containers
start:
	@$(DC) stop
	@$(DC) up -d --remove-orphans

## Stop docker containers
stop:
	@$(DC) stop

## Restart docker containers
restart:
	@make stop
	@make start
	@echo "$(COLOR_COMMENT)Completed!$(COLOR_RESET)"

## Run custom command "php artisan upgrade --dev"
upgrade_dev:
	@$(DC) exec app php artisan upgrade --dev

## Clear all laravel cache
cache_clear:
	@$(DC) exec app php artisan cache:clear
	@$(DC) exec app php artisan route:cache
	@$(DC) exec app php artisan config:cache
	@$(DC) exec app php artisan view:clear

remove_volumes:
	@docker volume rm $(CURRENT_FOLDER_NAME)_postgres-data
	@docker volume rm $(CURRENT_FOLDER_NAME)_redis-data
