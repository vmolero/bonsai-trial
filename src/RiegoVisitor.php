<?php

namespace PlanetaHuerto;

class RiegoVisitor
{
    public const MESES_MUY_FRECUENTE = ['07', '08'];

    private $fecha;

    public function __construct(\DateTime $fechaDelAnyo = null)
    {
        $this->fecha = $fechaDelAnyo;
    }

    public function visit(Regable $arbol): string
    {
        if (in_array($this->fecha->format('m'), self::MESES_MUY_FRECUENTE)) {
            return FrecuenciaRiegoEnum::MUY_FRECUENTE;
        }
        $refletedClass = new \ReflectionClass($arbol);
        
        return $this->{'riego'.$refletedClass->getShortName()}();
    }

    public function riegoFicus(): string
    {
        return FrecuenciaRiegoEnum::POCO_FRECUENTE;
    }

    public function riegoManzano(): string
    {
        return FrecuenciaRiegoEnum::FRECUENTE;
    }

    public function riegoOlivo(): string
    {
        return FrecuenciaRiegoEnum::POCO_FRECUENTE;
    }

    public function riegoOlmo(): string
    {
        return FrecuenciaRiegoEnum::MUY_FRECUENTE;
    }
}
