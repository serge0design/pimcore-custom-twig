<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Pimcore\Model\Asset;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Pimcore\Model\Asset\Thumbnail\ImageThumbnailTrait;

class TwigImages extends AbstractExtension
{

    use ImageThumbnailTrait;

    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterImgThumbnail', [$this, 'getImgThumbnail'], ['is_safe' => ['html']]),
            new TwigFilter('twigFilterImgThumbConfig', [$this, 'getImgThumbConfig'], ['is_safe' => ['html']]),
            new TwigFilter('twigFilterCssBgImg', [$this, 'getCssBgImg'], ['is_safe' => ['html']]),
        ];
    }

    public function getImgThumbnail(
        object $image,
        string $thumbnailName = null,
        string $cssClass = 'img-fluid',
        string $alt = '',
        array  $attrData = [],
    ): string|object
    {
        if ($image->getImage() instanceof Asset\Image) {
            $attributes = ["class" => $cssClass, "alt" => $alt];
            $array = array_merge($attributes, $attrData);

            $img = $image->getThumbnail($thumbnailName)->getHtml(['imgAttributes' => $array]);
            return $img;

        } else {

            return $image;
        }
    }

    public function getImgThumbConfig(
        object $image,
        string $cssClass = 'img-fluid',
        string $alt = '',
        int    $width = 250,
        int    $height = null,
        int    $quality = 90,
        string $format = 'webp',
        array  $attrData = [],
        bool   $aspectratio = true,
    ): string|object
    {
        if ($image->getImage() instanceof Asset\Image) {
            $attributes = ["class" => $cssClass, "alt" => $alt];
            $array = array_merge($attributes, $attrData);

            $img = $image->getThumbnail([
                "width" => $width,
                "height" => $height,
                "aspectratio" => $aspectratio,
                "quality" => $quality,
                "format" => $format
            ])->getHtml(['imgAttributes' => $array]);

            return $img;
        } else {
            return $image;
        }
    }

    public function getCssBgImg(
        object $image,
        string $thumbnailName = null,
    ): string
    {
        if ($image->getImage() instanceof Asset\Image) {
            $thumb = $image->getThumbnail($thumbnailName);

            return ' style="background-image: url(' . $thumb . ');" ';
        }

        return '';
    }

}
