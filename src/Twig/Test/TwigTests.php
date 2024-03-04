<?php

declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Test;

use Twig\TwigTest;
use Twig\Extension\AbstractExtension;
use Pimcore\Model\Asset\Image;

class TwigTests extends AbstractExtension
{

    public function getTests(): array
    {
        return [
            new TwigTest('pimcoreAssetSvg', function (string $value): bool {
                return $value instanceof Image && $value->getMimeType() === "image/svg+xml";
            }),
            new TwigTest('twigTestIsArray', function (mixed $value): bool {
                return is_array($value);
            }),
            new TwigTest('twigTestIsBoolean', function (mixed $value): bool {
                return is_bool($value);
            }),
            new TwigTest('twigTestIsCallable', function (mixed $value): bool {
                return is_callable($value);
            }),
            new TwigTest('twigTestIsCountable', function (mixed $value): bool {
                return is_countable($value);
            }),
            new TwigTest('twigTestIsDir', function (string $value): bool {
                return is_dir($value);
            }),
            new TwigTest('twigTestIsFloat', function (mixed $value): bool {
                return is_float($value);
            }),
            new TwigTest('twigTestIsInt', function (mixed $value): bool {
                return is_int($value);
            }),
            new TwigTest('twigTestIsNumeric', function (mixed $value): bool {
                return is_numeric($value);
            }),
            new TwigTest('twigTestIsNull', function (mixed $value): bool {
                return is_null($value);
            }),
            new TwigTest('twigTestIsObject', function (mixed $value): bool {
                return is_object($value);
            }),
            new TwigTest('twigTestIsResource', function (mixed $value): bool {
                return is_resource($value);
            }),
            new TwigTest('twigTestIsScalar', function (mixed $value): bool {
                return is_scalar($value);
            }),
            new TwigTest('twigTestIsString', function (mixed $value): bool {
                return is_string($value);
            }),
            new TwigTest('twigTestIsset', function (mixed $var): bool {
                return isset($var);
            })
        ];
    }

}

