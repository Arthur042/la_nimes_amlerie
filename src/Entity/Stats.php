<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Statistique\GetAbandonnedBagAction;
use App\Controller\Statistique\TotalSellAction;
use App\Controller\Statistique\TotalCommandNumberAction;
use App\Controller\Statistique\TotalBagNumberAction;
use App\Controller\Statistique\BagMoyAction;
use App\Controller\Statistique\NewClientAction;
use App\Controller\Statistique\CommandAgainAction;
use App\Controller\Statistique\ConversionOrderedAction;
use App\Controller\Statistique\ConversionBagAction;
use App\Controller\Statistique\ProductSellListAction;
use App\Controller\Statistique\NumberVisitorsAction;

#[ApiResource(
    collectionOperations: [
        'get_panier_abandonne' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/bag_abandoned',
            'controller' => GetAbandonnedBagAction::class,
        ],
        'total_sell' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/total_sell',
            'controller' => TotalSellAction::class,
        ],
        'total_ordered' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/total_ordered',
            'controller' => TotalCommandNumberAction::class,
        ],
        'total_bag' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/total_bag',
            'controller' => TotalBagNumberAction::class,
        ],
        'moy_bag' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/moy_bag',
            'controller' => BagMoyAction::class,
        ],
        'new_client' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/new_client',
            'controller' => NewClientAction::class,
        ],
        'recurrance_ordered' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/recurrance_ordered',
            'controller' => CommandAgainAction::class,
        ],
        'conversion_ordered' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/conversion_ordered',
            'controller' => ConversionOrderedAction::class,
        ],
        'conversion_bag' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/conversion_bag',
            'controller' => ConversionBagAction::class,
        ],
        'products_sell_list' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/products_sell_list',
            'controller' => ProductSellListAction::class,
        ],
        'number_visitors' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/number_visitors',
            'controller' => NumberVisitorsAction::class,
        ],
    ],
    itemOperations: [],
)]
class Stats
{
    
}
