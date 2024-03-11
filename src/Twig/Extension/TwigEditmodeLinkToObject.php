<?php
declare(strict_types=1);

namespace SergeDesign\PimcoreCustomTwigBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Pimcore\Http\Request\Resolver\EditmodeResolver;
use Symfony\Component\HttpFoundation\RequestStack;

class TwigEditmodeLinkToObject extends AbstractExtension
{
    private string $iconPath = '/bundles/pimcoreadmin/img/material-icons/outline-edit-24px.svg';
    private EditmodeResolver $editmodeResolver;
    private RequestStack $requestStack;

    public function __construct(EditmodeResolver $editmodeResolver, RequestStack $requestStack)
    {
        $this->editmodeResolver = $editmodeResolver;
        $this->requestStack = $requestStack;
    }

    final public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'twigExtensionEditmodeLinkToObject',
                [$this, 'getLinkToObject'],
                ['is_safe' => ['html']]
            )
        ];
    }

    final public function getLinkToObject(int $objectId): string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request || !$this->editmodeResolver->isEditmode($request)) {
            // Return an empty string if not in edit mode or if request is null
            return '';
        }

        $objectId = htmlspecialchars((string)$objectId, ENT_QUOTES, 'UTF-8');
        $iconPath = htmlspecialchars($this->iconPath, ENT_QUOTES, 'UTF-8');

        return <<<HTML
            <div class="pimcore_block_options">
                <a class="editObjectLink x-btn pimcore_block_button_options x-unselectable x-btn-default-small x-border-box" href="javascript:parent.pimcore.helpers.openObject($objectId,'object')">
                    <img style="width:2.4rem;" src="$iconPath" title="Edit Object" alt="Edit Object">
                </a>
            </div>
        HTML;
    }
}
