<?php

namespace App\Twig;

use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SubCategoriesExtension extends AbstractExtension
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
            new TwigFilter('sub_categories', [$this, 'findSubCategories']),
        ];
    }

    public function getFunctions(): array
    {
        return [
//            new TwigFunction('sub_categories', [$this, 'findSubCategories']),
        ];
    }

    public function findSubCategories($value)
    {
        return $this->categoryRepository->findSubCategories($value);
    }
}
