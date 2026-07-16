# Task Completion Checklist

When completing a task or submitting a pull request, ensure the following steps are performed:

1. **Lint and Format Code**:
   Run Laravel Pint to format files:
   ```bash
   ./vendor/bin/pint
   ```

2. **Verify Tests**:
   Run the application test suite to ensure no regressions:
   ```bash
   php artisan test
   ```

3. **Check Frontend Assets**:
   Run production build to compile resources and check for any JS/CSS errors:
   ```bash
   npm run build
   ```

4. **Verify Migrations**:
   If migrations were added/modified, check they can run forward and backward:
   ```bash
   php artisan migrate:rollback
   php artisan migrate
   ```
