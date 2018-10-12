<?php

namespace PlanetaHuerto;

abstract class BonsaiTree implements Regable, Abonable, Transplantable
{
    /**
     * @var RiegoVisitor
     */
    private $riego;
    
    /**
     * @var AbonoStrategy
     */
    private $abono;

    public function __construct(RiegoVisitor $riego, AbonoStrategy $abono)
    {
        $this->riego = $riego;
        $this->abono = $abono;
    }
    
    public function riego(): string
    {
        return $this->riego->visit($this);
    }

    
    public function abonar(\DateTime $fecha = null): void
    {
        $this->abono->abonar($fecha);
    }

    public function transplantar(\DateTime $fecha = null): bool
    {
        if ($fecha === null) {
            $fecha = new \DateTime('now');
        }
        return $fecha->format('m') === '03';
    }

    public function tengoQueAbonar(\DateTime $fecha = null): bool
    {
        return $this->abono->tengoQueAbonar($fecha);
    }
}
