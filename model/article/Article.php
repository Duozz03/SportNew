<?php

class Article
{
    public int $id;
    public int $category_id;
    public string $title;
    public ?string $thumbnail;
    public ?string $short_description;
    public ?string $content;
    public string $created_at;
    public string $updated_at;
    public int $status;

    public function __construct(
        int $id,
        int $category_id,
        string $title,
        ?string $thumbnail,
        ?string $short_description,
        ?string $content,
        string $created_at,
        string $updated_at,
        int $status
    ) {
        $this->id                = $id;
        $this->category_id       = $category_id;
        $this->title             = $title;
        $this->thumbnail         = $thumbnail;
        $this->short_description = $short_description;
        $this->content           = $content;
        $this->created_at        = $created_at;
        $this->updated_at        = $updated_at;
        $this->status            = $status;
    }
}
