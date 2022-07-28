<?php
namespace App\Enum;

/**
 * Class PanierStatusEnum
 *
 * @author ArthurAndré
 */
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

    public static function getValues(): array
    {
        return [
            self::ENCOURS,
            self::EXPIRE,
            self::COMMANDE,
        ];
    }
}