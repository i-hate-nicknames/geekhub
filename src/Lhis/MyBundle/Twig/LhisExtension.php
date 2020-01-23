<?php

namespace App\Lhis\MyBundle\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LhisExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('isFriday', [$this, 'isFriday'])
        ];
    }

    public function isFriday(): string
    {
        $day = (new DateTime())->format('D');
        return ($day === 'Fri') ? 'yes its friday' : 'no it aint friday';
    }
}
