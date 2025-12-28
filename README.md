# Laravel Demo — Mini Helpdesk Tickets

This repository is a small, Dockerized Laravel demo application that implements a simple ticketing system. It's intended for testing, learning, and demonstrating how to run a Laravel app with Docker containers (app, worker, scheduler, Redis, MySQL, and Mailpit).

Key features:

- **Authentication** (simple login/register)
- **Tickets & Comments** CRUD
- **Authorization** using Policies (admin / agent / user roles)
- **REST API** protected with Sanctum tokens
- **Events & Listeners** (ticket created → queued email)
- **Queue worker & Scheduler** running in separate containers
- **Redis** used for cache, sessions and queues
- **Database seeds & factories** for demo data
- **Feature tests** (PHPUnit)

## Quick start

1. Start the demo environment:

```powershell
make up
```

2. Install dependencies and prepare the app (run once):

```powershell
make install
```

Before running `make install`, create your environment config file from the example if you don't already have one:

Unix / macOS:

```bash
cp src/.env.example src/.env
```

Windows PowerShell:

```powershell
Copy-Item src\.env.example src\.env
```

After creating the `.env` file you can edit any environment values (ports, DB credentials, etc.) as needed.

Open the app at: http://localhost:8080

Mail UI (Mailpit): http://localhost:8025

### Demo accounts

- **Admin:** `admin@example.test` / `password`
- **Agent:** `agent@example.test` / `password`
- **User:** `user@example.test` / `password`

## API

Create a token (login):

```powershell
curl -X POST http://localhost:8080/api/login `
  -H "Content-Type: application/json" `
  -d '{"email":"user@example.test","password":"password"}'
```

Then call the API (replace `<TOKEN>`):

```powershell
curl http://localhost:8080/api/tickets \
  -H "Authorization: Bearer <TOKEN>"
```

## Notes for developers

- The project is intentionally minimal and focused on demonstrating Laravel features running in Docker.
- The `worker` and `scheduler` containers process queues and scheduled tasks — ensure these services have the proper environment variables when running inside Docker.
- To run the test suite inside the `app` container:

```powershell
make test
```

### No `make` installed?

If your development machine doesn't have `make` available, you can run the equivalent Docker Compose commands directly. Below are the common `Makefile` targets and their `docker compose` equivalents:

- `make up` → `docker compose up -d --build`
- `make down` → `docker compose down`
- `make logs` → `docker compose logs -f --tail=200`
- `make bash` → `docker compose exec app sh`
- `make install` →
  - `docker compose exec app composer install`
  - `docker compose exec app php artisan key:generate`
  - `docker compose exec app php artisan migrate --seed`
  - `docker compose exec app php artisan storage:link` (may be optional)
- `make fresh` → `docker compose exec app php artisan migrate:fresh --seed`
- `make test` → `docker compose exec app php artisan test`

These commands are the same tasks run by the `Makefile` targets; use them when `make` is not available on your system.

If you want, I can also:

- Run the test suite locally and report results
- Add a short CONTRIBUTING or DEVELOPMENT section with common workflows
- Commit these README changes for you

---

```powershell
php artisan test
```

## Setup & Permissions (storage folders)

The application requires writable `storage` and `bootstrap/cache` directories. The Compose setup uses a named volume for `storage` so the container can manage permissions, but you may still need to ensure correct ownership/permissions inside the container.

Recommended steps after starting the environment:

1. Start containers:

```powershell
docker compose up -d --build
```

2. Create required folders (if missing) and set ownership/permissions from the `app` container:

```powershell
docker compose exec app sh -c "mkdir -p storage/framework/{sessions,views,cache} bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache"
```

3. Run the Laravel storage link and other setup tasks:

```powershell
docker compose exec app php artisan storage:link
docker compose exec app composer install
docker compose exec app php artisan migrate --seed
```

Notes:

- If you also use the `worker` or `scheduler` containers and they are not sharing the same named `app_storage` volume for `storage`, run the `chown` command in those containers too:

```powershell
docker compose exec worker sh -c "chown -R www-data:www-data storage bootstrap/cache"
docker compose exec scheduler sh -c "chown -R www-data:www-data storage bootstrap/cache"
```

- On Windows hosts with bind mounts, `chown` may have no effect because the host filesystem manages permissions. This Compose setup already uses a named volume for `storage` (`app_storage`), so the above `chown` should work. If you still experience permission issues on Windows, try using the named volume (ensure `app_storage` is mounted) or run the commands inside the container as shown above.

- The project's Dockerfile already sets ownership for `storage` and `bootstrap/cache` at build time, but running the `chown` command at runtime ensures correct permissions if volumes were recreated or mounted from the host.

If you'd like, I can add a small `scripts/` helper or Makefile target that runs these commands for your platform.

## phpMyAdmin (local development)

A `phpMyAdmin` service is available in the Compose setup to inspect the database during local development.

- **URL:** http://localhost:8081
- **Login (local dev):** `root` / `rootsecret`

You can also use the application DB user defined in `src/.env` (for example `laravel` / `secret`).

Security note: phpMyAdmin is provided for local development convenience only — do not expose it to public networks or production environments. If port `8081` conflicts with another service, change the host mapping in `docker-compose.yml`.
