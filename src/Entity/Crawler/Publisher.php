<?php

namespace App\Entity\Crawler;

use App\Repository\Crawler\PublisherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

#[ORM\Entity(repositoryClass: PublisherRepository::class, readOnly: true)]
#[ORM\Table(name: 'publishers')]
class Publisher extends AbstractBaseEntity implements \JsonSerializable
{
    #[ORM\Column(name: 'email', type: Types::TEXT, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'description', type: Types::TEXT)]
    #[NotBlank]
    private string $description;

    #[ORM\Column(name: 'active', type: Types::BOOLEAN)]
    private bool $active = true;

    #[ORM\Column(name: 'alternative_id', type: Types::TEXT, nullable: true)]
    private ?string $alternativeId = null;

    #[ORM\OneToMany(mappedBy: 'publisher', targetEntity: PublisherCodeHosting::class)]
    #[Valid]
    #[Count(min: 1)]
    private Collection $codeHosting;

    public function __construct()
    {
        $this->codeHosting = new ArrayCollection();
    }

    /**
     * @see https://github.com/italia/developers-italia-api/blob/main/internal/common/requests.go
     */
    public function jsonSerialize(): mixed
    {
        return [
            'email' => $this->email,
            'description' => $this->description,
            'active' => $this->active,
            'alternativeId' => $this->alternativeId,
            'codeHosting' => $this->codeHosting->toArray(),
        ];
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setAlternativeId(?string $alternativeId): self
    {
        $this->alternativeId = $alternativeId;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAlternativeId(): ?string
    {
        return $this->alternativeId;
    }

    /**
     * @return Collection<int, PublisherCodeHosting>
     */
    public function getCodeHosting(): Collection
    {
        return $this->codeHosting;
    }

    /**
     * @param Collection<int, PublisherCodeHosting> $codeHosting
     */
    public function setCodeHosting(Collection $codeHosting): self
    {
        $this->codeHosting = $codeHosting;

        return $this;
    }

    public function addCodeHosting(PublisherCodeHosting $codeHosting): self
    {
        if (!$this->codeHosting->contains($codeHosting)) {
            $this->codeHosting->add($codeHosting);
            $codeHosting->setPublisher($this);
        }

        return $this;
    }

    public function removeCodeHosting(PublisherCodeHosting $codeHosting): self
    {
        if ($this->codeHosting->removeElement($codeHosting)) {
            // set the owning side to null (unless already changed)
            if ($codeHosting->getPublisher() === $this) {
                $codeHosting->setPublisher(null);
            }
        }

        return $this;
    }
}
