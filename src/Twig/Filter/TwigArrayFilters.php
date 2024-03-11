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
            new TwigFilter('twigFilterArrayFlip', [$this, 'arrayFlip']),
            new TwigFilter('twigFilterArrayReverse', [$this, 'arrayReverse']),
            new TwigFilter('twigFilterArrayShuffle', [$this, 'arrayShuffle'])
        ];
    }

    /**
     * Flips an array.
     */
    final public function arrayFlip(iterable $arr): array
    {
        return array_flip($this->iterableToArray($arr));
    }

    /**
     * Reverses an array.
     */
    final public function arrayReverse(iterable $arr, bool $preserveKeys = false): array
    {
        return array_reverse($this->iterableToArray($arr), $preserveKeys);
    }

    /**
     * Shuffles an array.
     */
    final public function arrayShuffle(iterable $arr): array
    {
        $array = $this->iterableToArray($arr);
        shuffle($array);
        return $array;
    }

    /**
     * Converts iterable to an array.
     */
    private function iterableToArray(iterable $iterable): array
    {
        return is_array($iterable) ? $iterable : iterator_to_array($iterable, true);
    }
}
