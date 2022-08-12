<?php

namespace App\Service;

class ExcerptService
{
    public function excerpt(string $value, int $length): string
    {
        return (strlen($value) <= $length) ? $value : substr($value, 0, $length) . '...';
    }
}