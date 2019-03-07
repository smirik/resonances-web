<?php

namespace App\Entity;

trait ResonanceString
{

    public function resonanceToString() : string
    {
        $s = $this->getM1().$this->getPlanet1()[0].sprintf("%+d",$this->getM2()).$this->getPlanet2()[0].sprintf("%+d",$this->getM());
        return $s;
    }

}
