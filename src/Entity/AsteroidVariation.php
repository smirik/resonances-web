<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AsteroidVariation
 *
 * @ORM\Table(name="asteroid_variation", indexes={@ORM\Index(name="asteroid_number", columns={"asteroid_number"})})
 * @ORM\Entity
 */
class AsteroidVariation
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
     * @var float
     *
     * @ORM\Column(name="semi_axis", type="float", precision=12, scale=10, nullable=false)
     */
    private $semiAxis;

    /**
     * @var float
     *
     * @ORM\Column(name="eccentricity", type="float", precision=12, scale=10, nullable=false)
     */
    private $eccentricity;

    /**
     * @var float
     *
     * @ORM\Column(name="inclination", type="float", precision=12, scale=10, nullable=false)
     */
    private $inclination;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude_of_node", type="float", precision=12, scale=10, nullable=false)
     */
    private $longitudeOfNode;

    /**
     * @var float
     *
     * @ORM\Column(name="argument_of_periapsis", type="float", precision=12, scale=10, nullable=false)
     */
    private $argumentOfPeriapsis;

    /**
     * @var float
     *
     * @ORM\Column(name="mean_anomaly", type="float", precision=12, scale=10, nullable=false)
     */
    private $meanAnomaly;

    /**
     * @var \Asteroid
     *
     * @ORM\ManyToOne(targetEntity="Asteroid")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asteroid_number", referencedColumnName="number")
     * })
     */
    private $asteroidNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemiAxis(): ?float
    {
        return $this->semiAxis;
    }

    public function setSemiAxis(float $semiAxis): self
    {
        $this->semiAxis = $semiAxis;

        return $this;
    }

    public function getEccentricity(): ?float
    {
        return $this->eccentricity;
    }

    public function setEccentricity(float $eccentricity): self
    {
        $this->eccentricity = $eccentricity;

        return $this;
    }

    public function getInclination(): ?float
    {
        return $this->inclination;
    }

    public function setInclination(float $inclination): self
    {
        $this->inclination = $inclination;

        return $this;
    }

    public function getLongitudeOfNode(): ?float
    {
        return $this->longitudeOfNode;
    }

    public function setLongitudeOfNode(float $longitudeOfNode): self
    {
        $this->longitudeOfNode = $longitudeOfNode;

        return $this;
    }

    public function getArgumentOfPeriapsis(): ?float
    {
        return $this->argumentOfPeriapsis;
    }

    public function setArgumentOfPeriapsis(float $argumentOfPeriapsis): self
    {
        $this->argumentOfPeriapsis = $argumentOfPeriapsis;

        return $this;
    }

    public function getMeanAnomaly(): ?float
    {
        return $this->meanAnomaly;
    }

    public function setMeanAnomaly(float $meanAnomaly): self
    {
        $this->meanAnomaly = $meanAnomaly;

        return $this;
    }

    public function getAsteroidNumber(): ?Asteroids
    {
        return $this->asteroidNumber;
    }

    public function setAsteroidNumber(?Asteroids $asteroidNumber): self
    {
        $this->asteroidNumber = $asteroidNumber;

        return $this;
    }


}
