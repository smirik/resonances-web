<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SyntheticProperElements
 *
 * @ORM\Table(name="synthetic_proper_elements", indexes={@ORM\Index(name="semi_axis", columns={"semi_axis"}), @ORM\Index(name="LCE", columns={"LCE"})})
 * @ORM\Entity
 */
class SyntheticProperElement
{
    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $number = '0';

    /**
     * @var float|null
     *
     * @ORM\Column(name="magnitude", type="float", precision=22, scale=10, nullable=true)
     */
    private $magnitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="semi_axis", type="float", precision=22, scale=10, nullable=true)
     */
    private $semiAxis;

    /**
     * @var float|null
     *
     * @ORM\Column(name="eccentricity", type="float", precision=22, scale=10, nullable=true)
     */
    private $eccentricity;

    /**
     * @var float|null
     *
     * @ORM\Column(name="sinI", type="float", precision=22, scale=10, nullable=true)
     */
    private $sini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="n", type="float", precision=22, scale=10, nullable=true)
     */
    private $n;

    /**
     * @var float|null
     *
     * @ORM\Column(name="g", type="float", precision=22, scale=10, nullable=true)
     */
    private $g;

    /**
     * @var float|null
     *
     * @ORM\Column(name="s", type="float", precision=22, scale=10, nullable=true)
     */
    private $s;

    /**
     * @var float|null
     *
     * @ORM\Column(name="LCE", type="float", precision=22, scale=10, nullable=true)
     */
    private $lce;

    /**
     * @var int|null
     *
     * @ORM\Column(name="myr", type="integer", nullable=true)
     */
    private $myr;

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getMagnitude(): ?float
    {
        return $this->magnitude;
    }

    public function setMagnitude(?float $magnitude): self
    {
        $this->magnitude = $magnitude;

        return $this;
    }

    public function getSemiAxis(): ?float
    {
        return $this->semiAxis;
    }

    public function setSemiAxis(?float $semiAxis): self
    {
        $this->semiAxis = $semiAxis;

        return $this;
    }

    public function getEccentricity(): ?float
    {
        return $this->eccentricity;
    }

    public function setEccentricity(?float $eccentricity): self
    {
        $this->eccentricity = $eccentricity;

        return $this;
    }

    public function getSini(): ?float
    {
        return $this->sini;
    }

    public function setSini(?float $sini): self
    {
        $this->sini = $sini;

        return $this;
    }

    public function getN(): ?float
    {
        return $this->n;
    }

    public function setN(?float $n): self
    {
        $this->n = $n;

        return $this;
    }

    public function getG(): ?float
    {
        return $this->g;
    }

    public function setG(?float $g): self
    {
        $this->g = $g;

        return $this;
    }

    public function getS(): ?float
    {
        return $this->s;
    }

    public function setS(?float $s): self
    {
        $this->s = $s;

        return $this;
    }

    public function getLce(): ?float
    {
        return $this->lce;
    }

    public function setLce(?float $lce): self
    {
        $this->lce = $lce;

        return $this;
    }

    public function getMyr(): ?int
    {
        return $this->myr;
    }

    public function setMyr(?int $myr): self
    {
        $this->myr = $myr;

        return $this;
    }


}
