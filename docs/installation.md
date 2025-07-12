# Installation Guide

This guide will walk you through the process of setting up LinguSID on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed:

*   PHP (version 8.2 or higher)
*   Composer
*   Node.js (LTS version)
*   Bun (recommended for JavaScript dependencies)
*   MySQL or PostgreSQL

## Steps

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/wahyulingu/LinguSID.git
    cd LinguSID
    ```

2.  **Install PHP dependencies:**

    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**

    ```bash
    bun install
    # or npm install / yarn install
    ```

4.  **Copy environment file:**

    ```bash
    cp .env.example .env
    ```

5.  **Generate application key:**

    ```bash
    php artisan key:generate
    ```

6.  **Configure your database:**

    Edit the `.env` file and update the database connection details.

7.  **Run database migrations:**

    ```bash
    php artisan migrate
    ```

8.  **Seed the database (optional):**

    ```bash
    php artisan db:seed
    ```

9.  **Build assets:**

    ```bash
    bun run build
    # or npm run build / yarn build
    ```

10. **Start the development server:**

    ```bash
    php artisan serve
    ```

    You can now access the application at `http://localhost:8000`.
