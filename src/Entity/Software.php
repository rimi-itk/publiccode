<?php

namespace App\Entity;

use App\Repository\SoftwareRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Yaml\Yaml;

#[ORM\Entity(repositoryClass: SoftwareRepository::class)]
class Software
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: UuidType::NAME)]
    private ?Uuid $id = null;

    #[ORM\Column(name: 'software_url_id', type: UuidType::NAME)]
    private ?Uuid $softwareUrlId = null;

    #[ORM\Column(name: 'publiccode_yml', type: Types::TEXT, nullable: true)]
    private ?string $publiccodeYml = null;

    #[ORM\Column(name: 'active')]
    private bool $active = true;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSoftwareUrlId(): ?Uuid
    {
        return $this->softwareUrlId;
    }

    public function getPubliccodeYml(): ?string
    {
        return $this->publiccodeYml;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    private ?array $publiccodeData = null;

    public function __get(string $name)
    {
        if (null === $this->publiccodeData) {
            $this->publiccodeData = Yaml::parse($this->publiccodeYml ?? '');
        }

        return $this->publiccodeData[$name] ?? null;
    }
}
