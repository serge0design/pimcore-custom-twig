<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigEditmodeLinkToObject extends AbstractExtension
{

    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('twigExtensionEditmodeLinkToObject',
                [$this, 'getLinkToObject'], ['is_safe' => ['html']])
        ];
    }

    public function getLinkToObject(int $objectId): string
    {

        $linkToObject = [];
        $linkToObject[] .= '<div class="pimcore_block_options">';
        $linkToObject[] .= '<a class="editObjectLink x-btn pimcore_block_button_options x-unselectable x-btn-default-small x-border-box"';
        $linkToObject[] .= 'href="javascript:parent.pimcore.helpers.openObject(' . $objectId . ',\'object\')">';
        $linkToObject[] .= '<img style="width:2.4rem;" src="/bundles/pimcoreadmin/img/material-icons/outline-edit-24px.svg"';
        $linkToObject[] .= 'title="Edit Object">';
        $linkToObject[] .= '</a>';
        $linkToObject[] .= '</div>';

        return join($linkToObject);
    }
}
