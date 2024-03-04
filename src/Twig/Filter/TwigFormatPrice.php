<?php

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFormatPrice extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterFormatPrice', [$this, 'formatPrice'])
        ];
    }

    public function formatPrice(
        int    $value,
        string $prefix = '',
        int    $decimals = 0,
        string $decPoint = ".",
        string $thousandSep = "'"): string
    {

        $value = number_format($value, $decimals, $decPoint, $thousandSep);
        $return = ($prefix != '' ? $prefix . ' ' : '') . $value;

        return $return;

    }
}
