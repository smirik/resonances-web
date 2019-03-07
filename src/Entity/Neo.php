<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Neo
 *
 * @ORM\Table(name="neo", indexes={@ORM\Index(name="asteroid_id", columns={"asteroid_name"})})
 * @ORM\Entity
 */
class Neo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="moid", type="string", length=255, nullable=true)
     */
    private $moid;

    /**
     * @var \Asteroid
     *
     * @ORM\ManyToOne(targetEntity="Asteroid")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asteroid_name", referencedColumnName="number")
     * })
     */
    private $asteroidName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoid(): ?string
    {
        return $this->moid;
    }

    public function setMoid(?string $moid): self
    {
        $this->moid = $moid;

        return $this;
    }

    public function getAsteroidName(): ?Asteroids
    {
        return $this->asteroidName;
    }

    public function setAsteroidName(?Asteroids $asteroidName): self
    {
        $this->asteroidName = $asteroidName;

        return $this;
    }


}
