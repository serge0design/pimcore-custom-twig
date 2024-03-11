<?php

declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Test;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;
use Pimcore\Model\Asset\Image;

class TwigTests extends AbstractExtension
{
    final public function getTests(): array
    {
        $phpFunctionTests = [
            'IsArray' => 'is_array',
            'IsBoolean' => 'is_bool',
            'IsCallable' => 'is_callable',
            'IsCountable' => 'is_countable',
            'IsDir' => 'is_dir',
            'IsFloat' => 'is_float',
            'IsInt' => 'is_int',
            'IsNumeric' => 'is_numeric',
            'IsNull' => 'is_null',
            'IsObject' => 'is_object',
            'IsResource' => 'is_resource',
            'IsScalar' => 'is_scalar',
            'IsString' => 'is_string',
            'Isset' => 'isset',
        ];

        $tests = array_map(function ($functionName, $testName) {
            return new TwigTest("twigTest{$testName}", $functionName);
        }, $phpFunctionTests, array_keys($phpFunctionTests));

        // Custom Tests
        $tests[] = new TwigTest('pimcoreAssetSvg', [$this, 'isPimcoreAssetSvg']);

        return $tests;
    }

    final public function isPimcoreAssetSvg($value): bool
    {
        return $value instanceof Image && $value->getMimeType() === "image/svg+xml";
    }
}
