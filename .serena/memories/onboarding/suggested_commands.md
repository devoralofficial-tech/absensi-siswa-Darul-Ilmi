# Suggested Commands

Here are the commands commonly used in this Laravel project:

## Development Server
- Run the full development suite (Artisan serve + Vite + Queue + Logs):
  ```bash
  npm run dev
  ```
- Run Laravel local server:
  ```bash
  php artisan serve
  ```
- Run Vite build for production assets:
  ```bash
  npm run build
  ```

## Database
- Run database migrations:
  ```bash
  php artisan migrate
  ```
- Run migrations and seed database:
  ```bash
  php artisan migrate --seed
  ```
- Fresh migration and seed:
  ```bash
  php artisan migrate:fresh --seed
  ```

## Caching & Utilities
- Clear cache and optimization:
  ```bash
  php artisan optimize:clear
  ```
- Create storage symbolic link:
  ```bash
  php artisan storage:link
  ```
