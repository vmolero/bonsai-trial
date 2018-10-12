<?php

namespace PlanetaHuerto;

class Olmo extends BonsaiTree implements Pulverizable
{
    public function pulverizar(): bool
    {
        return true;
    }
}
