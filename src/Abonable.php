<?php

namespace PlanetaHuerto;

interface Abonable
{
    public function abonar(\DateTime $fecha = null): void;
}
