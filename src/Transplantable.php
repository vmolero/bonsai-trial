<?php

namespace PlanetaHuerto;

interface Transplantable
{
    public function transplantar(\DateTime $fecha = null): bool;
}
