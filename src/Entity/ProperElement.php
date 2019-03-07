<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProperElements
 *
 * @ORM\Table(name="proper_elements")
 * @ORM\Entity
 */
class ProperElement
{
    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $number;

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
     * @var int|null
     *
     * @ORM\Column(name="rfl", type="integer", nullable=true)
     */
    private $rfl;

    /**
     * @var int|null
     *
     * @ORM\Column(name="qcm", type="integer", nullable=true)
     */
    private $qcm;

    /**
     * @var int|null
     *
     * @ORM\Column(name="qco", type="integer", nullable=true)
     */
    private $qco;

    /**
     * @var float|null
     *
     * @ORM\Column(name="magnitude", type="float", precision=22, scale=10, nullable=true)
     */
    private $magnitude;

    public function getNumber(): ?int
    {
        return $this->number;
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

    public function getRfl(): ?int
    {
        return $this->rfl;
    }

    public function setRfl(?int $rfl): self
    {
        $this->rfl = $rfl;

        return $this;
    }

    public function getQcm(): ?int
    {
        return $this->qcm;
    }

    public function setQcm(?int $qcm): self
    {
        $this->qcm = $qcm;

        return $this;
    }

    public function getQco(): ?int
    {
        return $this->qco;
    }

    public function setQco(?int $qco): self
    {
        $this->qco = $qco;

        return $this;
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


}
