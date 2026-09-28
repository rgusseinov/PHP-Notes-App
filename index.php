<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/NoteRepository.php';

session_start();

function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        http_response_code(400);
        echo 'Invalid request.';
        exit;
    }
}

try {
    $repository = new NoteRepository(Database::getConnection());
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo 'Something went wrong. Please try again later.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create') {
    $title = trim((string) ($_POST['title'] ?? ''));
    $content = trim((string) ($_POST['content'] ?? ''));

    $errors = [];
    if ($title === '') {
        $errors['title'] = 'Title is required.';
    } elseif (mb_strlen($title) > 255) {
        $errors['title'] = 'Title must be at most 255 characters.';
    }
    if ($content === '') {
        $errors['content'] = 'Content is required.';
    }

    if ($errors !== []) {
        $_SESSION['flash'] = [
            'errors' => $errors,
            'old' => ['title' => $title, 'content' => $content],
        ];
        header('Location: index.php');
        exit;
    }

    $repository->create($title, $content);
    header('Location: index.php');
    exit;
}

$errors = [];
$old = ['title' => '', 'content' => ''];

if (!empty($_SESSION['flash'])) {
    $errors = $_SESSION['flash']['errors'] ?? [];
    $old = $_SESSION['flash']['old'] ?? $old;
    unset($_SESSION['flash']);
}

$notes = $repository->all();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes App</title>
</head>
<body>
    <h1>Notes</h1>

    <?php if ($errors !== []): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li><?php echo h($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="index.php">
        <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION['csrf_token']); ?>">
        <input type="hidden" name="action" value="create">

        <p>
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title" maxlength="255" value="<?php echo h($old['title']); ?>">
        </p>

        <p>
            <label for="content">Content</label><br>
            <textarea id="content" name="content" rows="5"><?php echo h($old['content']); ?></textarea>
        </p>

        <p>
            <button type="submit">Add note</button>
        </p>
    </form>

    <?php if ($notes === []): ?>
        <p>No notes yet.</p>
    <?php else: ?>
        <?php foreach ($notes as $note): ?>
            <article>
                <h2><?php echo h($note['title']); ?></h2>
                <p><?php echo nl2br(h($note['content'])); ?></p>
                <p><small><?php echo h($note['created_at']); ?></small></p>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
