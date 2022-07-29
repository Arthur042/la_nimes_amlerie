<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Enum\PanierStatusEnum;
use App\Controller\Statistique\GetAbandonnedBagAction;
use App\Controller\Statistique\TotalSellAction;
use App\Controller\Statistique\TotalCommandNumberAction;
use App\Controller\Statistique\TotalBagNumberAction;

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
        'total_command' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/total_command',
            'controller' => TotalCommandNumberAction::class,
        ],
        'total_bag' => [
            'security' => 'is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/total_bag',
            'controller' => TotalBagNumberAction::class,
        ],
    ],
    itemOperations: [],
)]
class Stats
{
    
}
