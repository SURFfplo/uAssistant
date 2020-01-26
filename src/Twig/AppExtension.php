<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Dotenv\Dotenv;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('my_function', [$this, 'getenv']),
        ];
    }
    
    public function getenv($parameter)
    {
        $envVar = $_ENV[$parameter];

        return $envVar;
    }
}