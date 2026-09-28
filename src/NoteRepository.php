<?php

declare(strict_types=1);

class NoteRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function all(): array
    {
        $statement = $this->pdo->query('SELECT * FROM notes ORDER BY created_at DESC, id DESC');

        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $statement->execute(['id' => $id]);

        $note = $statement->fetch();

        return $note === false ? null : $note;
    }

    public function create(string $title, string $content, ?string $image = null): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO notes (title, content, image) VALUES (:title, :content, :image)'
        );
        $statement->execute([
            'title' => $title,
            'content' => $content,
            'image' => $image,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, string $title, string $content): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE notes SET title = :title, content = :content WHERE id = :id'
        );

        $statement->execute([
            'title' => $title,
            'content' => $content,
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare('DELETE FROM notes WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->rowCount() > 0;
    }
}
