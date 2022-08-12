<?php

namespace App\Service;

class Star
{
    public function star($raiting)
    {
        $stars = [];

        if ($raiting === 0) {
            for ($i = 0; $i < 5; $i++) {
                $stars[] = '<i class="fa-regular fa-star"></i>';
            }
        } elseif ($raiting > 0 && $raiting <= 0.5){
            $stars = [
                '<i class="fas fa-star-half-stroke"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 0.5 && $raiting <= 1) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 1 && $raiting <= 1.5) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star-half-stroke"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 1.5 && $raiting <= 2) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 2 && $raiting <= 2.5) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star-half-stroke"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 2.5 && $raiting <= 3) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 3 && $raiting <= 3.5) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star-half-stroke"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 3.5 && $raiting <= 4) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fa-regular fa-star"></i>',
            ];
        } elseif ($raiting > 4 && $raiting <= 4.5) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star-half-stroke"></i>',
            ];
        } elseif ($raiting > 4.5 && $raiting <= 5) {
            $stars = [
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
                '<i class="fas fa-star"></i>',
            ];
        }

        $stars = implode('', $stars);

        return $stars;
    }
}