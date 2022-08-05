<?php

namespace App\Twig;

use App\Service\ExcerptService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ExcerptExtension extends AbstractExtension
{
    public function __construct(
        private ExcerptService $excerptService
    ){}
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    public function getFunctions(): array
    {
        return [
//            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function excerpt(string $value): string
    {
        return $this->excerptService->excerpt($value);
    }
}
