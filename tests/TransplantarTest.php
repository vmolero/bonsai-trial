<?php

namespace PlanetaHuertoTests;

use PHPUnit\Framework\TestCase;
use PlanetaHuerto\Ficus;
use PlanetaHuerto\AbonoStrategy;
use PlanetaHuerto\RiegoVisitor;

class TransplantarTest extends TestCase
{
    public function testTransplantarEnMarzo()
    {
        $unDiaDeMarzo = new \DateTime('2018-03-23');
        
        $riegoMock = $this->createMock(RiegoVisitor::class);
        $abonoMock = $this->createMock(AbonoStrategy::class);
        $ficus = new Ficus($riegoMock, $abonoMock);
        $this->assertTrue($ficus->transplantar($unDiaDeMarzo));
    }

    public function testTransplantarEnAbril()
    {
        $unDiaDeAbril = new \DateTime('2018-04-26');
        
        $riegoMock = $this->createMock(RiegoVisitor::class);
        $abonoMock = $this->createMock(AbonoStrategy::class);
        $ficus = new Ficus($riegoMock, $abonoMock);
        $this->assertFalse($ficus->transplantar($unDiaDeAbril));
    }
}
