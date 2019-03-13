<?php

namespace App\Entity;

trait ResonanceString
{

    public function resonanceToString() : string
    {
        if ('App\Entity\ThreeBodyLibration' == self::class) {
            $s = $this->getM1().$this->getPlanet1()[0].sprintf("%+d",$this->getM2()).$this->getPlanet2()[0].sprintf("%+d",$this->getM());
        } elseif ('App\Entity\TwoBodyLibration' == self::class) {
            $s = $this->getM1().$this->getPlanet1()[0].sprintf("%+d",$this->getM());
        }
        return $s;
    }

    public function pureToString() : string
    {
        if ($this->getPure()) {
            return 'yes';
        }
        return 'no';
    }

}
