up:
	@docker compose up -d
down:
	@docker compose down
build:
	@docker compose build
logs:
	@docker compose logs -f
vendor:
  @docker compose run --rm telegram-bot composer install