This is Laravel Authorization Server

Supposed to be used with <https://github.com/ulcuber/laravel-passport-introspection>

# Init

```bash
cp .env.example .env
# fill

./artisan migrate
```

# Dev

```bash
composer run dev

# only JS
bun run dev
```

# Prod

```bash
bun run build
```
