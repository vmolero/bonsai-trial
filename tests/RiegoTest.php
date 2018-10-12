<?php

namespace PlanetaHuertoTests;

use PHPUnit\Framework\TestCase;
use PlanetaHuerto\Ficus;
use PlanetaHuerto\Manzano;
use PlanetaHuerto\Olmo;
use PlanetaHuerto\Olivo;
use PlanetaHuerto\RiegoVisitor;
use PlanetaHuerto\AbonoStrategy;

class RiegoTest extends TestCase
{
    public function testMuyFrecuenteEnJulio()
    {
        $abono = $this->createMock(AbonoStrategy::class);
        $julio = new \DateTime('2018-07-01');
        $tree = new Ficus(new RiegoVisitor($julio), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
        $tree = new Manzano(new RiegoVisitor($julio), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
        $tree = new Olmo(new RiegoVisitor($julio), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
        $tree = new Olivo(new RiegoVisitor($julio), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
    }

    public function testMuyFrecuenteEnAgosto()
    {
        $abono = $this->createMock(AbonoStrategy::class);
        $agosto = new \DateTime('2018-08-01');
        $tree = new Ficus(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
        $tree = new Manzano(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
        $tree = new Olmo(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
        $tree = new Olivo(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
    }

    public function testRiegoFicus()
    {
        $abono = $this->createMock(AbonoStrategy::class);
        $agosto = new \DateTime('2018-01-01');
        $tree = new Ficus(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('poco frecuente', $tree->riego());
    }

    public function testRiegoManzano()
    {
        $abono = $this->createMock(AbonoStrategy::class);
        $agosto = new \DateTime('2018-01-01');
        $tree = new Manzano(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('frecuente', $tree->riego());
    }

    public function testRiegoOlivo()
    {
        $abono = $this->createMock(AbonoStrategy::class);
        $agosto = new \DateTime('2018-01-01');
        $tree = new Olivo(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('poco frecuente', $tree->riego());
    }

    public function testRiegoOlmo()
    {
        $abono = $this->createMock(AbonoStrategy::class);
        $agosto = new \DateTime('2018-01-01');
        $tree = new Olmo(new RiegoVisitor($agosto), $abono);
        $this->assertEquals('muy frecuente', $tree->riego());
    }
}
