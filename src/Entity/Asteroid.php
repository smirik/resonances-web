<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asteroid
 *
 * @ORM\Table(name="asteroids", indexes={@ORM\Index(name="semi_axis", columns={"semi_axis"})})
 * @ORM\Entity
 */
class Asteroid
{
    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255, nullable=false)
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
     * @ORM\Column(name="inclination", type="float", precision=22, scale=10, nullable=true)
     */
    private $inclination;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude_of_node", type="float", precision=22, scale=10, nullable=true)
     */
    private $longitudeOfNode;

    /**
     * @var float|null
     *
     * @ORM\Column(name="argument_of_periapsis", type="float", precision=22, scale=10, nullable=true)
     */
    private $argumentOfPeriapsis;

    /**
     * @var float|null
     *
     * @ORM\Column(name="mean_anomaly", type="float", precision=22, scale=10, nullable=true)
     */
    private $meanAnomaly;

    /**
     * @var string|null
     *
     * @ORM\Column(name="source", type="string", length=20, nullable=true)
     */
    private $source;

    public function getNumber(): ?string
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

    public function getInclination(): ?float
    {
        return $this->inclination;
    }

    public function setInclination(?float $inclination): self
    {
        $this->inclination = $inclination;

        return $this;
    }

    public function getLongitudeOfNode(): ?float
    {
        return $this->longitudeOfNode;
    }

    public function setLongitudeOfNode(?float $longitudeOfNode): self
    {
        $this->longitudeOfNode = $longitudeOfNode;

        return $this;
    }

    public function getArgumentOfPeriapsis(): ?float
    {
        return $this->argumentOfPeriapsis;
    }

    public function setArgumentOfPeriapsis(?float $argumentOfPeriapsis): self
    {
        $this->argumentOfPeriapsis = $argumentOfPeriapsis;

        return $this;
    }

    public function getMeanAnomaly(): ?float
    {
        return $this->meanAnomaly;
    }

    public function setMeanAnomaly(?float $meanAnomaly): self
    {
        $this->meanAnomaly = $meanAnomaly;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }


}
