<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;

class PimcoreCustomTwigBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public const PACKAGE_NAME = 'serge0design/pimcore-custom-twig';

    final protected function getComposerPackageName(): string
    {
        return self::PACKAGE_NAME;
    }

    final public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
