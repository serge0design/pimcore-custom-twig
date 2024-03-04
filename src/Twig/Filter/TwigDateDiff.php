<?php
declare(strict_types=1);

/**
 * This file is part of Twig.
 * (c) 2014-2019 Fabien Potencier
 * @url https://github.com/twigphp/Twig-extensions/blob/master/src/DateExtension.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigDateDiff extends AbstractExtension
{
    public static $units = [
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];

    private $translator;

    public function __construct(TranslatorInterface $translator = null)
    {
        // Ignore the IdentityTranslator, otherwise the parameters won't be replaced properly
        if ($translator instanceof IdentityTranslator) {
            $translator = null;
        }
        $this->translator = $translator;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterPassedTimeToNow',
                [$this, 'passedTimeToNow'], ['needs_environment' => true])
        ];
    }

    /**
     * Filters for converting dates to a time ago string like Facebook and Twitter has.
     *
     * @param string|\DateTime $date a string or DateTime object to convert
     * @param string|\DateTime $now A string or DateTime object to compare with. If none given, the current time will be used.
     *
     * @return string the converted time
     */
    public function passedTimeToNow(
        Environment $env,
        string      $date,
        string      $now = null
    )
    {
        if (1 === preg_match('~^[1-9][0-9]*$~', $date)) {

            // Convert both dates to DateTime instances.
            $date = twig_date_converter($env, $date);
            $now = twig_date_converter($env, $now);

            // Get the difference between the two DateTime objects.
            $diff = $date->diff($now);

            // Check for each interval if it appears in the $diff object.
            foreach (self::$units as $attribute => $unit) {
                $count = $diff->$attribute;

                if (0 !== $count) {
                    return $this->getPluralizedInterval($count, $diff->invert, $unit);
                }
            }

            return '';
        } else {

            return $date;
        }
    }

    private function getPluralizedInterval(
        $count,
        $invert,
        $unit
    )
    {
        if ($this->translator) {
            $id = sprintf('diff.%s.%s', $invert ? 'in' : 'ago', $unit);

            return $this->translator->trans($id, (array)$count, ['%count%' => $count], 'date');
        }

        if (1 !== $count) {
            $unit .= 's';
        }

        return $invert ? "in $count $unit" : "$count $unit ago";
    }
}
