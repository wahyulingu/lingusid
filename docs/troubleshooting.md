# Troubleshooting Guide

This guide provides solutions to common issues you might encounter while using or developing LinguSID.

## Common Issues

### 1. `composer install` fails

**Problem:** Composer fails to install dependencies.

**Solution:**
*   Ensure you have a stable internet connection.
*   Clear Composer cache: `composer clear-cache`
*   Update Composer: `composer self-update`
*   Check your PHP version. LinguSID requires PHP 8.2 or higher.

### 2. `bun install` fails

**Problem:** Bun fails to install JavaScript dependencies.

**Solution:**
*   Ensure you have Bun installed correctly. Refer to the [Bun documentation](https://bun.sh/docs/installation) for installation instructions.
*   Try clearing Bun cache: `bun install --force`
*   If Bun is not working, try `npm install` or `yarn install` as alternatives.

### 3. Database connection errors

**Problem:** The application cannot connect to the database.

**Solution:**
*   Verify your database credentials in the `.env` file (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
*   Ensure your database server is running.
*   Check if the database specified in `.env` exists.
*   If using MySQL, ensure the `pdo_mysql` extension is enabled in your `php.ini`.

### 4. `php artisan migrate` errors

**Problem:** Migrations fail to run.

**Solution:**
*   Ensure your database connection is correctly configured.
*   Check for syntax errors in your migration files.
*   If you have previously run migrations and are encountering issues, you might need to reset your database (use with caution, this will delete all data):
    ```bash
    php artisan migrate:fresh
    ```

### 5. Assets not loading (CSS/JS)

**Problem:** Styles or scripts are not applied in the browser.

**Solution:**
*   Ensure you have run `bun run build` (or `npm run build`/`yarn build`) to compile your assets.
*   Check your browser's developer console for any errors related to loading assets.
*   Verify that the `public/build` directory exists and contains the compiled assets.

## Getting Further Help

If you encounter an issue not listed here, please:

1.  **Search existing issues:** Check the GitHub Issues page for similar problems.
2.  **Open a new issue:** If your issue is new, open a detailed issue with steps to reproduce, error messages, and your environment details.
3.  **Join our community:** (If applicable, provide links to Discord, Slack, etc.)
