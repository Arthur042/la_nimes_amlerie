<?php
namespace App\Enum;

/**
 * Class CommentNoteEnum
 *
 * @author ArthurAndré
 */
abstract class CommentNoteEnum
{
    const ONE = 1;
    const TWO = 2;
    const THREE = 3;
    const FOUR = 4;
    const FIVE = 5;

    public static function isValid(int $value): bool
    {
        return in_array($value, [
            self::ONE,
            self::TWO,
            self::THREE,
            self::FOUR,
            self::FIVE,
        ]);
    }

    public static function getValues(): array
    {
        return [
            self::ONE,
            self::TWO,
            self::THREE,
            self::FOUR,
            self::FIVE,
        ];
    }
}