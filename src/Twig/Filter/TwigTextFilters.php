<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Environment;

class TwigTextFilters extends AbstractExtension
{
    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterTruncate',
                [$this, 'truncateFilter'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterWordwrap',
                [$this, 'wordwrapFilter'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    final public function truncateFilter(
        Environment $env,
        string      $value,
        int         $length = 30,
        bool        $preserve = false,
        string      $separator = '...'
    ): string {
        if (mb_strlen($value, $env->getCharset()) <= $length) {
            return $value;
        }

        if ($preserve) {
            $cutOff = mb_strpos($value, ' ', $length, $env->getCharset());
            $length = ($cutOff !== false) ? $cutOff : $length;
        }

        return rtrim(mb_substr($value, 0, $length, $env->getCharset())) . $separator;
    }

    final public function wordwrapFilter(
        string $value,
        int    $length = 50,
        string $separator = "\n",
        bool   $cut = false
    ): string {
        return nl2br(wordwrap($value, $length, $separator, $cut));
    }
}
