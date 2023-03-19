<?php

namespace App\Entity\Crawler;

use App\Repository\PublisherCodeHostingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

#[ORM\Entity(repositoryClass: PublisherCodeHostingRepository::class)]
#[ORM\Table(name: 'publishers_code_hosting')]
class PublisherCodeHosting extends AbstractBaseEntity implements \JsonSerializable
{
    #[ORM\Column(name: 'url', type: Types::TEXT)]
    #[NotBlank]
    #[Url]
    private ?string $url = null;

    #[ORM\Column(name: 'group', type: Types::BOOLEAN)]
    private ?bool $isGroup = null;

    #[ORM\ManyToOne(inversedBy: 'codeHosting')]
    #[ORM\JoinColumn(name: 'publisher_id', nullable: false)]
    private ?Publisher $publisher;

    public function __toString(): string
    {
        return $this->url ?? '';
    }

    /**
     * @see https://github.com/italia/developers-italia-api/blob/main/internal/common/requests.go
     */
    public function jsonSerialize(): mixed
    {
        return [
          'url' => $this->url,
          'group' => $this->isGroup,
        ];
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): PublisherCodeHosting
    {
        $this->url = $url;

        return $this;
    }

    public function getIsGroup(): ?bool
    {
        return $this->isGroup;
    }

    public function setIsGroup(?bool $isGroup): PublisherCodeHosting
    {
        $this->isGroup = $isGroup;

        return $this;
    }

    public function getPublisher(): Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): PublisherCodeHosting
    {
        $this->publisher = $publisher;

        return $this;
    }
}
