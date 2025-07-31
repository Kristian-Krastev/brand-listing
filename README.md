# Brand Listing Application

## Setup Instructions

Follow these steps to run the application:

1. Run composer install to install PHP dependencies:
```
composer install
```

2. Copy the environment file:
```
cp .env.example .env
```

3. Start the Docker containers using Laravel Sail:
```
./vendor/bin/sail up
```

4. Generate API key:
```
./vendor/bin/sail artisan key:generate
```

If you encounter permissions issues, you may need to give permissions to the storage directory:
```
chmod -R 777 storage
```