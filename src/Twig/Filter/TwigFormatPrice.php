<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFormatPrice extends AbstractExtension
{
    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterFormatPrice',
                [$this, 'formatPrice']
            )
        ];
    }

    final public function formatPrice(
        float  $value,
        string $currencySymbol = '',
        string $locale = 'en_US'
    ): string {
        $fmt = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);
        $formattedValue = $fmt->formatCurrency($value, $currencySymbol);

        if (!empty($currencySymbol) && strpos($formattedValue, $currencySymbol) === false) {
            $formattedValue = $currencySymbol . ' ' . $formattedValue;
        }

        return $formattedValue;
    }
}
