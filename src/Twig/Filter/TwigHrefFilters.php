<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Filter;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use SergeDesign\PimcoreCustomTwigBundle\Twig\Extension\TwigBootstrapSvgIcon;

class TwigHrefFilters extends AbstractExtension
{

    /**
     * {@inheritdoc}
     */
    final public function getFilters(): array
    {
        return [
            new TwigFilter(
                'twigFilterHrefUrl',
                [$this, 'getHrefUrl'],
                ['is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterHrefEmail',
                [$this, 'getHrefEmail'],
                ['is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterHrefPhone',
                [$this, 'getHrefPhone'],
                ['is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterHrefWhatsApp',
                [$this, 'getHrefWhatsApp'],
                ['is_safe' => ['html']]
            ),
            new TwigFilter(
                'twigFilterHrefSocialMedia',
                [$this, 'getHrefSocialMedia'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    final public function getHrefUrl(
        string $url,
        string $class = '',
        string $target = '_blank'
    ): string {

        $classAttribute = $class ? 'class="' . htmlspecialchars($class) . '"' : '';
        $cleanUrl = htmlspecialchars($url);
        $displayUrl = htmlspecialchars(str_replace(['http://', 'https://'], '', $url));

        return "<a href=\"{$cleanUrl}\" {$classAttribute} target=\"{$target}\">{$displayUrl}</a>";
    }

    final public function getHrefEmail(
        string $email,
        string $class = '',
        string $subject = '',
        string $body = '',
        string $cc = '',
        string $bcc = ''
    ): string {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return htmlspecialchars($email);
        }
        $href = "mailto:" . urlencode($email);
        $href .= $subject ? '?subject=' . urlencode($subject) : '';
        $href .= $body ? ($subject ? '&' : '?') . 'body=' . urlencode($body) : '';
        $href .= $cc ? ($subject || $body ? '&' : '?') . 'cc=' . urlencode($cc) : '';
        $href .= $bcc ? ($subject || $body || $cc ? '&' : '?') . 'bcc=' . urlencode($bcc) : '';

        $classAttribute = $class ? ' class="' . htmlspecialchars($class) . '"' : '';
        $emailDisplay = htmlspecialchars($email);

        return "<a href=\"{$href}\"{$classAttribute}>{$emailDisplay}</a>";
    }

    final public function getHrefPhone(
        string $phone,
        string $hrefPrefix = 'tel:',
        string $countryCode = '+41',
    ): string {
        return $this->getPhoneBaseLink($phone, $hrefPrefix, $countryCode);
    }

    final public function getHrefWhatsApp(
        string $phone,
        string $hrefPrefix = 'https://wa.me/',
        string $countryCode = '+41'
    ): string {
        return $this->getPhoneBaseLink($phone, $hrefPrefix, $countryCode);
    }

    final public function getPhoneBaseLink(
        string $phone,
        string $hrefPrefix,
        string $countryCode
    ): string {
        $sanitizedNumber = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        $sanitizedNumber = ltrim($sanitizedNumber, '0');
        $fullNumber = $countryCode . $sanitizedNumber;

        if (!preg_match('/^\+[0-9]{10,}$/', $fullNumber)) {
            return htmlspecialchars($phone);
        }

        $href = $hrefPrefix . $fullNumber;
        $phoneDisplay = htmlspecialchars($phone);
        $target = str_contains($hrefPrefix, 'https') ? ' target="_blank"' : '';

        return "<a href=\"{$href}\"{$target}>{$phoneDisplay}</a>";
    }

    final public function getHrefSocialMedia(
        string $url,
        string $name = 'bootstrap'
    ): string {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return htmlspecialchars($url);
        }

        $cleanUrl = htmlspecialchars($url);
        $icon = (new TwigBootstrapSvgIcon())->getBootstrapSvgIcon($name); // Consider Dependency Injection

        return "<a target=\"_blank\" href=\"{$cleanUrl}\" class=\"sm-link {$name}\">{$icon}</a>";
    }
}
