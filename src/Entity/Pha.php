<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pha
 *
 * @ORM\Table(name="pha")
 * @ORM\Entity
 */
class Pha
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
     * @var float|null
     *
     * @ORM\Column(name="moid", type="float", precision=12, scale=10, nullable=true)
     */
    private $moid;

    /**
     * @var string
     *
     * @ORM\Column(name="asteroid_number", type="string", length=255, nullable=false)
     */
    private $asteroidNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoid(): ?float
    {
        return $this->moid;
    }

    public function setMoid(?float $moid): self
    {
        $this->moid = $moid;

        return $this;
    }

    public function getAsteroidNumber(): ?string
    {
        return $this->asteroidNumber;
    }

    public function setAsteroidNumber(string $asteroidNumber): self
    {
        $this->asteroidNumber = $asteroidNumber;

        return $this;
    }


}
