<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class TwigStringFilters extends AbstractExtension
{

    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterGetMd5',
                [$this, 'getMd5']
            ),
            new TwigFilter(
                'twigFilterGetUniqid',
                [$this, 'getUniqid']
            ),
            new TwigFilter(
                'twigFilterStringNormalizer',
                [$this, 'getStringNormalizer']
            ),
            new TwigFilter(
                'twigFilterStrToLower',
                'strtolower'
            ),
            new TwigFilter(
                'twigFilterStrToUpper',
                'strtoupper'
            ),
            new TwigFilter(
                'twigFilterStrCapitalize',
                'ucwords'
            ),
            new TwigFilter(
                'twigFilterNormalizeFolderName',
                [$this, 'getNormalizeFolderName']
            ),
        ];
    }

    final public function getMd5(
        string $string,
        bool   $binary = false
    ): string {
        return md5($string, $binary);
    }

    final public function getUniqId(
        string $prefix = '',
        bool   $moreEntropy = false
    ): string {
        return uniqid($prefix, $moreEntropy);
    }

    final public function getNormalizeFolderName(
        string $string
    ): string {
        return strtolower($this->getStringNormalizer($string));
    }


    public static function getStringNormalizer(
        string $string
    ): string {
        $normalized = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

        $search = ['~', '¨', '^', '?', '\'', '"', '/', '-', '+', '.', ',', ';', '(', ')', ' ', '&', 'ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', 'ß', 'É', 'é', 'È', 'è', 'Ê', 'ê', 'E', 'e', 'Ë', 'ë',
            'À', 'à', 'Á', 'á', 'Å', 'å', 'a', 'Â', 'â', 'Ã', 'ã', 'ª', 'Æ', 'æ', 'C', 'c', 'Ç', 'ç', 'C', 'c', 'Í', 'í', 'Ì', 'ì', 'Î', 'î', 'Ï', 'ï',
            'Ó', 'ó', 'Ò', 'ò', 'Ô', 'ô', 'º', 'Õ', 'õ', 'Œ', 'O', 'o', 'Ø', 'ø', 'Ú', 'ú', 'Ù', 'ù', 'Û', 'û', 'U', 'u', 'U', 'u', 'Š', 'š', 'S', 's',
            'Ž', 'ž', 'Ñ', 'ñ', '¡', '¿', 'Ÿ', 'ÿ', '_', ':'];
        $replace = ['', '', '', '', '', '', '', '-', '', '', '-', '-', '', '', '-', '', 'ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e',
            'A', 'a', 'A', 'a', 'A', 'a', 'a', 'A', 'a', 'A', 'a', 'a', 'AE', 'ae', 'C', 'c', 'C', 'c', 'C', 'c', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i',
            'O', 'o', 'O', 'o', 'O', 'o', 'o', 'O', 'o', 'OE', 'O', 'o', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'S', 's', 'S', 's',
            'Z', 'z', 'N', 'n', '', '', 'Y', 'y', '-', '-'];

        $normalized = str_replace($search, $replace, $normalized);
        $normalized = preg_replace('/[^a-zA-Z0-9\-]/', '', $normalized);

        return $normalized;
    }
}
