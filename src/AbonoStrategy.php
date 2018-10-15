<?php

namespace PlanetaHuerto;

class AbonoStrategy
{
    /**
     *  @var \DateTime
     */
    private $fechaUltimoAbono = null;

    public function getFechaAbono(): \DateTime
    {
        return $this->fechaUltimoAbono;
    }

    public function abonar(\DateTime $fecha = null): void
    {
        if ($fecha === null) {
            $fecha = new \DateTime('now');
        }
        $this->fechaUltimoAbono = $fecha;
    }

    public function tengoQueAbonar(\DateTime $fecha = null): bool
    {
        if ($fecha === null) {
            $fecha = new \DateTime('now');
        }
        return $this->esEpocaDeAbonar($fecha) && $this->haceMasDe30Dias($fecha);
    }

    private function esEpocaDeAbonar(\DateTime $fecha): bool
    {
        return $this->esPrimavera($fecha) || $this->esOtonyo($fecha);
    }
    
    private function haceMasDe30Dias(\DateTime $fecha): bool
    {
        return $this->fechaUltimoAbono === null ||
               ($this->fechaUltimoAbono !== null &&
               $fecha->diff($this->fechaUltimoAbono, true)->days > 30);
    }

    private function esPrimavera(\DateTime $fecha): bool
    {
        return $this->enIntervalo(
            $fecha->format('Y').'-03-20',
            $fecha->format('Y').'-06-21',
            $fecha
        );
    }

    private function esOtonyo(\DateTime $fecha): bool
    {
        return $this->enIntervalo(
            $fecha->format('Y').'-09-23',
            $fecha->format('Y').'-12-21',
            $fecha
        );
    }

    private function enIntervalo(string $fechaInicio, string $fechaFin, \DateTime $fecha): bool
    {
        $start = new \DateTimeImmutable($fechaInicio);
        $end = new \DateTimeImmutable($fechaFin);
        
        return $fecha >= $start && $fecha < $end;
    }
}
