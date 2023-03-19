<?php

namespace App\Entity\Crawler;

use App\Repository\Crawler\SoftwareRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Yaml\Yaml;

#[ORM\Entity(repositoryClass: SoftwareRepository::class, readOnly: true)]
#[ORM\Table(name: 'software')]
class Software extends AbstractBaseEntity
{
    #[ORM\Column(name: 'software_url_id', type: UuidType::NAME)]
    private ?Uuid $softwareUrlId = null;

    #[ORM\Column(name: 'publiccode_yml', type: Types::TEXT, nullable: true)]
    private ?string $publiccodeYml = null;

    #[ORM\Column(name: 'active')]
    private bool $active = true;

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

    private ?array $publiccodeData = null;

    public function __get(string $name)
    {
        if (null === $this->publiccodeData) {
            $this->publiccodeData = Yaml::parse($this->publiccodeYml ?? '');
        }

        return $this->publiccodeData[$name] ?? null;
    }
}
