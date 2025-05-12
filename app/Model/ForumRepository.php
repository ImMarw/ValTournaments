<?php
namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

class ForumRepository
{
    public function __construct(private Explorer $db) {}

    public function getAllTopics(): Selection
    {
        return $this->db->table('forum_topics')
            ->order('created_at DESC');
    }

    public function getTopic(int $id)
    {
        return $this->db->table('forum_topics')->get($id);
    }

    public function getPosts(int $topicId): Selection
    {
        return $this->db->table('forum_posts')
            ->where('topic_id', $topicId)
            ->order('created_at DESC');  // ← newest first
    }

    public function addTopic(int $userId, string $title): int
    {
        $row = $this->db->table('forum_topics')->insert([
            'user_id'    => $userId,
            'title'      => $title,
        ]);
        return $row->id;
    }

    public function addPost(int $topicId, int $userId, string $content): int
    {
        $row = $this->db->table('forum_posts')->insert([
            'topic_id'   => $topicId,
            'user_id'    => $userId,
            'content'    => $content,
        ]);
        return $row->id;
    }
}