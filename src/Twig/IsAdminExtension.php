<?php

namespace App\Twig;

use App\Service\IsAdmin;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class IsAdminExtension extends AbstractExtension
{
    public function __construct(
        private IsAdmin $isAdmin
    )
    {
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('isAdmin', [$this, 'isAdmin']),
        ];
    }

    public function isAdmin($value): bool
    {
        dump($this->isAdmin->isAdmin($value));
        return $this->isAdmin->isAdmin($value);
    }
}
