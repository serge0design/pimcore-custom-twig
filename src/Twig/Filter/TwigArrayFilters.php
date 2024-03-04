<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigArrayFilters extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterArrayFlip',
                [$this, 'arrayFlip']),
            new TwigFilter('twigFilterArrayReverse',
                [$this, 'arrayReverse']),
            new TwigFilter('twigFilterArrayShuffle',
                [$this, 'arrayShuffle'])
        ];
    }

    public function arrayFlip(array $arr): iterable
    {
        if (is_array($arr)) {
            return array_flip($arr);
        }
        return $arr;
    }

    public function arrayReverse(array $arr): iterable
    {
        if (is_array($arr)) {
            return array_reverse($arr);
        }
        return $arr;
    }

    /**
     * @param array|\Traversable $arr
     */
    public function arrayShuffle(array $arr): iterable
    {
        if (is_array($arr)) {
            if ($arr instanceof \Traversable) {
                $arr = iterator_to_array($arr, false);
            }
            shuffle($arr);
            return $arr;
        }

        return $arr;
    }
}
