<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Filesystem\Filesystem;

class TwigBootstrapSvgIcon extends AbstractExtension
{
    private Filesystem $filesystem;
    private string $basePath;

    public function __construct(string $basePath = 'bundles/pimcorecustomtwig/svg/')
    {
        $this->filesystem = new Filesystem();
        $this->basePath = $basePath;
    }

    final public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'twigExtensionBootstrapSvgIcon',
                [$this, 'getBootstrapSvgIcon'],
                ['is_safe' => ['html']]
            )
        ];
    }

    final public function getBootstrapSvgIcon(
        string $biName = 'bootstrap',
        string $fill = 'currentColor',
        float  $biSize = 1.6
    ): string {
        $iconFile = $this->basePath . 'bootstrap-icons.svg';

        if (!$this->filesystem->exists($iconFile)) {
            // Optionally handle the error or fallback
            return ''; // Early return on file not found
        }

        return <<<HTML
                <svg class="bi bi-{$biName}"
                    width="{$biSize}rem"
                    height="{$biSize}rem"
                    viewBox="0 0 {$biSize} {$biSize}"
                    fill="{$fill}">
                    <use xlink:href="{$iconFile}#{$biName}"></use>
                </svg>
                HTML;
    }
}
