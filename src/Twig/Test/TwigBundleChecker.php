<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Test;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class TwigBundleChecker extends AbstractExtension
{
    private array $bundles;

    public function __construct(array $bundles)
    {
        $this->bundles = $bundles;
    }

    final public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'twigTestBundleChecker',
                [$this, 'isBundleRegistered']
            ),
        ];
    }

    final public function isBundleRegistered(
        string $bundle
    ): bool {
        return array_key_exists($bundle, $this->bundles);
    }
}
