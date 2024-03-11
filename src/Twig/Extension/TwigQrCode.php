<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Extension;

use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeEnlarge;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelQuartile;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Pimcore\Translation\Translator;

class TwigQrCode extends AbstractExtension
{
    protected Translator $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    final public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'twigExtensionQrImage',
                [$this, 'getQrImg'],
                ['is_safe' => ['html']]
            )
        ];
    }

    final public function getQrImg(
        string $qrData,
        int    $size = 150,
        int    $margin = 0,
        array  $qrColor = [0, 0, 0],
        array  $bgColor = [255, 225, 255]
    ): string {

        $src = $this->getQrData($qrData, $size, $margin, $qrColor, $bgColor)->getDataUri();
        $alt = $this->translator->trans("scan me");

        return <<<HTML
            <img class="img-fluid img-qr-code" src="$src" alt="$alt"/>
        HTML;
    }

    final public function getQrData(
        string $data,
        int    $size,
        int    $margin,
        array  $qrColor,
        array  $bgColor
    ): ResultInterface {
        $writer = new SvgWriter();
        $qrCode = QrCode::create($data)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelQuartile())
            ->setSize($size)
            ->setMargin($margin)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeEnlarge())
            ->setForegroundColor(new Color($qrColor[0], $qrColor[1], $qrColor[2]))
            ->setBackgroundColor(new Color($bgColor[0], $bgColor[1], $bgColor[2]));

        return $writer->write($qrCode);
    }
}
