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
            $librations = $this->repository->getLibrationsAsScalarResult($data);
        }

        /**
         * Add twobody
         */
        $twoBodyLibrations = [];
        if (0 != $data['twobody']) {
            $twoBodyLibrations = $this->twoBodyRepository->getLibrationsAsScalarResult($data);
        }

        $properElements = $this->getProperElementsForLibrations(array_merge($librations, $twoBodyLibrations));

        return [
            'librations' => $librations,
            'properElements' => $properElements,
            'twoBodyLibrations' => $twoBodyLibrations,
        ];

    }

    public function getResonantAsteroidsForChart(array $data) : array
    {
        $tmp = $this->getResonantAsteroids($data);

        $librations = array_merge($tmp['librations'], $tmp['twoBodyLibrations']);
        $resonances = $this->getResonancesForLibrations($librations);
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
            $properElementsNumbers[] = (int)$libration['number'];
        }
        $properElementsNumbers = array_unique($properElementsNumbers);

        $properElementsObjects = $this->properElementRepository
            ->createQueryBuilder('p')
            ->select(['p.number', 'p.semiAxis', 'p.eccentricity', 'p.sini'])
            ->where('p.number IN (:numbers)')
            ->setParameter('numbers', $properElementsNumbers)
            ->getQuery()
            ->getScalarResult()
        ;

        $properElements = [];
        foreach ($properElementsObjects as $properElementObject) {
            $properElements[$properElementObject['number']] = $properElementObject;
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
            if (isset($libration['planet2'])) {
                $s = $libration['m1'].$libration['planet1'][0].sprintf("%+d",$libration['m2']).$libration['planet2'][0].sprintf("%+d",$libration['m']);
            } else {
                $s = $libration['m1'].$libration['planet1'][0].sprintf("%+d",$libration['m']);
            }
            if (!isset($resonances[$s])) {
                $resonances[$s] = [];
            }
            $resonances[$s][] = $libration['number'];
        }
        return $resonances;
    }

    private function getBackgroundAsteroids($aMin, $aMax) : array
    {
        $backgroundProperElements = $this->properElementRepository
            ->createQueryBuilder('p')
            ->select(['p.semiAxis', 'p.eccentricity'])
            ->where('p.semiAxis >= :amin')
            ->andWhere('p.semiAxis <= :amax')
            ->setParameter('amin', $aMin)
            ->setParameter('amax', $aMax)
            ->getQuery()
            ->getScalarResult()
        ;

        $arr = [];
        foreach ($backgroundProperElements as $elem) {
            $arr[] = [(float)$elem['semiAxis'], (float)$elem['eccentricity']];
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
                    $arr[] = [(float)$properElements[$asteroidNumber]['semiAxis'], (float)$properElements[$asteroidNumber]['eccentricity']];
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
