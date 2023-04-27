<?php
declare(strict_types=1);

namespace CustomTwigBundle\Twig\Statements;

use CustomTwigBundle\Tokenparsers\SwitchTokenParser;
use Twig\Extension\AbstractExtension;

class TwigSwitch extends AbstractExtension
{

    public function getTokenParsers(): array
    {
        return [
            new SwitchTokenParser(),
        ];
    }
}
