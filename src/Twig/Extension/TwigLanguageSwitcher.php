<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Extension;

use Pimcore\Model\Document;
use Pimcore\Model\Document\Service;
use Pimcore\Tool;
use Psr\Log\LoggerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigLanguageSwitcher extends AbstractExtension
{
    /**
     * @var Service
     */
    private Service $documentService;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(Service $documentService, LoggerInterface $logger)
    {
        $this->documentService = $documentService;
        $this->logger = $logger;
    }

    /**
     * Registers Twig functions provided by this extension.
     *
     * @return array An array of TwigFunction instances.
     */
    final public function getFunctions(): array
    {
        return [
            new TwigFunction('twigExtensionLocalizedLinks', [$this, 'getLocalizedLinks']),
            new TwigFunction('twigExtensionLanguageFlag', [$this, 'getLanguageFlag'])
        ];
    }

    /**
     * Fetches localized links for a given document.
     *
     * @param Document $document The document to fetch localized links for.
     * @return array An array of localized links, with language codes as keys and details as values.
     */
    final public function getLocalizedLinks(Document $document): array
    {
        try {
            $translations = $this->documentService->getTranslations($document);
            $validLanguages = Tool::getValidLanguages();
            $links = [];

            foreach ($validLanguages as $language) {
                $target = '/' . $language;

                if (!(Document::getByPath($target) instanceof Document)) {
                    continue;
                }

                if (isset($translations[$language])) {
                    $localizedDocument = Document::getById($translations[$language]);
                    if ($localizedDocument) {
                        $target = $localizedDocument->getFullPath();
                    }
                }

                $links[$language] = [
                    'link' => $target,
                    'text' => \Locale::getDisplayLanguage($language)
                ];
            }

            return $links;
        } catch (\Exception $e) {
            $this->logger->error('Error fetching localized links: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Retrieves the web path to a flag icon for the specified language.
     *
     * @param string $language The language code.
     * @return string The web path to the language's flag icon.
     */
    final public function getLanguageFlag(string $language): string
    {
        $flag = '';
        try {
            if (Tool::isValidLanguage($language)) {
                $flag = self::getLanguageFlagFile($language);
            }
            $flag = preg_replace('@^' . preg_quote(PIMCORE_WEB_ROOT, '@') . '@', '', $flag);
        } catch (\Exception $e) {
            $this->logger->error('Error fetching language flag: ' . $e->getMessage());
        }

        return $flag;
    }

    /**
     * Determines the file path for a given language's flag icon.
     *
     * @param string $language The language code.
     * @return string The file path for the flag icon.
     */
    public static function getLanguageFlagFile(string $language): string
    {
        $basePath = '/bundles/pimcoreadmin/img/flags';
        $code = strtolower($language);
        $iconPath = $basePath . '/countries/_unknown.svg';

        $languageCountryMapping = self::getLanguageCountryMapping();

        if (array_key_exists($code, $languageCountryMapping)) {
            $iconPath = $basePath . '/countries/' . $languageCountryMapping[$code] . '.svg';
        }

        return $iconPath;
    }

    /**
     * Returns a mapping of language codes to their corresponding country code for flag icons.
     *
     * @return array The mapping of language codes to country codes.
     */
    private static function getLanguageCountryMapping(): array
    {
        return [
            'aa' => 'er', 'af' => 'za', 'am' => 'et', 'as' => 'in', 'ast' => 'es', 'asa' => 'tz',
            'az' => 'az', 'bas' => 'cm', 'eu' => 'es', 'be' => 'by', 'bem' => 'zm', 'bez' => 'tz', 'bg' => 'bg',
            'bm' => 'ml', 'bn' => 'bd', 'br' => 'fr', 'brx' => 'in', 'bs' => 'ba', 'cs' => 'cz', 'da' => 'dk',
            'de' => 'de', 'dz' => 'bt', 'el' => 'gr', 'en' => 'gb', 'es' => 'es', 'et' => 'ee', 'fi' => 'fi',
            'fo' => 'fo', 'fr' => 'fr', 'ga' => 'ie', 'gv' => 'im', 'he' => 'il', 'hi' => 'in', 'hr' => 'hr',
            'hu' => 'hu', 'hy' => 'am', 'id' => 'id', 'ig' => 'ng', 'is' => 'is', 'it' => 'it', 'ja' => 'jp',
            'ka' => 'ge', 'os' => 'ge', 'kea' => 'cv', 'kk' => 'kz', 'kl' => 'gl', 'km' => 'kh', 'ko' => 'kr',
            'lg' => 'ug', 'lo' => 'la', 'lt' => 'lt', 'mg' => 'mg', 'mk' => 'mk', 'mn' => 'mn', 'ms' => 'my',
            'mt' => 'mt', 'my' => 'mm', 'nb' => 'no', 'ne' => 'np', 'nl' => 'nl', 'nn' => 'no', 'pl' => 'pl',
            'pt' => 'pt', 'ro' => 'ro', 'ru' => 'ru', 'sg' => 'cf', 'sk' => 'sk', 'sl' => 'si', 'sq' => 'al',
            'sr' => 'rs', 'sv' => 'se', 'swc' => 'cd', 'th' => 'th', 'to' => 'to', 'tr' => 'tr', 'tzm' => 'ma',
            'uk' => 'ua', 'uz' => 'uz', 'vi' => 'vn', 'zh' => 'cn', 'gd' => 'gb-sct', 'gd-gb' => 'gb-sct',
            'cy' => 'gb-wls', 'cy-gb' => 'gb-wls', 'fy' => 'nl', 'xh' => 'za', 'yo' => 'bj', 'zu' => 'za',
            'ta' => 'lk', 'te' => 'in', 'ss' => 'za', 'sw' => 'ke', 'so' => 'so', 'si' => 'lk', 'ii' => 'cn',
            'zh-hans' => 'cn', 'sn' => 'zw', 'rm' => 'ch', 'pa' => 'in', 'fa' => 'ir', 'lv' => 'lv', 'gl' => 'es',
            'fil' => 'ph'
        ];
    }
}
