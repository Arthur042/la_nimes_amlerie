<?php
namespace App\Enum;

abstract class PanierStatusEnum
{
    const ENCOURS = 100;
    const EXPIRE = 200;
    const COMMANDE = 300;

    public static function isValid(int $value): bool
    {
        return in_array($value, [
            self::ENCOURS,
            self::EXPIRE,
            self::COMMANDE,
        ]);
    }
}