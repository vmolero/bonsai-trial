<?php

namespace PlanetaHuertoTests;

use PHPUnit\Framework\TestCase;
use PlanetaHuerto\Ficus;
use PlanetaHuerto\Manzano;
use PlanetaHuerto\Olmo;
use PlanetaHuerto\Olivo;
use PlanetaHuerto\AbonoStrategy;
use PlanetaHuerto\RiegoVisitor;

class AbonoTest extends TestCase
{
    public function testAbonoEnVerano()
    {
        $unDiaDeVerano = new \DateTime('2018-06-30');
        $riegoMock = $this->createMock(RiegoVisitor::class);
        
        $abono = new AbonoStrategy();
        
        $ficus = new Ficus($riegoMock, $abono);
        $this->assertFalse($ficus->tengoQueAbonar($unDiaDeVerano));
    }

    public function testAbonoEnPrimavera()
    {
        $unDiaDePrimavera = new \DateTime('2018-06-17');
        $riegoMock = $this->createMock(RiegoVisitor::class);
        
        $abono = new AbonoStrategy();
        
        $olmo = new Olmo($riegoMock, $abono);
        $this->assertTrue($olmo->tengoQueAbonar($unDiaDePrimavera));
    }

    public function testAbonoEnPrimaveraMasDe30Dias()
    {
        $unDiaDePrimavera = new \DateTime('2018-04-26');
        $riegoMock = $this->createMock(RiegoVisitor::class);
        
        $abono = new AbonoStrategy();
        
        $olmo = new Olmo($riegoMock, $abono);
        $olmo->abonar(new \DateTime('2017-10-01'));
        $this->assertTrue($olmo->tengoQueAbonar($unDiaDePrimavera));
    }

    public function testAbonoEnPrimaveraMenosDe30Dias()
    {
        $unDiaDePrimavera = new \DateTime('2018-06-17');
        $riegoMock = $this->createMock(RiegoVisitor::class);
        
        $abono = new AbonoStrategy();
        
        $olmo = new Olmo($riegoMock, $abono);
        $olmo->abonar(new \DateTime('2018-05-26'));
        $this->assertFalse($olmo->tengoQueAbonar($unDiaDePrimavera));
    }

    public function testAbonoEnOtonyoMasDe30Dias()
    {
        $unDiaDeOtonyo = new \DateTime('2018-10-12');
                
        $abono = new AbonoStrategy();
        $abono->abonar(new \DateTime('2018-03-23'));
        $this->assertTrue($abono->tengoQueAbonar($unDiaDeOtonyo));
    }

    public function testAbonoEnOtonyoMenosDe30Dias()
    {
        $unDiaDeOtonyo = new \DateTime('2018-10-12');
                
        $abono = new AbonoStrategy();
        $abono->abonar(new \DateTime('2018-09-24'));
        $this->assertFalse($abono->tengoQueAbonar($unDiaDeOtonyo));
    }
}
