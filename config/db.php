<?php
/**
 * Database Configuration & Connection
 * Reads credentials from the .env file in the project root.
 */

$envPath = __DIR__ . '/../.env';

if (!file_exists($envPath)) {
    die('Error: .env file is missing. Please copy .env.example to .env.');
}

// Parse key=value pairs from .env using native PHP function (no Composer needed)
$env = parse_ini_file($envPath);

$dbHost = $env['DB_HOST'] ?? '127.0.0.1';
$dbPort = (int) ($env['DB_PORT'] ?? 3306);
$dbName = $env['DB_NAME'] ?? 'simple_php_crud';
$dbUser = $env['DB_USER'] ?? 'root';
$dbPass = $env['DB_PASS'] ?? '';

// Disable mysqli automatic exception throwing so we can show friendly errors
mysqli_report(MYSQLI_REPORT_OFF);

// Connect to MySQL using procedural mysqli
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

if (!$conn) {
    die(
        'Database Connection Failed: ' . mysqli_connect_error() .
        '<br><small>Tip: Make sure MySQL is running on port ' . $dbPort .
        ' and you have imported <code>database/schema.sql</code>.</small>'
    );
}

// Use UTF-8 encoding
mysqli_set_charset($conn, 'utf8mb4');
