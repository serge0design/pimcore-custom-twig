<?php

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Pimcore\Model\Asset\Image;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigImages extends AbstractExtension
{
    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterImgThumbnail',
                [$this, 'getImgThumbnail'],
                ['is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterImgThumbConfig',
                [$this, 'getImgThumbConfig'],
                ['is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterCssBgImg',
                [$this, 'getCssBgImg'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    final public function getImgThumbnail(
        Image  $image = null,
        string $thumbnailName = null,
        string $cssClass = 'img-fluid',
        string $alt = '',
        array  $attrData = []
    ): string {

        $attributes = $this->mergeAttributes([
            "class" => $cssClass,
            "alt" => $alt
        ], $attrData);

        if ($image instanceof Image) {
            if ($thumbnailName) {
                $thumbnail = $image->getThumbnail($thumbnailName);
                if ($thumbnail) {
                    return $thumbnail->getHtml(['imgAttributes' => $attributes]);
                }
            }
            return '<img src="' . htmlspecialchars($image->getFullPath(), ENT_QUOTES, 'UTF-8') . '" ' . $this->htmlAttributes($attributes) . ' />';
        }
        return '';
    }

    final public function getImgThumbConfig(
        Image  $image = null,
        string $cssClass = 'img-fluid',
        string $alt = '',
        int    $width = 250,
        int    $height = null,
        int    $quality = 90,
        string $format = 'webp',
        array  $attrData = [],
        bool   $aspectratio = true
    ): string {

        $attributes = $this->mergeAttributes([
            "class" => $cssClass,
            "alt" => $alt
        ], $attrData);

        $config = [
            "width" => $width,
            "height" => $height,
            "aspectratio" => $aspectratio,
            "quality" => $quality,
            "format" => $format
        ];

        if ($image instanceof Image) {
            $thumbnail = $image->getThumbnail($config);
            if ($thumbnail) {
                return $thumbnail->getHtml(['imgAttributes' => $attributes]);
            }
        }
        return '';
    }

    final public function getCssBgImg(
        Image  $image = null,
        string $thumbnailName = null
    ): string {

        if ($image instanceof Image) {
            $thumb = $image->getThumbnail($thumbnailName);
            if ($thumb) {
                $url = htmlspecialchars($thumb->getPath(), ENT_QUOTES, 'UTF-8');
                return "style=\"background-image: url('{$url}');\"";
            }
        }
        return '';
    }

    private function mergeAttributes(
        array $default,
        array $additional
    ): array {
        return array_merge($default, $additional);
    }

    private function htmlAttributes(
        array $attributes
    ): string {
        $htmlParts = [];
        foreach ($attributes as $key => $value) {
            $htmlParts[] = htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '"';
        }
        return implode(' ', $htmlParts);
    }
}
