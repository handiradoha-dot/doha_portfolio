<?php

$databaseUrl = getenv('DATABASE_URL');

if (!$databaseUrl) {
    http_response_code(500);
    exit('Database configuration is missing.');
}

$database = parse_url($databaseUrl);

if (!$database || empty($database['host']) || empty($database['user']) || empty($database['path'])) {
    http_response_code(500);
    exit('Database configuration is invalid.');
}

$host = $database['host'];
$port = $database['port'] ?? 5432;
$dbname = ltrim($database['path'], '/');
$user = rawurldecode($database['user']);
$password = rawurldecode($database['pass'] ?? '');
$sslMode = $database['query'] ?? '';
parse_str($sslMode, $query);
$sslMode = $query['sslmode'] ?? 'require';

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslMode",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    error_log('Tourism database connection failed: ' . $e->getMessage());
    http_response_code(500);
    exit('The tourism database is unavailable.');
}
?>
