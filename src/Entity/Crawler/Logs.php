<?php

namespace App\Entity\Crawler;

use App\Repository\Crawler\LogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogsRepository::class, readOnly: true)]
#[ORM\Table(name: 'logs')]
class Logs extends AbstractBaseEntity
{
    #[ORM\Column(name: 'message', type: Types::TEXT)]
    private string $message = '';

    #[ORM\Column(name: 'entity_id', type: Types::TEXT, nullable: true)]
    private ?string $entityId = null;

    #[ORM\Column(name: 'entity_type', type: Types::TEXT, nullable: true)]
    private ?string $entityType = null;

    #[ORM\Column(name: 'entity', type: Types::TEXT, nullable: true)]
    private ?string $entity = null;

    #[ORM\Column(name: 'deleted_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

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

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
