<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Statements;

use SergeDesign\PimcoreCustomTwigBundle\Tokenparsers\SwitchTokenParser;
use Twig\Extension\AbstractExtension;

class TwigSwitch extends AbstractExtension
{

    public final function getTokenParsers(): array
    {
        return [
            new SwitchTokenParser(),
        ];
    }
}
