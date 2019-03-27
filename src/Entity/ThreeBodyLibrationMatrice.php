<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="three_body_librations_matrices")})
 * @ORM\Entity(repositoryClass="App\Repository\ThreeBodyLibrationMatriceRepository")
 */
class ThreeBodyLibrationMatrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $planet1;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $planet2;

    /**
     * @ORM\Column(type="integer")
     */
    private $m1;

    /**
     * @ORM\Column(type="integer")
     */
    private $m2;

    /**
     * @ORM\Column(type="integer")
     */
    private $m;

    /**
     * @ORM\Column(type="integer")
     */
    private $p1;

    /**
     * @ORM\Column(type="integer")
     */
    private $p2;

    /**
     * @ORM\Column(type="integer")
     */
    private $p;

    /**
     * @ORM\Column(name="semi_axis", type="float", precision=22, scale=10, nullable=false)
     */
    private $semi_axis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlanet1(): ?string
    {
        return $this->planet1;
    }

    public function setPlanet1(?string $planet1): self
    {
        $this->planet1 = $planet1;

        return $this;
    }

    public function getPlanet2(): ?string
    {
        return $this->planet2;
    }

    public function setPlanet2(?string $planet2): self
    {
        $this->planet2 = $planet2;

        return $this;
    }

    public function getM1(): ?int
    {
        return $this->m1;
    }

    public function setM1(int $m1): self
    {
        $this->m1 = $m1;

        return $this;
    }

    public function getM2(): ?int
    {
        return $this->m2;
    }

    public function setM2(int $m2): self
    {
        $this->m2 = $m2;

        return $this;
    }

    public function getM(): ?int
    {
        return $this->m;
    }

    public function setM(int $m): self
    {
        $this->m = $m;

        return $this;
    }

    public function getP1(): ?int
    {
        return $this->p1;
    }

    public function setP1(int $p1): self
    {
        $this->p1 = $p1;

        return $this;
    }

    public function getP2(): ?int
    {
        return $this->p2;
    }

    public function setP2(int $p2): self
    {
        $this->p2 = $p2;

        return $this;
    }

    public function getP(): ?int
    {
        return $this->p;
    }

    public function setP(int $p): self
    {
        $this->p = $p;

        return $this;
    }

    public function getSemiAxis(): ?float
    {
        return $this->semi_axis;
    }

    public function setSemiAxis(float $semi_axis): self
    {
        $this->semi_axis = $semi_axis;

        return $this;
    }
}
