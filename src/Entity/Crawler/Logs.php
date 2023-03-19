<?php

namespace App\Entity\Crawler;

use App\Repository\Crawler\LogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: LogsRepository::class, readOnly: true)]
#[ORM\Table(name: 'logs')]
class Logs
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(name: 'message', type: Types::TEXT)]
    private string $message;

    #[ORM\Column(name: 'entity_id', type: Types::TEXT, nullable: true)]
    private ?string $entityId;

    #[ORM\Column(name: 'entity_type', type: Types::TEXT, nullable: true)]
    private ?string $entityType;

    #[ORM\Column(name: 'entity', type: Types::TEXT, nullable: true)]
    private ?string $entity;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(name: 'deleted_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getEntityId(): ?string
    {
        return $this->entityId;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
