<?php

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

    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterUnixTimestampToTime',
                [$this, 'getUnixTimestampToTime'], ['is_safe' => ['html']]),
        ];
    }

    public function getUnixTimestampToTime(int $unixTimeStamp): string
    {

        if (is_numeric($unixTimeStamp)) {

            $days = floor($unixTimeStamp / 86400);
            $hrs = floor($unixTimeStamp / 3600);
            $mins = intval(($unixTimeStamp / 60) % 60);
            $sec = intval($unixTimeStamp % 60);

            if ($days > 1) {
                $stringDays = 'Days';
            } else {
                $stringDays = 'Day';
            }

            if ($days > 0) {
                //echo $days;exit;
                $hrs = str_pad($hrs, 2, '0', STR_PAD_LEFT);
                $hours = $hrs - ($days * 24);
                $return_days = $days . ' ' . $this->translator->trans($stringDays) . ' ';

                $hrs = str_pad($hours, 2, '0', STR_PAD_LEFT);
            } else {
                $return_days = "";
                $hrs = str_pad($hrs, 2, '0', STR_PAD_LEFT);
            }

            $mins = str_pad($mins, 2, '0', STR_PAD_LEFT);

            if ($sec > 0) {
                $sec = ':' . str_pad($sec, 2, '0', STR_PAD_LEFT);
            } else {
                $sec = '';
            }
            return $return_days . $hrs . ":" . $mins . $sec;

        } else {
            return $unixTimeStamp;
        }
    }

}
