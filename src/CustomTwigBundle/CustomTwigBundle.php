<?php

namespace CustomTwigBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class CustomTwigBundle extends AbstractPimcoreBundle
{
    public const PACKAGE_NAME = 'serge0design/pimcore-custom-twig';

    protected function getComposerPackageName(): string
    {
        return self::PACKAGE_NAME;
    }

    public function getDescription()
    {
        return '';
    }

    public function getVersion()
    {
        return '1.0.0';
    }
}
