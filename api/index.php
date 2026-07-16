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

// [VERCEL FIX] Ensure required storage directories exist in /tmp
$storagePath = $app->storagePath();
$directories = [
    'app',
    'framework/views',
    'framework/cache/data',
    'framework/sessions',
    'logs'
];

foreach ($directories as $dir) {
    if (!is_dir("{$storagePath}/{$dir}")) {
        mkdir("{$storagePath}/{$dir}", 0777, true);
    }
}

// Handle the request
$app->handleRequest(Request::capture());
