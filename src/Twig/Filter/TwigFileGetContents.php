<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFileGetContents extends AbstractExtension
{
    private string $assetsDirectory;

    public function __construct(
        private string $webRoot = PIMCORE_WEB_ROOT
    ) {
        $this->assetsDirectory = $this->webRoot . '/var/assets';
    }

    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterFileGetContents',
                [$this, 'getFileContents'],
                ['is_safe' => ['html']]
            )
        ];
    }

    final public function getFileContents(string $file): string
    {
        $filePath = $this->getFilePath($file);

        if (is_file($filePath) && is_readable($filePath)) {
            return file_get_contents($filePath);
        }

        return '';
    }

    private function getFilePath(string $file): string
    {
        // Prevent directory traversal
        $file = basename($file);

        // Here you can add more checks, for example, file extension checks for added security
        $assetPath = $this->assetsDirectory . '/' . trim($file, '/');
        if (is_file($assetPath) && is_readable($assetPath)) {
            return $assetPath;
        }

        // Fallback to checking in the web root if not found in assets
        $rootPath = $this->webRoot . '/' . trim($file, '/');
        if (is_file($rootPath) && is_readable($rootPath)) {
            return $rootPath;
        }

        return '';
    }
}
