<?php

namespace App\Entity;

use App\Repository\GitHubRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GitHubRepository::class)]
class GitHub
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $repoId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastPushDate = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $starGazersCount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepoId(): ?int
    {
        return $this->repoId;
    }

    public function setRepoId(int $repoId): self
    {
        $this->repoId = $repoId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

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

    public function getStarGazersCount(): ?int
    {
        return $this->starGazersCount;
    }

    public function setStarGazersCount(int $starGazersCount): self
    {
        $this->starGazersCount = $starGazersCount;

        return $this;
    }

    public function getLastPushDate(): ?\DateTimeInterface
    {
        return $this->lastPushDate;
    }

    public function setLastPushDate(\DateTimeInterface $lastPushDate): self
    {
        $this->lastPushDate = $lastPushDate;

        return $this;
    }
}
