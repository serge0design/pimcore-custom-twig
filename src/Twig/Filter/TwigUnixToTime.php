<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Pimcore\Translation\Translator;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class TwigUnixToTime extends AbstractExtension
{
    protected Translator $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterUnixTimestampToTime',
                [$this, 'unixTimestampToTime'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    final public function unixTimestampToTime(
        int $unixTimestamp
    ): string {
        $time = new \DateTime("@$unixTimestamp");
        $now = new \DateTime('now');
        $interval = $now->diff($time);

        $parts = [];
        if ($interval->days > 0) {
            $parts[] = $interval->format('%a') . ' ' . $this->translator->trans($interval->days > 1 ? 'Days' : 'Day');
        }

        // Format hours and minutes
        $parts[] = $interval->format('%H:%I');

        // Optionally include seconds
        if ($interval->s > 0) {
            $parts[] = $interval->format('%S');
        }

        return implode(':', $parts);
    }
}
