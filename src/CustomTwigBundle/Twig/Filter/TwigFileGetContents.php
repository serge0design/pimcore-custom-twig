<?php
//declare(strict_types=1);

namespace CustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFileGetContents extends AbstractExtension
{

    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterFileGetContents',
                [$this, 'getFileGetContents'], ['is_safe' => ['html']])
        ];
    }

    public function getFileGetContents(string $file): string
    {
        $relativPath = "/" . trim($file, '/');
        $rootPath = PIMCORE_WEB_ROOT . $relativPath;
        $assetPath = PIMCORE_ASSET_DIRECTORY . $relativPath;

        if (is_file($rootPath)) {
            return file_get_contents($rootPath);
        }

        if (is_file($assetPath)) {
            return file_get_contents($assetPath);
        }

        return $file;
    }
}
