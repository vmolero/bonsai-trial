<?php

namespace PlanetaHuertoTests;

use PHPUnit\Framework\TestCase;
use PlanetaHuerto\Olmo;
use PlanetaHuerto\AbonoStrategy;
use PlanetaHuerto\RiegoVisitor;
use PlanetaHuerto\Manzano;

class PulverizarTest extends TestCase
{
    public function testPulverizarOlmo()
    {
        $riegoMock = $this->createMock(RiegoVisitor::class);
        $abonoMock = $this->createMock(AbonoStrategy::class);
        $olmo = new Olmo($riegoMock, $abonoMock);
        $this->assertTrue($olmo->pulverizar());
    }
}
