<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Filesystem\Filesystem;

class TwigBootstrapSvgIcon extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'twigExtensionBootstrapSvgIcon',
                [$this, 'getBootstrapSvgIcon'], ['is_safe' => ['html']])
        ];
    }

    public function getBootstrapSvgIcon(
        string $biName = 'bootstrap',
        string $fill = 'currentColor',
        float  $biSize = 1.6
    ): string
    {

        $filesystem = new Filesystem();
        $iconFile = 'build/svg/bootstrap-icons.svg';

        if (!$filesystem->exists($iconFile)) {
            $iconFile = 'bundles/pimcorecustomtwig/svg/bootstrap-icons.svg';
        }

        $svgFile = [];
        $svgFile[] .= '<svg class="bi bi-' . $biName . '"';
        $svgFile[] .= 'width="' . $biSize . 'rem" height="' . $biSize . 'rem" viewBox="0 0 ' . $biSize * 10 . ' ' . $biSize * 10 . '"';
        $svgFile[] .= 'fill="' . $fill . '">';
        $svgFile[] .= '<use xlink:href="' . $iconFile . '#' . $biName . '"></use>';
        $svgFile[] .= '</svg>';

        return join($svgFile);
    }

}
