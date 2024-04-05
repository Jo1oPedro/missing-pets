<?php

namespace App\DTO;

use Cassandra\Date;

class PetPostDTO implements DTO
{
    public function __construct(
        private string $id,
        private string $name,
        private string $coordinate_x,
        private string $coordinate_y,
        private string $breed,
        private string $type,
        private string $additional_info,
        private string $user_id,
        private string $created_at,
        private string $updated_at
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCoordinateX(): string
    {
        return $this->coordinate_x;
    }

    public function getCoordinateY(): string
    {
        return $this->coordinate_y;
    }

    public function getBreed(): string
    {
        return $this->breed;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAddtionalInfo(): string
    {
        return $this->addtional_info;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getAdditionalInfo(): string
    {
        return $this->additional_info;
    }

    public function getCreatedAt(): string
    {
        return new \DateTime($this->created_at);
    }

    public function getUpdatedAt(): string
    {
        return new \DateTime($this->updated_at);
    }
}
