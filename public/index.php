<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/routers.php';

use Core\Config;

function loadenv()
{
    $config = new Config($_SERVER['HTTP_HOST']);

    if ($config->isLocalEnvironment()) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    }
}

function generatePdo(): PDO
{
    $host = $_ENV['PG_LOCAL_HOST'];
    $database = $_ENV['PG_LOCAL_DATABASE'];

    $dsn = "pgsql:host={$host};port=5432;dbname={$database}";
    $user = $_ENV['PG_LOCAL_USER'];
    $password = $_ENV['PG_LOCAL_PASSWORD'];

    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$path = parse_url($uri, PHP_URL_PATH);

$router->dispatch($method, $path);