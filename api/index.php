<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// [VERCEL FIX] Override storage path to /tmp because Vercel filesystem is read-only
$app->useStoragePath($_ENV['APP_STORAGE'] ?? '/tmp/storage');

// [VERCEL FIX] Override cache paths to /tmp
$_ENV['APP_SERVICES_CACHE'] = '/tmp/storage/bootstrap/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/storage/bootstrap/cache/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/storage/bootstrap/cache/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/storage/bootstrap/cache/routes-v7.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/storage/bootstrap/cache/events.php';

// [VERCEL FIX] Ensure required storage directories exist in /tmp
$storagePath = $app->storagePath();
$directories = [
    'app',
    'framework/views',
    'framework/cache/data',
    'framework/sessions',
    'logs',
    'bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir("{$storagePath}/{$dir}")) {
        mkdir("{$storagePath}/{$dir}", 0777, true);
    }
}

try {
    // Handle the request
    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    // Prevent double-crash by catching the original exception
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "ORIGINAL EXCEPTION:\n";
    echo $e->getMessage() . "\n";
    echo $e->getFile() . " on line " . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
    exit;
}
