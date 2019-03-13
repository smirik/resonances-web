<?php

namespace App\Resonance;

use App\Repository\ThreeBodyLibrationRepository;
use App\Repository\TwoBodyLibrationRepository;
use App\Repository\ProperElementRepository;
use App\Entity\ProperElement;

class Finder
{

    /**
     * @var ThreeBodyLibrationRepository
     */
    private $repository;
    /**
     * @var ProperElementRepository
     */
    private $properElementRepository;
    /**
     * @var TwoBodyLibrationRepository
     */
    private $twoBodyRepository;

    public function __construct(ThreeBodyLibrationRepository $repository, ProperElementRepository $properElementRepository, TwoBodyLibrationRepository $twoBodyRepository)
    {
        $this->repository = $repository;
        $this->properElementRepository = $properElementRepository;
        $this->twoBodyRepository = $twoBodyRepository;
    }

    public function getResonantAsteroids(array $data) : array
    {
        $librations = [];
        /**
         * Only two-body
         */
        if (-1 != $data['twobody']) {
            $librations = $this->repository->getLibrations($data);
        }
        /**
         * Add twobody
         */
        $twoBodyResonances = [];
        if (0 != $data['twobody']) {
            $twoBodyResonances = $this->twoBodyRepository->getLibrations($data);
        }
        $resonances = $this->getResonancesForLibrations($librations);
        $properElements = $this->getProperElementsForLibrations($librations);

        return [
            'resonances' => $resonances,
            'properElements' => $properElements,
            'twoBodyResonances' => $twoBodyResonances,
        ];

    }

    public function getResonantAsteroidsForChart(array $data) : array
    {
        $tmp = $this->getResonantAsteroids($data);

        $resonances = array_merge($tmp['resonances'], $tmp['twoBodyResonances']);
        $properElements = $tmp['properElements'];

        $ae = [];
        if (isset($data['includeBackground']) && $data['includeBackground']) {
            $arr = $this->getBackgroundAsteroids($data['amin'], $data['amax']);
            $ae[] = ['name' => 'background', 'color' => 'rgba(230,230,230,.5)', 'data' => $arr];
        }

        $tmp = $this->buildData($resonances, $properElements);
        $ae = array_merge($ae, $tmp);

        return $ae;
    }

    /**
     * Return array of proper semimajor-axis and eccentricity
     * @return array
     */
    private function getProperElementsForLibrations($librations) : array
    {
        $properElementsNumbers = [];
        foreach ($librations as $libration) {
            $properElementsNumbers[] = $libration->getNumber();
        }
        $properElementsNumbers = array_unique($properElementsNumbers);

        $properElementsObjects = $this->properElementRepository
            ->findBy(['number' => $properElementsNumbers]);

        $properElements = [];
        foreach ($properElementsObjects as $properElementObject) {
            $properElements[$properElementObject->getNumber()] = $properElementObject;
        }
        return $properElements;
    }

    /**
     * Return array of proper semimajor-axis and eccentricity
     * @return array
     */
    private function getResonancesForLibrations($librations) : array
    {
        $resonances = [];
        foreach ($librations as $libration) {
            $s = $libration->resonanceToString();
            if (!isset($resonances[$s])) {
                $resonances[$s] = [];
            }
            $resonances[$s][] = $libration->getNumber();
        }
        return $resonances;
    }

    private function getBackgroundAsteroids($aMin, $aMax) : array
    {
        $backgroundProperElements = $this->properElementRepository
            ->createQueryBuilder('p')
            ->where('p.semiAxis >= :amin')
            ->andWhere('p.semiAxis <= :amax')
            ->setParameter('amin', $aMin)
            ->setParameter('amax', $aMax)
            ->getQuery()
            ->getResult()
        ;

        $arr = [];
        foreach ($backgroundProperElements as $elem) {
            $arr[] = [$elem->getSemiAxis(), $elem->getEccentricity()];
        }
        return $arr;
    }

    private function buildData(array $resonances, $properElements) : array
    {
        $ae = [];

        foreach ($resonances as $key => $asteroidsInResonance) {
            /**
             * Set opacity 1.0 for two-body
             */
            $len = strlen($key);
            $opacity = '0.2';
            if ($len <= 6) {
                $opacity = '1.0';
            }
            $arr = [];
            foreach ($asteroidsInResonance as $asteroidNumber) {
                if (isset($properElements[$asteroidNumber])) {
                    $arr[] = [$properElements[$asteroidNumber]->getSemiAxis(), $properElements[$asteroidNumber]->getEccentricity()];
                }
            }
            $a = rand(0, 200);
            $b = rand(0, 200);
            $c = rand(0, 200);
            $ae[] = ['name' => $key, 'color' => 'rgba('.$a.', '.$b.', '.$c.', '.$opacity.')', 'data' => $arr];
        }

        return $ae;
    }

}
