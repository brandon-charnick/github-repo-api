<?php

namespace App\Entity;

use App\Repository\GitHubRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: GitHubRepository::class)]
class GitHub
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[SerializedName('id')]
    private ?int $repoId = null;

    #[ORM\Column(length: 255)]
    #[SerializedName('name')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[SerializedName('html_url')]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[SerializedName('url')]
    private ?string $apiUrl = null;

    #[ORM\Column]
    #[SerializedName('created_at')]
    private ?\DateTimeImmutable $createdDate = null;

    #[ORM\Column]
    #[SerializedName('pushed_at')]
    private ?\DateTimeImmutable $lastPushDate = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[SerializedName('description')]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('stargazers_count')]
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

    public function getApiUrl(): ?string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeImmutable
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeImmutable $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getLastPushDate(): ?\DateTimeImmutable
    {
        return $this->lastPushDate;
    }

    public function setLastPushDate(\DateTimeImmutable $lastPushDate): self
    {
        $this->lastPushDate = $lastPushDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStarGazersCount(): ?int
    {
        return $this->starGazersCount;
    }

    public function setStarGazersCount(?int $starGazersCount): self
    {
        $this->starGazersCount = $starGazersCount;

        return $this;
    }
}
