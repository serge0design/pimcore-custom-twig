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
    public function getFilters(): array
    {
        return [
            new TwigFilter('twigFilterHrefUrl',
                [$this, 'getHrefUrl'], ['is_safe' => ['html']]),
            new TwigFilter('twigFilterHrefEmail',
                [$this, 'getHrefEmail'], ['is_safe' => ['html']]),
            new TwigFilter('twigFilterHrefPhone',
                [$this, 'getHrefPhone'], ['is_safe' => ['html']]),
            new TwigFilter('twigFilterHrefWhatsApp',
                [$this, 'getHrefWhatsApp'], ['is_safe' => ['html']]),
            new TwigFilter('twigFilterHrefSocialMedia',
                [$this, 'getHrefSocialMedia'], ['is_safe' => ['html']]),
        ];
    }

    public function getHrefUrl(
        string $url,
        string $class = '',
        string $target = '_blank'
    ): string
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $webLink = [];
            $webLink[] .= '<a href="' . $url . '"';
            $webLink[] .= $class != '' ? 'class="' . $class . '"' : '';
            $webLink[] .= ' target="' . $target . '">';
            $webLink[] .= str_replace(['http://', 'https://'], '', $url);
            $webLink[] .= '</a>';

            return join($webLink);
        } else {

            return $url;
        }
    }

    public function getHrefEmail(
        string $email,
        string $class = '',
        string $subject = '',
        string $body = '',
        string $cc = '',
        string $bcc = ''
    ): string
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $emailLink = [];
            $emailLink[] .= '<a';
            $emailLink[] .= $class != '' ? ' class="' . $class . '"' : '';
            $emailLink[] .= ' href="' . $this->strToASCII('mailto:' . $email);
            $emailLink[] .= $subject != '' ? '?subject=' . $subject : '';
            $emailLink[] .= $body != '' ? '&body=' . $body : '';
            $emailLink[] .= $cc != '' && filter_var($cc, FILTER_VALIDATE_EMAIL) ? '&cc=' . $this->strToASCII($cc) : '';
            $emailLink[] .= $bcc != '' && filter_var($bcc, FILTER_VALIDATE_EMAIL) ? '&bcc=' . $this->strToASCII($bcc) : '';
            $emailLink[] .= '">';
            $emailLink[] .= $this->strToASCII($email);
            $emailLink[] .= '</a>';

            return join($emailLink);

        } else {

            return $email;
        }
    }

    public function getHrefPhone(
        string $phone,
        string $hrefPrefix = 'tel:',
        string $countryCode = '+41',
    ): string
    {
        return $this->getPhoneBaseLink($phone, $hrefPrefix, $countryCode);
    }

    public function getHrefWhatsApp(
        string $phone,
        string $hrefPrefix = 'https://wa.me/',
        string $countryCode = '+41'
    ): string
    {
        return $this->getPhoneBaseLink($phone, $hrefPrefix, $countryCode);
    }

    public function getPhoneBaseLink(
        string $phone,
        string $hrefPrefix,
        string $countryCode
    ): string
    {
        $nrToSanitize = $phone;
        $number = filter_var($nrToSanitize, FILTER_SANITIZE_NUMBER_INT);

        if (preg_match('/^[0-9]{10}+$/', $number)) {

            $phoneLink = [];
            $phoneLink[] .= '<a href="';
            $phoneLink[] .= $this->strToASCII($hrefPrefix . $countryCode . ltrim($number, '0')) . '"';
            $phoneLink[] .= (str_contains($hrefPrefix, 'https') ? ' target="_blank"' : '');
            $phoneLink[] .= '>';
            $phoneLink[] .= $this->strToASCII($phone);
            $phoneLink[] .= '</a>';

            return join($phoneLink);

        } else {

            return $phone;
        }
    }

    public function getHrefSocialMedia(
        string $url,
        string $name = 'bootstrap'
    ): string
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $smLink = [];
            $smLink[] .= '<a target="_blank" href="' . $url . '"';
            $smLink[] .= 'class="sm-link ' . $name . '">';
            $smLink[] .= (new TwigBootstrapSvgIcon)->getBootstrapSvgIcon($name);
            $smLink[] .= '</a>';

            return join($smLink);
        } else {

            return $url;
        }
    }

    public function strToASCII(string $string): string
    {
        $output = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $output .= '&#' . ord($string[$i]) . ';';
        }
        return $output;
    }

}
