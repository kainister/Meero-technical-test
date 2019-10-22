<?php

namespace Meero\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="Meero\Repository\AreaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Area
{
    /**
     * @ORM\Column(name="id", type="text")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\CustomIdGenerator(class="Meero\Doctrine\ORM\Id\GuidGenerator")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $polygon = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getPolygon(): ?array
    {
        return $this->polygon;
    }

    public function setPolygon(array $polygon): self
    {
        $this->polygon = $polygon;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
