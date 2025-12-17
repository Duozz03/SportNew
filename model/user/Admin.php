<?php
class Admin
{
    public int $id;
    public string $username;
    public string $password;
    public string $created_at;

    public function __construct(
        int $id,
        string $username,
        string $password,
        string $created_at
    ) {
        $this->id         = $id;
        $this->username   = $username;
        $this->password   = $password;
        $this->created_at = $created_at;
    }
}
