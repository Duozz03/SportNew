<?php

class Category
{
    public int $id;
    public string $name;
    public string $slug;
    public string $created_at;

    public function __construct(
        int $id,
        string $name,
        string $slug,
        string $created_at
    ) {
        $this->id         = $id;
        $this->name       = $name;
        $this->slug       = $slug;
        $this->created_at = $created_at;
    }
}
