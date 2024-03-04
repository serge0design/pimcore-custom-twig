<?php
declare(strict_types=1);

/**
 * This file was a part of Twig.
 * (c) 2009-2019 Fabien Potencier
 * @author Henrik Bjornskov <hb@peytz.dk>
 * https://github.com/twigphp/Twig-extensions/blob/master/src/TextExtension.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * https://github.com/twigphp/Twig-extensions/blob/master/LICENSE
 */

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Environment;

class TwigTextFilters extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterTruncate',
                [$this, 'getTruncateFilter'], ['needs_environment' => true, 'is_safe' => ['html']]),
            new TwigFilter('twigFilterWordwrap',
                [$this, 'getWordwrapFilter'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function getTruncateFilter(
        Environment $env,
        string      $value,
        int         $length = 30,
        bool        $preserve = false,
        string      $separator = '...'
    ): string
    {
        if (mb_strlen($value, $env->getCharset()) > $length) {
            if ($preserve) {
                // If breakpoint is on the last word, return the value without separator.
                if (false === ($breakpoint = mb_strpos($value, ' ', $length, $env->getCharset()))) {
                    return $value;
                }
                $length = $breakpoint;
            }
            return rtrim(mb_substr($value, 0, $length, $env->getCharset())) . $separator;
        }
        return $value;
    }

    public function getWordwrapFilter(
        Environment $env,
        string      $value,
        int         $length = 50,
        string      $separator = "\r\n",
        bool        $preserve = false
    ): string
    {
        $sentences = [];
        $previous = mb_regex_encoding();
        mb_regex_encoding($env->getCharset());

        $pieces = mb_split($separator, $value);
        mb_regex_encoding($previous);

        foreach ($pieces as $piece) {
            while (!$preserve && mb_strlen($piece, $env->getCharset()) > $length) {
                $sentences[] = mb_substr($piece, 0, $length, $env->getCharset());
                $piece = mb_substr($piece, $length, 2048, $env->getCharset());
            }
            $sentences[] = $piece;
        }
        return nl2br(implode($separator, $sentences));
    }
}
