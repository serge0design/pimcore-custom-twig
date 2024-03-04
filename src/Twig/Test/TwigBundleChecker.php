<?php

declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Test;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TwigBundleChecker extends AbstractExtension
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('twigTestBundleChecker', [$this, 'getBundleChecker']),
        ];
    }

    public function getBundleChecker(string $bundle): bool
    {
        return array_key_exists(
            $bundle,
            $this->container->getParameter('kernel.bundles')
        );
    }

}
