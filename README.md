# Laravel-Demo-Mini-Helpdesk-Tickets

A **Dockerized Laravel demo app** that showcases:

- Auth (minimal login/register)
- Tickets + Comments CRUD
- Authorization via Policies
- API with token auth (Sanctum)
- Events + Listeners (TicketCreated → queued email)
- Queue worker + Scheduler containers
- Redis cache/session/queue
- Seeds + factories
- Feature tests

## Quick start

```bash
make up
make install
```

App: http://localhost:8080  
Mailpit: http://localhost:8025

### Demo accounts

- Admin: `admin@example.test` / `password`
- Agent: `agent@example.test` / `password`
- User:  `user@example.test` / `password`

## API

Create token (login):

```bash
curl -X POST http://localhost:8080/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.test","password":"password"}'
```

Then:

```bash
curl http://localhost:8080/api/tickets \
  -H "Authorization: Bearer <TOKEN>"
```

## Development

```bash
make bash
php artisan test
```
