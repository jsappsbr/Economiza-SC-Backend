# Anotei backend

### Commands

- Migrate database and seed

```bash
php artisan migrate:fresh --seed
```

- Run products scraper

```bash
php artisan app:products-scraper {market} {--skip-scraper} {--skip-save}
```
