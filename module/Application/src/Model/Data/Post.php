<?php

declare(strict_types=1);

namespace Application\Model\Data;

class Post
{
    /**
     * @var array $id
     */
    protected $id;

    /**
     * @var array $postsName
     */
    protected $postsName;

    public function getId(): array
    {
        return $this->id;
    }

    /**
     * @param array $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getPostsName(): array
    {
        return $this->postsName;
    }

    /**
     * @param array $postsName
     */
    public function setPostsName($postsName): void
    {
        $this->postsName = $postsName;
    }

    public function exchangeArray(array $data)
    {
        $this->id        = !empty($data['id']) ? $data['id'] : null;
        $this->postsName = !empty($data['name_post']) ? $data['name_post'] : null;
    }
}