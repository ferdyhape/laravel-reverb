## Installation

1. Install Reverb requirement

```bash
php artisan install:broadcasting # Choose Reverb as broadcasting driver
```

2. Create Event

```bash
php artisan make:event MessageSent
```

## How to Run (locally)

1. Run PHP Server

    ```bash
    php artisan serve
    ```

2. Run Vite dev server or build it

    ```bash
    npm run dev
    ```

    ```bash
    npm run build
    ```

3. Run Reverb artisan command
    ```bash
    php artisan reverb:start
    ```
4. Run laravel workers
    ```bash
    php artisan queue:work
    ```
