<?php

namespace App\Twig;

use App\Service\GetCartOnLoad;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GetCartOnLoadExtension extends AbstractExtension
{
    public function __construct(
        private GetCartOnLoad $cartOnLoad,
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
            new TwigFunction('get_cart', [$this, 'GetCartOnLoad']),
        ];
    }

    public function GetCartOnLoad()
    {
        $this->cartOnLoad->FindCart();
    }
}
