<?php

namespace App\Twig;

use App\Service\FindContainLine;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FindContainLineToCartExtension extends AbstractExtension
{

    public function __construct(
        private FindContainLine $containLine,
    ){}

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('find_contains', [$this, 'doSomething']),
        ];
    }

    public function doSomething()
    {
        return $this->containLine->GetContaiLine();
    }
}
