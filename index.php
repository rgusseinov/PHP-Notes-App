<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Database.php';

try {
    Database::getConnection();
    $message = 'Database connected';
} catch (Throwable $e) {
    error_log($e->getMessage());
    $message = 'Something went wrong. Please try again later.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes App</title>
</head>
<body>
    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
</body>
</html>
