<?php

class Comment
{
    public int $id;
    public int $article_id;
    public string $author_name;
    public string $content;
    public int $rating;
    public string $created_at;
    public int $status;

    public function __construct(
        int $id,
        int $article_id,
        string $author_name,
        string $content,
        int $rating,
        string $created_at,
        int $status
    ) {
        $this->id          = $id;
        $this->article_id  = $article_id;
        $this->author_name = $author_name;
        $this->content     = $content;
        $this->rating      = $rating;
        $this->created_at  = $created_at;
        $this->status      = $status;
    }
}
