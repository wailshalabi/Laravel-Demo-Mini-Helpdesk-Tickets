up:
	docker compose up -d --build

down:
	docker compose down

logs:
	docker compose logs -f --tail=200

bash:
	docker compose exec app sh

install:
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate --seed
	docker compose exec app php artisan storage:link || true

fresh:
	docker compose exec app php artisan migrate:fresh --seed

test:
	docker compose exec app php artisan test
