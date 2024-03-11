<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    final public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('pimcore_custom_twig');
    }
}
