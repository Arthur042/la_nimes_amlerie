<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CategoriesExtension extends AbstractExtension
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ){}
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
//            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('main_categories', [$this, 'findMainCategories']),
        ];
    }

    public function findMainCategories()
    {
        return $this->categoryRepository->findMainCategories();
    }
}
