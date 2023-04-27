<?php
declare(strict_types=1);

namespace CustomTwigBundle\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert')]
class Alert{

    public string $type = 'success';
    public string $message;
}
