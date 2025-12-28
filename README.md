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

File: `README.md`
php artisan test
```
