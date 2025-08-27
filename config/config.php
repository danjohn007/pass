<?php
/**
 * Configuration file for PASS - Psychological Assessment and Support System
 */

// Auto-detect base URL
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = dirname($script);
    return $protocol . '://' . $host . ($path === '/' ? '' : $path);
}

// Base configuration
define('BASE_URL', getBaseUrl());
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'pass_db');
define('DB_USER', 'pass_user');
define('DB_PASS', 'pass_password123');
define('DB_CHARSET', 'utf8mb4');

// For demo purposes, use SQLite if MySQL is not available
define('USE_SQLITE', true);
define('SQLITE_PATH', ROOT_PATH . '/database/pass.db');

// Application settings
define('APP_NAME', 'PASS - Plataforma de Autoevaluación y Seguimiento Psicológico');
define('APP_VERSION', '1.0.0');
define('TIMEZONE', 'America/Mexico_City');

// Security settings
define('SESSION_LIFETIME', 3600); // 1 hour
define('PASSWORD_MIN_LENGTH', 8);
define('ENCRYPTION_KEY', 'pass_encryption_key_2024'); // Change this in production

// Set timezone
date_default_timezone_set(TIMEZONE);

// Start session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.use_strict_mode', 1);
session_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>