<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Statements;

use SergeDesign\PimcoreCustomTwigBundle\TokenParsers\SwitchTokenParser;
use Twig\Extension\AbstractExtension;

class TwigSwitch extends AbstractExtension
{
    final public function getTokenParsers(): array
    {
        return [
            new SwitchTokenParser(),
        ];
    }
}
