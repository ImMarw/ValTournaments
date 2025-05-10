<?php
namespace App\Model;

use Nette\Database\Explorer;

final class ForumManager
{
    private Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }

    public function getThreads(): \Nette\Database\Table\Selection
    {
        return $this->database->table('forum_threads')->order('created_at DESC');
    }

    public function getThreadById(int $id): ?\Nette\Database\Table\ActiveRow
    {
        return $this->database->table('forum_threads')->get($id);
    }

    public function getPosts(int $threadId): \Nette\Database\Table\Selection
    {
        return $this->database->table('forum_posts')
            ->where('thread_id', $threadId)
            ->order('created_at ASC')
            ->select('*, users.username');
    }

    public function addThread(string $title, int $authorId): int
    {
        $row = $this->database->table('forum_threads')->insert([
            'title' => $title,
            'author_id' => $authorId,
        ]);

        return $row->id;
    }

    public function addPost(int $threadId, string $content, int $authorId): void
    {
        $this->database->table('forum_posts')->insert([
            'thread_id' => $threadId,
            'content' => $content,
            'author_id' => $authorId,
        ]);
    }

    public function getPostsWithUsernames(int $threadId): array
    {
        return $this->database->query('
        SELECT forum_posts.*, users.username
        FROM forum_posts
        JOIN users ON users.id = forum_posts.author_id
        WHERE forum_posts.thread_id = ?
    ', $threadId)->fetchAll();
    }

}