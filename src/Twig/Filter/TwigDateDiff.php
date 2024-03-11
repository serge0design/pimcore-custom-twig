<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigDateDiff extends AbstractExtension
{
    public static array $units = [
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];

    private ?TranslatorInterface $translator;

    public function __construct(?TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterPassedTimeToNow',
                [$this, 'passedTimeToNow'],
                ['needs_environment' => true]
            )
        ];
    }

    final public function passedTimeToNow(
        Environment $env,
        string      $date,
        string      $now = 'now'
    ): string {
        $date = $date instanceof \DateTimeInterface ? $date : twig_date_converter($env, $date);
        $now = $now instanceof \DateTimeInterface ? $now : twig_date_converter($env, $now);

        $diff = $date->diff($now);
        foreach (self::$units as $attribute => $unit) {
            $count = $diff->$attribute;
            if ($count !== 0) {
                return $this->getPluralizedInterval($count, $diff->invert, $unit);
            }
        }
        return 'just now';
    }

    private function getPluralizedInterval(
        int    $count,
        int    $invert,
        string $unit
    ): string {
        $key = sprintf('diff.%s.%s', $invert ? 'in' : 'ago', $unit);
        $translationCount = ['%count%' => $count];

        return $this->translator ?
            $this->translator->trans($key, $translationCount, 'date') :
            $this->formatWithoutTranslation($count, $invert, $unit);
    }

    private function formatWithoutTranslation(
        int    $count,
        int    $invert,
        string $unit
    ): string {
        $unit .= $count === 1 ? '' : 's';
        return $invert ? "in $count $unit" : "$count $unit ago";
    }
}
