<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThreeBodyLibrations
 *
 * @ORM\Table(name="three_body_librations", indexes={@ORM\Index(name="index_number1", columns={"number"})})
 * @ORM\Entity(repositoryClass="App\Repository\ThreeBodyLibrationRepository")
 */
class ThreeBodyLibration
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     */
    private $number;

    /**
     * @var float
     *
     * @ORM\Column(name="proper_semiaxis", type="float", precision=22, scale=10, nullable=false)
     */
    private $properSemiaxis;

    /**
     * @var int
     *
     * @ORM\Column(name="problem", type="integer", nullable=false)
     */
    private $problem;

    /**
     * @var int
     *
     * @ORM\Column(name="pure", type="integer", nullable=false)
     */
    private $pure;

    /**
     * @var string
     *
     * @ORM\Column(name="planet1", type="string", length=255, nullable=false)
     */
    private $planet1;

    /**
     * @var string
     *
     * @ORM\Column(name="planet2", type="string", length=255, nullable=false)
     */
    private $planet2;

    /**
     * @var int
     *
     * @ORM\Column(name="m1", type="integer", nullable=false)
     */
    private $m1;

    /**
     * @var int
     *
     * @ORM\Column(name="m2", type="integer", nullable=false)
     */
    private $m2;

    /**
     * @var int
     *
     * @ORM\Column(name="m", type="integer", nullable=false)
     */
    private $m;

    /**
     * @var int
     *
     * @ORM\Column(name="p1", type="integer", nullable=false)
     */
    private $p1;

    /**
     * @var int
     *
     * @ORM\Column(name="p2", type="integer", nullable=false)
     */
    private $p2;

    /**
     * @var int
     *
     * @ORM\Column(name="p", type="integer", nullable=false)
     */
    private $p;

    /**
     * @var float
     *
     * @ORM\Column(name="resonant_semiaxis", type="float", precision=22, scale=10, nullable=false)
     */
    private $resonantSemiaxis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getProperSemiaxis(): ?float
    {
        return $this->properSemiaxis;
    }

    public function setProperSemiaxis(float $properSemiaxis): self
    {
        $this->properSemiaxis = $properSemiaxis;

        return $this;
    }

    public function getProblem(): ?int
    {
        return $this->problem;
    }

    public function setProblem(int $problem): self
    {
        $this->problem = $problem;

        return $this;
    }

    public function getPure(): ?int
    {
        return $this->pure;
    }

    public function setPure(int $pure): self
    {
        $this->pure = $pure;

        return $this;
    }

    public function getPlanet1(): ?string
    {
        return $this->planet1;
    }

    public function setPlanet1(string $planet1): self
    {
        $this->planet1 = $planet1;

        return $this;
    }

    public function getPlanet2(): ?string
    {
        return $this->planet2;
    }

    public function setPlanet2(string $planet2): self
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

    public function getResonantSemiaxis(): ?float
    {
        return $this->resonantSemiaxis;
    }

    public function setResonantSemiaxis(float $resonantSemiaxis): self
    {
        $this->resonantSemiaxis = $resonantSemiaxis;

        return $this;
    }


}
